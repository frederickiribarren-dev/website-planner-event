<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\ListaInvitado;

class ListaInvitadoController extends Controller
{
    /**
     * Muestra la lista de las listas de invitados asociadas a un evento específico.
     *
     * Obtiene todas las listas de invitados asociadas al evento y carga la vista
     * 'invitados.listas.index'.
     *
     * @param \App\Models\Evento $evento Evento asociado a las listas.
     * @return \Illuminate\View\View Vista con la lista de listas de invitados.
     */
    public function index(Evento $evento)
    {
        $listas = $evento->listasInvitados()->get();
        return view('invitados.listas.index', compact('evento', 'listas'));
    }

    /**
     * Muestra el formulario para crear una nueva lista de invitados asociada a un evento.
     *
     * Carga la vista 'invitados.listas.create' pasando el evento asociado.
     *
     * @param \App\Models\Evento $evento Evento para el cual se creará la lista.
     * @return \Illuminate\View\View Vista del formulario de creación.
     */
    public function create(Evento $evento)
    {
        return view('invitados.listas.create', compact('evento'));
    }

    /**
     * Valida y almacena una nueva lista de invitados en la base de datos.
     *
     * Valida que el nombre de la lista sea obligatorio y no exceda 150 caracteres.
     * Crea la lista de invitados bajo el evento especificado y redirecciona con un mensaje de éxito.
     *
     * @param \Illuminate\Http\Request $request Solicitud HTTP con la información de la nueva lista.
     * @param \App\Models\Evento $evento Evento al cual se le asigna la lista.
     * @return \Illuminate\Http\RedirectResponse Redirección al index de listas del evento.
     */
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

    /**
     * Muestra el detalle de una lista de invitados específica.
     *
     * Carga de manera optimizada los invitados y el evento asociado a la lista, y retorna
     * la vista 'invitados.listas.show'.
     *
     * @param \App\Models\ListaInvitado $lista_invitado Instancia de la lista de invitados a consultar.
     * @return \Illuminate\View\View Vista detallada de la lista de invitados.
     */
    public function show(ListaInvitado $lista_invitado)
    {
        $lista_invitado->load('invitados', 'evento');
        return view('invitados.listas.show', compact('lista_invitado'));
    }

    /**
     * Muestra el formulario de edición para una lista de invitados específica.
     *
     * Retorna la vista 'invitados.listas.edit' con los datos de la lista de invitados.
     *
     * @param \App\Models\ListaInvitado $lista_invitado Instancia de la lista a editar.
     * @return \Illuminate\View\View Vista del formulario de edición.
     */
    public function edit(ListaInvitado $lista_invitado)
    {
        return view('invitados.listas.edit', compact('lista_invitado'));
    }

    /**
     * Actualiza los datos de una lista de invitados específica en el almacenamiento.
     *
     * Valida el nombre y categoría de la lista de invitados, ejecuta la actualización en la base
     * de datos a través de su modelo, y redirecciona al detalle de la lista.
     *
     * @param \Illuminate\Http\Request $request Solicitud HTTP con la información actualizada.
     * @param \App\Models\ListaInvitado $lista_invitado Instancia de la lista a actualizar.
     * @return \Illuminate\Http\RedirectResponse Redirección al detalle de la lista de invitados.
     */
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

    /**
     * Elimina una lista de invitados específica del almacenamiento.
     *
     * Ejecuta la eliminación de la lista de invitados e indica una redirección a la pantalla de
     * creación de invitados general con mensaje de éxito.
     *
     * @param \App\Models\ListaInvitado $lista_invitado Instancia de la lista a eliminar.
     * @return \Illuminate\Http\RedirectResponse Redirección a la vista de creación general.
     */
    public function destroy(ListaInvitado $lista_invitado)
    {
        $lista_invitado->delete();

        return redirect()->route('invitados.creacion')
            ->with('success', 'Lista de invitados eliminada.');
    }

    /**
     * Registra un nuevo invitado individual directamente dentro de una lista de invitados.
     *
     * Valida el nombre, correo electrónico y teléfono del invitado. Registra el nuevo invitado
     * asociándolo a la lista de invitados indicada y al evento asociado de la lista, con estados 
     * por defecto. Redirecciona al formulario de edición de la lista.
     *
     * @param \Illuminate\Http\Request $request Solicitud HTTP con la información del invitado.
     * @param \App\Models\ListaInvitado $lista_invitado Instancia de la lista a la cual agregar el invitado.
     * @return \Illuminate\Http\RedirectResponse Redirección al formulario de edición con mensaje de éxito.
     */
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

    /**
     * Elimina a un invitado específico que pertenezca a una lista de invitados indicada.
     *
     * Verifica que el invitado efectivamente pertenezca al ID de la lista antes de eliminarlo.
     * Redirecciona a la edición de la lista de invitados con mensaje de éxito.
     *
     * @param \App\Models\ListaInvitado $lista_invitado Instancia de la lista de invitados.
     * @param \App\Models\Invitado $invitado Instancia del invitado a remover.
     * @return \Illuminate\Http\RedirectResponse Redirección al formulario de edición con mensaje de éxito.
     */
    public function removeGuest(ListaInvitado $lista_invitado, \App\Models\Invitado $invitado)
    {
        if ($invitado->lista_invitado_id === $lista_invitado->id) {
            $invitado->delete();
        }

        return redirect()->route('listas-invitados.edit', $lista_invitado->id)
            ->with('success', 'Invitado eliminado de la lista.');
    }
}
