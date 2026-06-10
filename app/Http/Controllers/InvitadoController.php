<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Evento;
use App\Models\Invitado;
use App\Models\ListaInvitado;

class InvitadoController extends Controller
{
    /**
     * Muestra el listado de invitados pertenecientes a un evento específico.
     *
     * Recupera todas las listas de invitados asociadas al evento y consulta la colección de
     * invitados del evento, permitiendo filtrar por una lista en particular si se incluye el
     * parámetro 'lista_id' en la solicitud HTTP. Devuelve la vista 'invitados.index'.
     *
     * @param \Illuminate\Http\Request $request Solicitud HTTP que puede contener un filtro de lista.
     * @param \App\Models\Evento $evento Evento al cual pertenecen los invitados.
     * @return \Illuminate\View\View Vista con el listado de invitados y filtros.
     */
    public function index(Request $request, Evento $evento)
    {
        $listas = $evento->listasInvitados()->get();

        $query = Invitado::where('evento_id', $evento->id);
        if ($request->filled('lista_id')) {
            $query->where('lista_invitado_id', $request->query('lista_id'));
        }

        $invitados = $query->get();

        return view('invitados.index', compact('evento', 'invitados', 'listas'));
    }

    /**
     * Muestra la interfaz de creación y gestión de invitados desde la vista frontend pública/usuario.
     *
     * Obtiene todos los eventos pertenecientes al usuario autenticado, cargando de forma anidada
     * sus listas de invitados y el conteo/detalle de sus miembros. Retorna la vista
     * 'invitados.creacion-invitacion'.
     *
     * @return \Illuminate\View\View Vista frontend para la gestión de invitaciones.
     */
    public function createFront()
    {
        $eventos = auth()->user()->eventos()
            ->with(['listasInvitados' => function ($query) {
                $query->withCount('invitados')->with('invitados');
            }])
            ->get();

        return view('invitados.creacion-invitacion', compact('eventos'));
    }

    /**
     * Almacena una nueva lista de invitados y sus respectivos integrantes desde la vista frontend.
     *
     * Valida los datos recibidos (nombre de la lista, categoría opcional, ID del evento y la cadena JSON
     * que contiene la lista de invitados). Verifica los permisos del evento en caso de estar especificado.
     * Valida cada invitado del array JSON y crea la lista de invitados y sus correspondientes registros
     * de invitados en la base de datos de manera masiva.
     *
     * @param \Illuminate\Http\Request $request Solicitud HTTP con la información de la lista e invitados.
     * @return \Illuminate\Http\RedirectResponse Redirección al frontend de creación con mensaje de éxito o errores.
     */
    public function storeFront(Request $request)
    {
        $validated = $request->validate([
            'evento_id' => 'nullable|exists:eventos,id',
            'list_name' => 'required|string|max:150',
            'list_category' => 'nullable|string|max:150',
            'guests_json' => 'required|string',
        ], [
            'evento_id.exists' => 'El evento seleccionado no existe.',
            'list_name.required' => 'El nombre de la lista es obligatorio.',
            'list_name.max' => 'El nombre de la lista no puede exceder los 150 caracteres.',
            'guests_json.required' => 'Debe añadir al menos un invitado.',
        ]);

        $evento = null;
        if (!empty($validated['evento_id'])) {
            $evento = auth()->user()->eventos()->find($validated['evento_id']);
            if (!$evento) {
                return back()->withErrors(['evento_id' => 'Debe seleccionar un evento válido.'])->withInput();
            }
        }

        $guests = json_decode($validated['guests_json'], true);

        if (!is_array($guests) || empty($guests)) {
            return back()->withErrors(['guests_json' => 'Debe añadir al menos un invitado.'])->withInput();
        }

        $rules = [
            'guests.*.name' => 'required|string|max:100',
            'guests.*.email' => 'nullable|email|max:255',
            'guests.*.phone' => 'nullable|string|max:20',
        ];

        $guestValidator = Validator::make(['guests' => $guests], $rules, [
            'guests.*.name.required' => 'El nombre del invitado es obligatorio.',
            'guests.*.name.max' => 'El nombre del invitado no puede tener más de 100 caracteres.',
            'guests.*.email.email' => 'El correo electrónico del invitado debe ser válido.',
            'guests.*.email.max' => 'El correo electrónico del invitado no puede tener más de 255 caracteres.',
            'guests.*.phone.max' => 'El teléfono del invitado no puede tener más de 20 caracteres.',
        ]);

        if ($guestValidator->fails()) {
            return back()->withErrors($guestValidator)->withInput();
        }

        if ($evento) {
            $lista = $evento->listasInvitados()->create([
                'nombre' => $validated['list_name'],
                'categoria' => $validated['list_category'] ?: null,
            ]);
        } else {
            $lista = ListaInvitado::create([
                'evento_id' => null,
                'nombre' => $validated['list_name'],
                'categoria' => $validated['list_category'] ?: null,
            ]);
        }

        $invitados = array_map(function ($guest) use ($evento, $lista) {
            return [
                'evento_id' => $evento ? $evento->id : null,
                'lista_invitado_id' => $lista->id,
                'nombre' => $guest['name'],
                'email' => $guest['email'] ?? null,
                'telefono' => $guest['phone'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $guests);

        Invitado::insert($invitados);

        return redirect()->route('invitados.creacion')->with('success', 'Lista de invitados creada correctamente.');
    }

    /**
     * Muestra el formulario para registrar un invitado individual en un evento.
     *
     * Obtiene las listas de invitados asociadas al evento y carga la vista de creación
     * individual de invitados ('invitados.create').
     *
     * @param \App\Models\Evento $evento Evento en el cual se registrará el invitado.
     * @return \Illuminate\View\View Vista del formulario de registro individual.
     */
    public function create(Evento $evento)
    {
        $listas = $evento->listasInvitados()->get();
        return view('invitados.create', compact('evento', 'listas'));
    }

    /**
     * Almacena un nuevo invitado individual asociado a un evento específico.
     *
     * Valida la información del invitado (nombre, email, teléfono, estados de asistencia,
     * cantidades y fechas). Asigna el identificador del evento e inserta el nuevo registro
     * de invitado. Redirecciona con un mensaje de éxito.
     *
     * @param \Illuminate\Http\Request $request Solicitud HTTP con la información del invitado.
     * @param \App\Models\Evento $evento Evento asociado al nuevo invitado.
     * @return \Illuminate\Http\RedirectResponse Redirección al index de invitados con mensaje de éxito.
     */
    public function store(Request $request, Evento $evento)
    {
        $validated = $request->validate([
            'lista_invitado_id' => 'nullable|exists:listas_invitados,id',
            'nombre' => 'required|string|max:100',
            'email' => 'nullable|email|max:255',
            'telefono' => 'nullable|string|max:20',
            'token_acceso' => 'nullable|string|max:64',
            'estado_invitacion' => 'nullable|in:Pendiente,Enviado,Leído,Error',
            'estado_asistencia' => 'nullable|in:Sin responder,Confirmado,Rechazado',
            'cantidad_adultos' => 'nullable|integer|min:0',
            'cantidad_ninos' => 'nullable|integer|min:0',
            'alergias_notas' => 'nullable|string',
            'fecha_confirmacion' => 'nullable|date',
        ],
        [
            'lista_invitado_id.exists' => 'La lista de invitados seleccionada no existe.',
            'nombre.required' => 'El nombre del invitado es obligatorio.',
            'nombre.string' => 'El nombre del invitado debe ser una cadena de texto.',
            'nombre.max' => 'El nombre del invitado no puede tener más de 100 caracteres.',
            'email.email' => 'El correo electrónico del invitado debe ser una dirección de correo válida.',
            'email.max' => 'El correo electrónico del invitado no puede tener más de 255 caracteres.',
            'telefono.string' => 'El teléfono del invitado debe ser una cadena de texto.',
            'telefono.max' => 'El teléfono del invitado no puede tener más de 20 caracteres.',
            'estado_invitacion.in' => 'El estado de la invitación debe ser Pendiente, Enviado, Leído o Error.',
            'estado_asistencia.in' => 'El estado de asistencia debe ser Sin responder, Confirmado o Rechazado.',
            'cantidad_adultos.integer' => 'La cantidad de adultos debe ser un número entero.',
            'cantidad_adultos.min' => 'La cantidad de adultos no puede ser negativa.',
            'cantidad_ninos.integer' => 'La cantidad de niños debe ser un número entero.',
            'cantidad_ninos.min' => 'La cantidad de niños no puede ser negativa.',
            'fecha_confirmacion.date' => 'La fecha de confirmación debe ser una fecha válida.',
        ]);

        $validated['evento_id'] = $evento->id;
        Invitado::create($validated);

        return redirect()->route('eventos.invitados.index', $evento->id)
            ->with('success', 'Invitado creado exitosamente.');
    }

    /**
     * Muestra la vista detallada de un invitado específico.
     *
     * Retorna la vista 'invitados.show' enviando la instancia del modelo de invitado.
     *
     * @param \App\Models\Invitado $invitado Instancia del invitado a consultar.
     * @return \Illuminate\View\View Vista con la información del invitado.
     */
    public function show(Invitado $invitado)
    {
        return view('invitados.show', compact('invitado'));
    }

    /**
     * Muestra el formulario para editar a un invitado específico.
     *
     * Obtiene las listas de invitados asociadas al evento del invitado y retorna la vista
     * 'invitados.edit' con los datos correspondientes.
     *
     * @param \App\Models\Invitado $invitado Instancia del invitado a modificar.
     * @return \Illuminate\View\View Vista del formulario de edición.
     */
    public function edit(Invitado $invitado)
    {
        $listas = $invitado->evento->listasInvitados()->get();
        return view('invitados.edit', compact('invitado', 'listas'));
    }

    /**
     * Actualiza la información de un invitado específico en el almacenamiento.
     *
     * Valida los datos actualizados del invitado y los guarda en la base de datos a través del modelo.
     * Redirecciona con un mensaje de éxito.
     *
     * @param \Illuminate\Http\Request $request Solicitud HTTP con la información a actualizar.
     * @param \App\Models\Invitado $invitado Instancia del invitado a actualizar.
     * @return \Illuminate\Http\RedirectResponse Redirección al index de invitados del evento.
     */
    public function update(Request $request, Invitado $invitado)
    {
        $validated = $request->validate([
            'lista_invitado_id' => 'nullable|exists:listas_invitados,id',
            'nombre' => 'required|string|max:100',
            'email' => 'nullable|email|max:255',
            'telefono' => 'nullable|string|max:20',
            'token_acceso' => 'nullable|string|max:64',
            'estado_invitacion' => 'nullable|in:Pendiente,Enviado,Leído,Error',
            'estado_asistencia' => 'nullable|in:Sin responder,Confirmado,Rechazado',
            'cantidad_adultos' => 'nullable|integer|min:0',
            'cantidad_ninos' => 'nullable|integer|min:0',
            'alergias_notas' => 'nullable|string',
            'fecha_confirmacion' => 'nullable|date',
        ]);

        $invitado->update($validated);

        return redirect()->route('eventos.invitados.index', $invitado->evento_id)
            ->with('success', 'Invitado actualizado correctamente.');
    }

    /**
     * Elimina a un invitado específico de la base de datos.
     *
     * Obtiene el identificador del evento para la redirección, elimina el registro físico del
     * invitado de la base de datos y redirecciona con un mensaje de éxito.
     *
     * @param \App\Models\Invitado $invitado Instancia del invitado a eliminar.
     * @return \Illuminate\Http\RedirectResponse Redirección al index de invitados del evento.
     */
    public function destroy(Invitado $invitado)
    {
        $eventoId = $invitado->evento_id;
        $invitado->delete();

        return redirect()->route('eventos.invitados.index', $eventoId)
            ->with('success', 'Invitado eliminado exitosamente.');
    }
}
