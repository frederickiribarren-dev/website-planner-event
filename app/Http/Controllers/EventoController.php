<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Evento;

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
        return view('eventos.create');
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
            'imagen_portada_url' => 'nullable|string|max:500',
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
        ]
        );

        //Guardar asociando el evento al usuario autenticado
        $request->user()->eventos()->create($validated);
        return redirect()->route('eventos.index')->with('status', 'Evento creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $evento = Auth::user()->eventos()->findOrFail($id);
        $evento->update(['estado' => 'Cancelado']);

        return redirect()->route('eventos.index')->with('status', 'Evento cancelado exitosamente.');
    }
}
