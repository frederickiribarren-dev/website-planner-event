<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvitadoMasivoRequest;
use App\Http\Requests\StoreInvitadoRequest;
use App\Http\Requests\UpdateInvitadoRequest;
use App\Models\Evento;
use App\Models\Invitado;
use App\Models\ListaInvitado;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class InvitadoController extends Controller
{
    use AuthorizesRequests;

    /**
     * Muestra el listado de invitados pertenecientes a un evento específico.
     */
    public function index(Request $request, Evento $evento): View
    {
        // Validación BOLA (IDOR): Asegurar que el usuario autenticado es dueño del evento.
        if ($evento->usuario_id !== $request->user()->id) {
            abort(404);
        }

        $listas = $evento->listasInvitados;

        $invitados = $evento->invitados()
            ->when($request->filled('lista_id'), fn ($query) => $query->where('lista_invitado_id', $request->query('lista_id')))
            ->get();

        return view('invitados.index', compact('evento', 'invitados', 'listas'));
    }

    /**
     * Muestra la interfaz de creación y gestión de invitados desde la vista frontend pública/usuario.
     */
    public function createFront(Request $request): View
    {
        $eventos = $request->user()->eventos()
            ->with(['listasInvitados' => fn ($query) => $query->withCount('invitados')->with('invitados')])
            ->get();

        return view('invitados.creacion-invitacion', compact('eventos'));
    }

    /**
     * Almacena una nueva lista de invitados y sus respectivos integrantes desde la vista frontend.
     */
    public function storeFront(StoreInvitadoMasivoRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        
        $evento = null;
        if (!empty($validated['evento_id'])) {
            $evento = $request->user()->eventos()->find($validated['evento_id']);
        }

        $guests = json_decode($validated['guests_json'], true);

        // Validación de estructura interna de invitados.
        $guestValidator = Validator::make(['guests' => $guests], [
            'guests.*.name' => ['required', 'string', 'max:100'],
            'guests.*.email' => ['nullable', 'email', 'max:255'],
            'guests.*.phone' => ['nullable', 'string', 'max:20'],
        ], [
            'guests.*.name.required' => 'El nombre del invitado es obligatorio.',
            'guests.*.name.max' => 'El nombre del invitado no puede tener más de 100 caracteres.',
            'guests.*.email.email' => 'El correo electrónico del invitado debe ser válido.',
            'guests.*.email.max' => 'El correo electrónico del invitado no puede tener más de 255 caracteres.',
            'guests.*.phone.max' => 'El teléfono del invitado no puede tener más de 20 caracteres.',
        ]);

        if ($guestValidator->fails()) {
            return back()->withErrors($guestValidator)->withInput();
        }

        // Creación optimizada de Lista.
        $lista = $evento
            ? $evento->listasInvitados()->create([
                'nombre' => $validated['list_name'],
                'categoria' => $validated['list_category'] ?: null,
            ])
            : ListaInvitado::create([
                'evento_id' => null,
                'nombre' => $validated['list_name'],
                'categoria' => $validated['list_category'] ?: null,
            ]);

        // Transformación y carga masiva (Bulk Insert).
        $now = now();
        $invitados = array_map(fn ($guest) => [
            'evento_id' => $evento?->id,
            'lista_invitado_id' => $lista->id,
            'nombre' => $guest['name'],
            'email' => $guest['email'] ?? null,
            'telefono' => $guest['phone'] ?? null,
            'created_at' => $now,
            'updated_at' => $now,
        ], $guests);

        Invitado::insert($invitados);

        return redirect()->route('invitados.creacion')->with('success', 'Lista de invitados creada correctamente.');
    }

    /**
     * Muestra el formulario para registrar un invitado individual en un evento.
     */
    public function create(Request $request, Evento $evento): View
    {
        // Autorización: IDOR protection.
        if ($evento->usuario_id !== $request->user()->id) {
            abort(404);
        }

        $listas = $evento->listasInvitados;
        return view('invitados.create', compact('evento', 'listas'));
    }

    /**
     * Almacena un nuevo invitado individual asociado a un evento específico.
     */
    public function store(StoreInvitadoRequest $request, Evento $evento): RedirectResponse
    {
        // El FormRequest (StoreInvitadoRequest) ya valida los permisos de propiedad del evento y los datos.
        $evento->invitados()->create($request->validated());

        return redirect()->route('eventos.invitados.index', $evento)
            ->with('success', 'Invitado creado exitosamente.');
    }

    /**
     * Muestra la vista detallada de un invitado específico.
     */
    public function show(Invitado $invitado): View
    {
        $this->authorize('view', $invitado);

        return view('invitados.show', compact('invitado'));
    }

    /**
     * Muestra el formulario para editar a un invitado específico.
     */
    public function edit(Invitado $invitado): View
    {
        $this->authorize('update', $invitado);

        $listas = $invitado->evento->listasInvitados;
        return view('invitados.edit', compact('invitado', 'listas'));
    }

    /**
     * Actualiza la información de un invitado específico en el almacenamiento.
     */
    public function update(UpdateInvitadoRequest $request, Invitado $invitado): RedirectResponse
    {
        // La validación de autorización ('update') y reglas ya se evaluó en UpdateInvitadoRequest.
        $invitado->update($request->validated());

        return redirect()->route('eventos.invitados.index', $invitado->evento_id)
            ->with('success', 'Invitado actualizado correctamente.');
    }

    /**
     * Elimina a un invitado específico de la base de datos.
     */
    public function destroy(Invitado $invitado): RedirectResponse
    {
        $this->authorize('delete', $invitado);

        $eventoId = $invitado->evento_id;
        $invitado->delete();

        return redirect()->route('eventos.invitados.index', $eventoId)
            ->with('success', 'Invitado eliminado exitosamente.');
    }
}
