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
     * Muestra una lista de las invitaciones y eventos asociados al usuario autenticado.
     *
     * Recupera el usuario autenticado actual y, si existe, obtiene la colección de sus eventos.
     * En caso contrario, genera una colección vacía. Envía esta información a la vista
     * 'eventos.invitaciones' para su renderización.
     *
     * @return \Illuminate\View\View Vista con la lista de eventos del usuario.
     */
    public function index()
    {
        $user = Auth::user();
        $eventos = $user && $user->eventos ? $user->eventos : collect();
        return view('eventos.invitaciones', compact('eventos'));
    }

    /**
     * Muestra el formulario de creación para un nuevo evento de Baby Shower.
     *
     * Obtiene el usuario autenticado y carga todas las listas de invitados creadas por el usuario o 
     * aquellas independientes (sin evento asignado). También recupera las listas de regalos 
     * asociadas al usuario y obtiene las URLs de las plantillas de diseño de invitaciones guardadas 
     * en el almacenamiento público bajo la ruta 'regalos/step3-diseno'. Retorna la vista de 
     * creación con estos conjuntos de datos.
     *
     * @return \Illuminate\View\View Vista del formulario de creación de eventos.
     */
    public function create()
    {
        $user = Auth::user();
        
        $listasInvitados = ListaInvitado::where(function($q) use ($user) {
            $q->whereHas('evento', function ($query) use ($user) {
                $query->where('usuario_id', $user->id);
            })->orWhereNull('evento_id');
        })->with('invitados')->get();
        
        $listasRegalos = ListaRegalo::where('user_id', $user->id)->with('regalos')->get();
        
        $files = \Illuminate\Support\Facades\Storage::disk('public')->files('regalos/step3-diseno');
        $plantillas = array_map(function($file) {
            return asset('storage/' . $file);
        }, $files);
        
        return view('eventos.create', compact('listasInvitados', 'listasRegalos', 'plantillas'));
    }

    /**
     * Valida y almacena un nuevo evento en la base de datos.
     *
     * Realiza la validación de los datos del formulario (slug, nombre del bebé, género, fecha,
     * ubicación, coordenadas, mensaje, color del tema, estado, imágenes y listas asociadas).
     * Verifica que el usuario tenga permisos sobre la lista de invitados y la lista de regalos
     * seleccionadas. Si se sube una portada personalizada, la almacena. Crea el registro del evento 
     * y, en caso de recibir invitados vía JSON, los decodifica e inserta, creando una lista de 
     * invitados por defecto si no se había seleccionado ninguna.
     *
     * @param \Illuminate\Http\Request $request Solicitud HTTP con los datos del evento.
     * @return \Illuminate\Http\RedirectResponse Redirección a la lista de eventos con mensaje de éxito o retorno con errores.
     */
    public function store(Request $request)
    {
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

        $evento = $user->eventos()->create($validated);

        if ($invitadosJson = $request->input('invitados_json')) {
            try {
                $invitados = json_decode($invitadosJson, true);
                
                if (count($invitados) > 0) {
                    $listaInvitadoId = $evento->lista_invitado_id;

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
     * Muestra la información y los detalles de un evento específico.
     *
     * Busca el evento por ID dentro de la colección de eventos que pertenecen al usuario autenticado,
     * cargando de forma optimizada las relaciones de invitados, listas de invitados, regalos
     * e ítems de regalos asociados a la lista de regalos. Devuelve la vista 'eventos.show' con
     * el evento cargado.
     *
     * @param string $id Identificador del evento a consultar.
     * @return \Illuminate\View\View Vista con la información detallada del evento.
     */
    public function show(string $id)
    {
        $evento = Auth::user()->eventos()->with(['invitados', 'listasInvitados', 'regalos', 'listaRegalo.regalos'])->findOrFail($id);
        return view('eventos.show', compact('evento'));
    }

    /**
     * Muestra el formulario para editar un evento específico.
     *
     * Busca el evento perteneciente al usuario autenticado y obtiene los catálogos/opciones
     * necesarias para la modificación: listas de invitados, listas de regalos del usuario
     * y plantillas de diseño desde el disco público de Laravel. Retorna la vista de edición.
     *
     * @param string $id Identificador del evento a editar.
     * @return \Illuminate\View\View Vista con el formulario de edición cargado con la información existente.
     */
    public function edit(string $id)
    {
        $user = Auth::user();
        $evento = $user->eventos()->with('invitados')->findOrFail($id);

        $listasInvitados = ListaInvitado::where(function($q) use ($user) {
            $q->whereHas('evento', function ($query) use ($user) {
                $query->where('usuario_id', $user->id);
            })->orWhereNull('evento_id');
        })->with('invitados')->get();
        
        $listasRegalos = ListaRegalo::where('user_id', $user->id)->with('regalos')->get();
        
        $files = \Illuminate\Support\Facades\Storage::disk('public')->files('regalos/step3-diseno');
        $plantillas = array_map(function($file) {
            return asset('storage/' . $file);
        }, $files);

        return view('eventos.edit', compact('evento', 'listasInvitados', 'listasRegalos', 'plantillas'));
    }

    /**
     * Actualiza los datos de un evento existente en el almacenamiento.
     *
     * Valida los datos entrantes específicos para el evento (permitiendo el slug actual para evitar
     * conflictos de unicidad). Valida los permisos de las listas de invitados y regalos asignadas.
     * Si se detecta un nuevo archivo de imagen de portada, lo almacena y actualiza su ruta. Actualiza
     * el evento y procesa la carga de invitados en formato JSON, limpiando registros anteriores y
     * reinsertando los nuevos mientras preserva estados anteriores de invitaciones o asistencia si 
     * el correo electrónico coincide.
     *
     * @param \Illuminate\Http\Request $request Solicitud HTTP con los datos actualizados del evento.
     * @param string $id Identificador del evento a actualizar.
     * @return \Illuminate\Http\RedirectResponse Redirección a la lista de eventos con mensaje de éxito o retorno con errores.
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
                    $currentInvitados = Invitado::where('evento_id', $evento->id)->get()->keyBy('email');
                    
                    Invitado::where('evento_id', $evento->id)->delete();
                    
                    foreach ($invitadosData as $inv) {
                        $email = $inv['email'] ?? null;
                        $estado_invitacion = 'Pendiente';
                        $estado_asistencia = 'Sin responder';
                        
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

    /**
     * Cancela un evento específico actualizando su estado.
     *
     * Busca el evento perteneciente al usuario autenticado por ID y actualiza su atributo 'estado'
     * al valor 'Cancelado'. Redirecciona al listado general de eventos.
     *
     * @param \Illuminate\Http\Request $request Solicitud HTTP de cancelación.
     * @param string $id Identificador del evento a cancelar.
     * @return \Illuminate\Http\RedirectResponse Redirección a la lista de eventos con mensaje de confirmación.
     */
    public function cancel(Request $request, string $id)
    {
        $evento = Auth::user()->eventos()->findOrFail($id);
        $evento->update(['estado' => 'Cancelado']);

        return redirect()->route('eventos.index')->with('status', 'Evento cancelado exitosamente.');
    }

    /**
     * Elimina de forma lógica (soft delete) un evento específico de la base de datos.
     *
     * Busca el evento por ID dentro de los eventos propios del usuario autenticado, ejecuta la
     * eliminación (que debido al rasgo SoftDeletes del modelo marcará la fecha de eliminación sin
     * destruirlo físicamente), y redirecciona al index con mensaje de éxito.
     *
     * @param string $id Identificador del evento a eliminar.
     * @return \Illuminate\Http\RedirectResponse Redirección a la lista de eventos con mensaje de éxito.
     */
    public function destroy(string $id)
    {
        $evento = Auth::user()->eventos()->findOrFail($id);
        $evento->delete();

        return redirect()->route('eventos.index')->with('status', 'Evento eliminado exitosamente.');
    }
}
