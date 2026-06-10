<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Evento;
use App\Models\ListaInvitado;
use App\Models\ListaRegalo;
use App\Models\Invitado;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Traer eventos del usuario autenticado
        $user = Auth::user();
        $eventos = $user && $user->eventos ? $user->eventos : collect();
        return view('eventos.invitaciones', compact('eventos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        
        // Obtener listas de invitados disponibles del usuario (asociadas a sus eventos o listas independientes)
        $listasInvitados = ListaInvitado::where(function($q) use ($user) {
            $q->whereHas('evento', function ($query) use ($user) {
                $query->where('usuario_id', $user->id);
            })->orWhereNull('evento_id');
        })->with('invitados')->get();
        
        // Obtener listas de regalos disponibles del usuario
        $listasRegalos = ListaRegalo::where('user_id', $user->id)->with('regalos')->get();
        
        // Obtener imágenes de diseño
        $files = \Illuminate\Support\Facades\Storage::disk('public')->files('regalos/step3-diseno');
        $plantillas = array_map(function($file) {
            return asset('storage/' . $file);
        }, $files);
        
        return view('eventos.create', compact('listasInvitados', 'listasRegalos', 'plantillas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validar datos para guardar el evento
        $validated = $request->validate([
            'slug' => 'nullable|string|max:100|unique:eventos,slug',
            'nombre_bebe' => 'required|string|max:100',
            'genero_bebe' => 'required|in:Niño,Niña,Sorpresa,Múltiple',
            'fecha_evento' => 'required|date',
            'ubicacion_nombre' => 'nullable|string|max:255',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
            'mensaje_invitacion' => 'nullable|string',
            'color_tema' => 'nullable|string|size:7',
            'estado' => 'nullable|in:Borrador,Publicado,Finalizado,Cancelado',
            'imagen_portada_url' => 'nullable|string',
            'imagen_portada' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'lista_invitado_id' => 'nullable|integer|exists:listas_invitados,id',
            'lista_regalos_id' => 'nullable|integer|exists:listas_regalos,id',
            'invitados_json' => 'nullable|json',
        ],
        [
            'slug.unique' => 'El slug ya está en uso.',
            'nombre_bebe.required' => 'El nombre del bebé es obligatorio.',
            'nombre_bebe.string' => 'El nombre del bebé debe ser una cadena de texto.',
            'nombre_bebe.max' => 'El nombre del bebé no puede tener más de 100 caracteres.',
            'genero_bebe.required' => 'El género del bebé es obligatorio.',
            'genero_bebe.in' => 'El género del bebé debe ser uno de los siguientes: Niño, Niña, Sorpresa, Múltiple.',
            'fecha_evento.required' => 'La fecha del evento es obligatoria.',
            'fecha_evento.date' => 'La fecha del evento debe ser una fecha válida.',
            'ubicacion_nombre.string' => 'El nombre de la ubicación debe ser una cadena de texto.',
            'ubicacion_nombre.max' => 'El nombre de la ubicación no puede tener más de 255 caracteres.',
            'lat.numeric' => 'La latitud debe ser un número.',
            'lng.numeric' => 'La longitud debe ser un número.',
            'color_tema.size' => 'El color del tema debe tener exactamente 7 caracteres (ejemplo: #60A5FA).',
            'estado.in' => 'El estado del evento debe ser uno de los siguientes: Borrador, Publicado, Finalizado, Cancelado.',
            'imagen_portada_url.string' => 'La URL de la imagen de portada debe ser una cadena de texto.',
            'imagen_portada_url.max' => 'La URL de la imagen de portada no puede tener más de 500 caracteres.',
            'lista_invitado_id.exists' => 'La lista de invitados seleccionada no existe o no es válida.',
            'lista_regalos_id.exists' => 'La lista de regalos seleccionada no existe o no es válida.',
        ]
        );

        $user = $request->user();
        
        // Validar que la lista de invitados pertenece al usuario (o es independiente)
        if ($validated['lista_invitado_id'] ?? null) {
            $listaInvitado = ListaInvitado::findOrFail($validated['lista_invitado_id']);
            if ($listaInvitado->evento_id !== null && $listaInvitado->evento->usuario_id !== $user->id) {
                return back()->withErrors(['lista_invitado_id' => 'No tienes permiso para usar esta lista de invitados.']);
            }
        }

        // Validar que la lista de regalos pertenece al usuario
        if ($validated['lista_regalos_id'] ?? null) {
            $listaRegalo = ListaRegalo::findOrFail($validated['lista_regalos_id']);
            if ($listaRegalo->user_id !== $user->id) {
                return back()->withErrors(['lista_regalos_id' => 'No tienes permiso para usar esta lista de regalos.']);
            }
        }

        // Subir imagen personalizada si existe
        if ($request->hasFile('imagen_portada')) {
            $path = $request->file('imagen_portada')->store('eventos/portadas', 'public');
            $validated['imagen_portada_url'] = asset('storage/' . $path);
        }

        // Crear el evento
        $evento = $user->eventos()->create($validated);

        // Procesar invitados si se enviaron
        if ($invitadosJson = $request->input('invitados_json')) {
            try {
                $invitados = json_decode($invitadosJson, true);
                
                if (count($invitados) > 0) {
                    $listaInvitadoId = $evento->lista_invitado_id;

                    // Si no se seleccionó ninguna lista de invitados y hay invitados manuales,
                    // crear una lista de invitados por defecto con el nombre del evento
                    if (!$listaInvitadoId) {
                        $nuevaLista = ListaInvitado::create([
                            'evento_id' => $evento->id,
                            'nombre' => 'Lista de ' . $evento->nombre_bebe,
                            'categoria' => 'General',
                        ]);
                        $listaInvitadoId = $nuevaLista->id;
                        $evento->update(['lista_invitado_id' => $listaInvitadoId]);
                    }

                    foreach ($invitados as $invitadoData) {
                        Invitado::create([
                            'evento_id' => $evento->id,
                            'lista_invitado_id' => $listaInvitadoId,
                            'nombre' => $invitadoData['name'] ?? $invitadoData['nombre'] ?? '',
                            'email' => $invitadoData['email'] ?? null,
                            'telefono' => $invitadoData['phone'] ?? $invitadoData['telefono'] ?? null,
                            'estado_invitacion' => 'Pendiente',
                            'estado_asistencia' => 'Sin responder',
                        ]);
                    }
                }
            } catch (\Exception $e) {
                \Log::error('Error al procesar invitados: ' . $e->getMessage());
            }
        }

        return redirect()->route('eventos.index')->with('status', 'Evento creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $evento = Auth::user()->eventos()->with(['invitados', 'listasInvitados', 'regalos', 'listaRegalo.regalos'])->findOrFail($id);
        return view('eventos.show', compact('evento'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Auth::user();
        $evento = $user->eventos()->with('invitados')->findOrFail($id);

        // Obtener listas de invitados disponibles del usuario
        $listasInvitados = ListaInvitado::where(function($q) use ($user) {
            $q->whereHas('evento', function ($query) use ($user) {
                $query->where('usuario_id', $user->id);
            })->orWhereNull('evento_id');
        })->with('invitados')->get();
        
        // Obtener listas de regalos disponibles del usuario
        $listasRegalos = ListaRegalo::where('user_id', $user->id)->with('regalos')->get();
        
        // Obtener imágenes de diseño
        $files = \Illuminate\Support\Facades\Storage::disk('public')->files('regalos/step3-diseno');
        $plantillas = array_map(function($file) {
            return asset('storage/' . $file);
        }, $files);

        return view('eventos.edit', compact('evento', 'listasInvitados', 'listasRegalos', 'plantillas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Auth::user();
        $evento = $user->eventos()->findOrFail($id);

        $validated = $request->validate([
            'slug' => 'nullable|string|max:100|unique:eventos,slug,' . $evento->id,
            'nombre_bebe' => 'required|string|max:100',
            'genero_bebe' => 'required|in:Niño,Niña,Sorpresa,Múltiple',
            'fecha_evento' => 'required|date',
            'ubicacion_nombre' => 'nullable|string|max:255',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
            'mensaje_invitacion' => 'nullable|string',
            'color_tema' => 'nullable|string|size:7',
            'estado' => 'nullable|in:Borrador,Publicado,Finalizado,Cancelado',
            'imagen_portada_url' => 'nullable|string',
            'imagen_portada' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'lista_invitado_id' => 'nullable|integer|exists:listas_invitados,id',
            'lista_regalos_id' => 'nullable|integer|exists:listas_regalos,id',
            'invitados_json' => 'nullable|json',
        ]);

        if ($validated['lista_invitado_id'] ?? null) {
            $listaInvitado = ListaInvitado::findOrFail($validated['lista_invitado_id']);
            if ($listaInvitado->evento_id !== null && $listaInvitado->evento->usuario_id !== $user->id) {
                return back()->withErrors(['lista_invitado_id' => 'No tienes permiso para usar esta lista de invitados.']);
            }
        }

        if ($validated['lista_regalos_id'] ?? null) {
            $listaRegalo = ListaRegalo::findOrFail($validated['lista_regalos_id']);
            if ($listaRegalo->user_id !== $user->id) {
                return back()->withErrors(['lista_regalos_id' => 'No tienes permiso para usar esta lista de regalos.']);
            }
        }

        if ($request->hasFile('imagen_portada')) {
            $path = $request->file('imagen_portada')->store('eventos/portadas', 'public');
            $validated['imagen_portada_url'] = asset('storage/' . $path);
        }

        $evento->update($validated);

        if ($invitadosJson = $request->input('invitados_json')) {
            try {
                $invitadosData = json_decode($invitadosJson, true);
                
                $listaInvitadoId = $evento->lista_invitado_id;
                if (!$listaInvitadoId && count($invitadosData) > 0) {
                    $nuevaLista = ListaInvitado::create([
                        'evento_id' => $evento->id,
                        'nombre' => 'Lista de ' . $evento->nombre_bebe,
                        'categoria' => 'General',
                    ]);
                    $listaInvitadoId = $nuevaLista->id;
                    $evento->update(['lista_invitado_id' => $listaInvitadoId]);
                }

                if ($listaInvitadoId) {
                    // Obtener los invitados actuales para preservarlos o actualizarlos
                    $currentInvitados = Invitado::where('evento_id', $evento->id)->get()->keyBy('email');
                    
                    // Borrar los actuales que pertenecen a este evento específicamente (los reemplazaremos o actualizaremos)
                    // Una forma más limpia es limpiar y recrear, o actualizar. Haremos recrear para simplificar, 
                    // preservando estados si es necesario, pero si el usuario editó la lista, la json es la fuente de la verdad.
                    Invitado::where('evento_id', $evento->id)->delete();
                    
                    foreach ($invitadosData as $inv) {
                        $email = $inv['email'] ?? null;
                        $estado_invitacion = 'Pendiente';
                        $estado_asistencia = 'Sin responder';
                        
                        // Si ya existía este email en el evento, preservar sus estados
                        if ($email && $currentInvitados->has($email)) {
                            $estado_invitacion = $currentInvitados[$email]->estado_invitacion;
                            $estado_asistencia = $currentInvitados[$email]->estado_asistencia;
                        }

                        Invitado::create([
                            'evento_id' => $evento->id,
                            'lista_invitado_id' => $listaInvitadoId,
                            'nombre' => $inv['name'] ?? $inv['nombre'] ?? '',
                            'email' => $email,
                            'telefono' => $inv['phone'] ?? $inv['telefono'] ?? null,
                            'estado_invitacion' => $estado_invitacion,
                            'estado_asistencia' => $estado_asistencia,
                        ]);
                    }
                }
            } catch (\Exception $e) {
                \Log::error('Error al actualizar invitados: ' . $e->getMessage());
            }
        }

        return redirect()->route('eventos.index')->with('status', 'Evento actualizado exitosamente.');
    }

    public function cancel(Request $request, string $id)
    {
        $evento = Auth::user()->eventos()->findOrFail($id);
        $evento->update(['estado' => 'Cancelado']);

        return redirect()->route('eventos.index')->with('status', 'Evento cancelado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //Eliminar evento
        $evento = Auth::user()->eventos()->findOrFail($id);
        $evento->delete();

        return redirect()->route('eventos.index')->with('status', 'Evento eliminado exitosamente.');

    }
}
