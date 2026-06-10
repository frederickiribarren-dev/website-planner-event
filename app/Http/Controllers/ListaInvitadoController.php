<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\ListaInvitado;

class ListaInvitadoController extends Controller
{
    public function index(Evento $evento)
    {
        $listas = $evento->listasInvitados()->get();
        return view('invitados.listas.index', compact('evento', 'listas'));
    }

    public function create(Evento $evento)
    {
        return view('invitados.listas.create', compact('evento'));
    }

    public function store(Request $request, Evento $evento)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:150',
            'categoria' => 'nullable|string',
        ], [
            'nombre.required' => 'El nombre de la lista es obligatorio.',
            'nombre.string' => 'El nombre de la lista debe ser una cadena de texto.',
            'nombre.max' => 'El nombre de la lista no puede exceder los 150 caracteres.',
        ]);

        $evento->listasInvitados()->create($validated);

        return redirect()->route('eventos.listas-invitados.index', $evento->id)
            ->with('success', 'Lista de invitados creada correctamente.');
    }

    public function show(ListaInvitado $lista_invitado)
    {
        $lista_invitado->load('invitados', 'evento');
        return view('invitados.listas.show', compact('lista_invitado'));
    }

    public function edit(ListaInvitado $lista_invitado)
    {
        return view('invitados.listas.edit', compact('lista_invitado'));
    }

    public function update(Request $request, ListaInvitado $lista_invitado)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:150',
            'categoria' => 'nullable|string',
        ], [
            'nombre.required' => 'El nombre de la lista es obligatorio.',
            'nombre.string' => 'El nombre de la lista debe ser una cadena de texto.',
            'nombre.max' => 'El nombre de la lista no puede exceder los 150 caracteres.',
        ]);

        $lista_invitado->update($validated);

        return redirect()->route('listas-invitados.show', $lista_invitado->id)
            ->with('success', 'Lista de invitados actualizada correctamente.');
    }

    public function destroy(ListaInvitado $lista_invitado)
    {
        $lista_invitado->delete();

        return redirect()->route('invitados.creacion')
            ->with('success', 'Lista de invitados eliminada.');
    }

    public function addGuest(Request $request, ListaInvitado $lista_invitado)
    {
        $validated = $request->validate([
            'nombre'   => 'required|string|max:100',
            'email'    => 'nullable|email|max:255',
            'telefono' => 'nullable|string|max:20',
        ]);

        $lista_invitado->invitados()->create([
            'nombre'             => $validated['nombre'],
            'email'              => $validated['email'] ?? null,
            'telefono'           => $validated['telefono'] ?? null,
            'evento_id'          => $lista_invitado->evento_id,
            'estado_asistencia'  => 'Sin responder',
            'estado_invitacion'  => 'Pendiente',
        ]);

        return redirect()->route('listas-invitados.edit', $lista_invitado->id)
            ->with('success', 'Invitado añadido correctamente.');
    }

    public function removeGuest(ListaInvitado $lista_invitado, \App\Models\Invitado $invitado)
    {
        // Sólo eliminar si el invitado pertenece a esta lista
        if ($invitado->lista_invitado_id === $lista_invitado->id) {
            $invitado->delete();
        }

        return redirect()->route('listas-invitados.edit', $lista_invitado->id)
            ->with('success', 'Invitado eliminado de la lista.');
    }
}
