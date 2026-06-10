
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 id="view-title" class="text-3xl font-black text-slate-800 tracking-tight">
                    Listas de Invitados
                </h2>
                <p id="view-subtitle" class="text-slate-600 font-medium mt-1">Gestiona tus grupos de invitados de forma organizada.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <button id="btn-toggle-view" onclick="showView('events')" class="inline-flex items-center justify-center px-6 py-3 rounded-full text-xs font-bold transition-all transform active:scale-95 bg-white border border-slate-200 text-slate-500 hover:text-cyan-600 hover:border-cyan-200 gap-2 shadow-sm uppercase tracking-widest" aria-label="Cambiar vista">
                    <span id="btn-toggle-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></span>
                    <span id="btn-toggle-text">Ver por eventos</span>
                </button>
                <button onclick="showView('create')" class="inline-flex items-center justify-center px-8 py-3 rounded-full text-xs font-bold transition-all transform active:scale-95 bg-cyan-700 text-white hover:bg-cyan-800 gap-2 shadow-lg shadow-cyan-900/20 uppercase tracking-widest" aria-label="Crear una nueva lista de invitados">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Añadir lista
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-6 px-6 py-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-3xl">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 px-6 py-4 bg-red-50 border border-red-200 text-red-700 rounded-3xl">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- VISTA 1: LISTAS DE INVITADOS (Principal) -->
        <div id="view-lists" class="view-content space-y-8">
            <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100">
                                <th class="px-8 py-6 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Nombre de la Lista</th>
                                <th class="px-8 py-6 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Grupo / Categoría</th>
                                <th class="px-8 py-6 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Evento Asignado</th>
                                <th class="px-8 py-6 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @php
                                // Get all lists: from events and standalone (without event)
                                $allListas = collect();
                                foreach($eventos as $evento) {
                                    $allListas = $allListas->merge($evento->listasInvitados);
                                }
                                // Add standalone lists (evento_id = null)
                                $standaloneListasQuery = \App\Models\ListaInvitado::where('evento_id', null)->get();
                                $allListas = $allListas->merge($standaloneListasQuery);
                            @endphp
                            @if($allListas->isEmpty())
                                <tr>
                                    <td colspan="4" class="px-8 py-10 text-center text-slate-500">Aún no tienes listas de invitados. Crea una nueva lista en la pestaña de creación.</td>
                                </tr>
                            @else
                                @foreach($allListas as $lista)
                                    <tr class="hover:bg-slate-50/30 transition-colors group">
                                        <td class="px-8 py-5">
                                            <div class="flex items-center gap-3">
                                                <p class="font-bold text-slate-700">{{ $lista->nombre }}</p>
                                            </div>
                                        </td>
                                        <td class="px-8 py-5">
                                            <span class="px-4 py-1.5 bg-slate-100 text-slate-600 rounded-full text-[10px] font-black uppercase tracking-widest">{{ $lista->categoria ?? 'Sin categoría' }}</span>
                                        </td>
                                        <td class="px-8 py-5">
                                            @if($lista->evento_id)
                                                <p class="text-sm text-slate-500 font-medium">{{ $lista->evento->nombre_bebe ?? 'Evento no encontrado' }}</p>
                                            @else
                                                <span class="px-3 py-1 bg-amber-50 text-amber-600 rounded-full text-[10px] font-black uppercase tracking-widest">Sin evento</span>
                                            @endif
                                        </td>
                                            <td class="px-8 py-5 text-right space-x-2 whitespace-nowrap">
                                                <button onclick="verListaDetalle('{{ $lista->id }}', '{{ addslashes($lista->nombre) }}', {{ $lista->invitados->count() }})" class="px-4 py-2 bg-slate-100 text-cyan-700 text-xs font-bold rounded-xl hover:bg-cyan-600 hover:text-white transition-all">Ver lista</button>
                                                <a href="{{ route('listas-invitados.edit', $lista->id) }}" class="inline-block px-4 py-2 bg-white border border-slate-200 text-slate-600 text-xs font-bold rounded-xl hover:border-cyan-500 hover:text-cyan-600 transition-all">Editar</a>
                                                <button class="p-2 bg-red-50 text-red-400 hover:text-red-600 rounded-xl transition-all" onclick="if(confirm('¿Estás seguro de eliminar esta lista? Esta acción no se puede deshacer.')) document.getElementById('delete-form-{{ $lista->id }}').submit();">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                                <form id="delete-form-{{ $lista->id }}" action="{{ route('listas-invitados.destroy', $lista->id) }}" method="POST" class="hidden">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- VISTA 2: LISTAS POR EVENTOS -->
        <div id="view-events" class="view-content hidden space-y-8">
            <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100">
                                <th class="px-8 py-6 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Evento</th>
                                <th class="px-8 py-6 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Fecha</th>
                                <th class="px-8 py-6 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Total Invitados</th>
                                <th class="px-8 py-6 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] text-right">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($eventos as $evento)
                                <tr class="hover:bg-slate-50/30 transition-colors">
                                    <td class="px-8 py-5"><p class="font-bold text-slate-700">{{ $evento->nombre_bebe }}</p></td>
                                    <td class="px-8 py-5"><p class="text-sm text-slate-500">{{ $evento->fecha_evento }}</p></td>
                                    <td class="px-8 py-5"><span class="px-3 py-1 bg-cyan-50 text-cyan-700 rounded-full text-xs font-bold">{{ $evento->listasInvitados->sum('invitados_count') ?? 0 }} Personas</span></td>
                                    <td class="px-8 py-5 text-right">
                                        <button onclick="showEventDetail({{ $evento->id }})" class="text-xs font-bold text-cyan-600 hover:text-cyan-700 uppercase tracking-widest underline decoration-2 underline-offset-4">Ver Invitados</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-10 text-center text-slate-500">Aún no hay eventos para mostrar. Crea tu primer evento desde el panel principal.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- VISTA 3: DETALLE DE EVENTO (Unión de listas) -->
        <div id="view-event-detail" class="view-content hidden space-y-6">
            <div class="flex items-center justify-between mb-2">
                <button onclick="showView('events')" class="text-xs font-bold text-slate-400 hover:text-slate-600 flex items-center gap-2 uppercase tracking-widest transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Volver a eventos
                </button>
                <h4 id="detail-event-name" class="font-black text-xl text-slate-800"></h4>
            </div>
            
            <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden flex flex-col h-[500px]">
                <div class="overflow-y-auto flex-1">
                    <table class="w-full text-left border-collapse">
                        <thead class="sticky top-0 z-10 bg-white">
                            <tr class="bg-slate-50/80 border-b border-slate-100">
                                <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Nombre</th>
                                <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Email / Teléfono</th>
                                <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Invitación</th>
                                <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Asistencia</th>
                                <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Origen</th>
                            </tr>
                        </thead>
                        <tbody id="event-guests-body" class="divide-y divide-slate-50">
                            <!-- Se llena con JS -->
                        </tbody>
                    </table>
                </div>
                <div class="p-6 bg-slate-50/50 border-t border-slate-100 flex justify-between items-center">
                    <p id="detail-summary" class="text-xs text-slate-400 font-bold uppercase tracking-widest">Mostrando 0 invitados confirmados</p>
                    <div class="flex gap-2">
                        <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-white border border-slate-200 text-slate-400 hover:text-cyan-600 transition-all shadow-sm disabled:opacity-50 text-xs font-bold">1</button>
                        <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-cyan-600 text-white shadow-lg shadow-cyan-900/20 text-xs font-bold">2</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- VISTA 4: CREACIÓN DE LISTA -->
        <div id="view-create" class="view-content hidden space-y-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                <!-- Formulario -->
                <div class="lg:col-span-4 space-y-6">
                    <form id="createListForm" method="POST" action="{{ route('invitados.creacion.store') }}">
                        @csrf
                        <input type="hidden" id="guests_json" name="guests_json">
                        <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm space-y-8">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-4 italic">Evento (Opcional)</label>
                                <select id="evento_select" name="evento_id" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-cyan-600 transition text-sm font-medium text-slate-600 mb-6">
                                    <option value="">Sin evento (Lista independiente)</option>
                                    @forelse($eventos as $evento)
                                        <option value="{{ $evento->id }}">{{ $evento->nombre_bebe }} - {{ $evento->fecha_evento }}</option>
                                    @empty
                                    @endforelse
                                </select>

                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-4 italic">Nombre de la Lista</label>
                                <input type="text" id="list_name" name="list_name" placeholder="Ej: Amigos de la Infancia" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-cyan-600 transition text-sm font-medium mb-6">
                                
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-4 italic">Categoría</label>
                                <select id="list_category" name="list_category" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-cyan-600 transition text-sm font-medium text-slate-600">
                                    <option value="">Seleccionar Categoría...</option>
                                    <option value="Familia">Familia</option>
                                    <option value="Amigos">Amigos</option>
                                    <option value="Trabajo">Trabajo</option>
                                    <option value="Otros">Otros</option>
                                </select>
                            </div>
                            
                            <div class="pt-6 border-t border-slate-50 space-y-4">
                                <button type="button" onclick="openModal('modalImport')" class="w-full flex items-center justify-center gap-3 px-6 py-4 bg-emerald-50 text-emerald-600 border border-emerald-100 font-bold rounded-2xl hover:bg-emerald-100 transition-all text-xs uppercase tracking-widest">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                    Importar Lista
                                </button>
                                <p class="text-center text-[10px] text-slate-400 font-bold uppercase tracking-widest">O añade manualmente:</p>
                            </div>

                            <div class="space-y-4">
                                <input type="text" id="manual_name" placeholder="Nombre completo" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-3 focus:ring-2 focus:ring-cyan-600 transition text-sm">
                                <input type="email" id="manual_email" placeholder="Correo electrónico" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-3 focus:ring-2 focus:ring-cyan-600 transition text-sm">
                                <input type="tel" id="manual_phone" placeholder="Número de contacto" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-3 focus:ring-2 focus:ring-cyan-600 transition text-sm">
                                <button type="button" onclick="addGuestManual()" class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-bold py-4 rounded-2xl transition-all shadow-lg flex items-center justify-center gap-2 text-xs uppercase tracking-widest">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Agregar a la lista
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Tabla Temporal -->
                <div class="lg:col-span-8 flex flex-col">
                    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden flex flex-col h-[520px]">
                        <div class="p-8 border-b border-slate-50 flex items-center justify-between">
                            <h4 class="font-black text-slate-800 uppercase tracking-tighter">Invitados Agregados</h4>
                            <span id="temp-count" class="px-4 py-1 bg-slate-100 text-slate-500 rounded-full text-[10px] font-black uppercase tracking-widest">0 Invitados</span>
                        </div>
                        <div class="flex-1 overflow-y-auto">
                            <table class="w-full text-left border-collapse">
                                <thead class="sticky top-0 bg-white z-10">
                                    <tr class="bg-slate-50/50">
                                        <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Nombre</th>
                                        <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Contacto</th>
                                        <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="temp-guests-body" class="divide-y divide-slate-50">
                                    <!-- Se llena con JS -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mt-8 flex justify-end gap-4">
                        <button onclick="showView('lists')" class="px-10 py-4 text-slate-400 font-bold hover:text-slate-600 transition-colors uppercase tracking-widest text-xs">Cancelar</button>
                        <button onclick="saveList()" class="px-12 py-4 bg-cyan-700 hover:bg-cyan-800 text-white font-bold rounded-full shadow-xl shadow-cyan-900/20 transition-all transform hover:scale-105 active:scale-95 uppercase tracking-widest text-xs">Guardar Lista</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        let tempGuests = [];
        let selectedEventId = {!! optional($eventos->first())->id ?? 'null' !!};
        const eventsData = {!! json_encode($eventos->map(function($evento) {
            return [
                'id' => $evento->id,
                'name' => $evento->nombre_bebe,
                'lists' => $evento->listasInvitados->map(function($lista) {
                    return [
                        'id' => $lista->id,
                        'category' => $lista->categoria,
                        'guests' => $lista->invitados->map(function($guest) {
                            return [
                                'name' => $guest->nombre,
                                'contact' => $guest->email ?: $guest->telefono ?: '---',
                                'status' => $guest->estado_asistencia ?: 'Sin responder',
                                'inv' => $guest->estado_invitacion ?: 'Pendiente'
                            ];
                        })->all()
                    ];
                })->all()
            ];
        })->all()) !!};

        /**
         * Muestra un modal en pantalla cambiando su estilo a bloque.
         */
        function openModal(id) {
            const el = document.getElementById(id);
            if (el) el.style.display = 'block';
        }

        /**
         * Oculta un modal de la pantalla cambiando su estilo a none.
         */
        function closeModal(id) {
            const el = document.getElementById(id);
            if (el) el.style.display = 'none';
        }

        /**
         * Alterna entre las diferentes vistas de la interfaz ocultando y mostrando el contenido.
         */
        function showView(view) {
            document.querySelectorAll('.view-content').forEach(v => v.classList.add('hidden'));
            document.getElementById('view-' + view).classList.remove('hidden');

            const title = document.getElementById('view-title');
            const subtitle = document.getElementById('view-subtitle');
            const toggleBtn = document.getElementById('btn-toggle-view');
            const toggleText = document.getElementById('btn-toggle-text');
            const toggleIcon = document.getElementById('btn-toggle-icon');

            if (view === 'lists') {
                title.innerText = 'Listas de Invitados';
                subtitle.innerText = 'Gestiona tus grupos de invitados de forma organizada.';
                toggleBtn.setAttribute('onclick', "showView('events')");
                toggleText.innerText = 'Ver por eventos';
                toggleIcon.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>';
            } else if (view === 'events') {
                title.innerText = 'Ver Listas por Eventos';
                subtitle.innerText = 'Consulta quiénes están invitados a cada uno de tus eventos.';
                toggleBtn.setAttribute('onclick', "showView('lists')");
                toggleText.innerText = 'Ver por listas';
                toggleIcon.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>';
            } else if (view === 'create') {
                title.innerText = 'Nueva Lista de Invitados';
                subtitle.innerText = 'Crea un grupo de personas para asignar a tus eventos.';
                toggleBtn.setAttribute('onclick', "showView('lists')");
                toggleText.innerText = 'Volver a listas';
                toggleIcon.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>';
            }
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        /**
         * Muestra el detalle de invitados de un evento en específico renderizando la tabla correspondiente.
         */
        function showEventDetail(eventId) {
            const event = eventsData.find(e => e.id === eventId);
            if (!event) return;

            selectedEventId = eventId;
            document.getElementById('evento_id').value = eventId;

            document.querySelectorAll('.view-content').forEach(v => v.classList.add('hidden'));
            document.getElementById('view-event-detail').classList.remove('hidden');
            document.getElementById('detail-event-name').innerText = event.name;
            const eventoSelect = document.getElementById('evento_select');
            if (eventoSelect) {
                eventoSelect.value = eventId;
            }

            const body = document.getElementById('event-guests-body');
            body.innerHTML = '';
            let totalGuests = 0;

            event.lists.forEach(list => {
                list.guests.forEach(g => {
                    totalGuests += 1;
                    const row = document.createElement('tr');
                    row.className = 'hover:bg-slate-50/50 transition-colors';
                    const statusColor = g.status === 'Confirmado' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-400';
                    row.innerHTML = `
                        <td class="px-8 py-5 text-sm font-bold text-slate-700">${g.name}</td>
                        <td class="px-8 py-5 text-xs text-slate-500 font-medium">${g.contact}</td>
                        <td class="px-8 py-5"><span class="px-3 py-1 bg-cyan-50 text-cyan-700 rounded-full text-[10px] font-black uppercase tracking-widest">${g.inv}</span></td>
                        <td class="px-8 py-5"><span class="px-3 py-1 ${statusColor} rounded-full text-[10px] font-black uppercase tracking-widest">${g.status}</span></td>
                        <td class="px-8 py-5"><span class="px-3 py-1 bg-slate-100 text-slate-500 rounded-full text-[10px] font-black uppercase tracking-widest">${list.category || 'Sin categoría'}</span></td>
                    `;
                    body.appendChild(row);
                });
            });

            document.getElementById('detail-summary').innerText = `Mostrando ${totalGuests} invitados confirmados`;
        }

        /**
         * Añade un nuevo invitado temporal de forma manual tomando la información del formulario.
         */
        function addGuestManual() {
            const name = document.getElementById('manual_name').value;
            const email = document.getElementById('manual_email').value;
            const phone = document.getElementById('manual_phone').value;

            if (!name) return alert('El nombre es obligatorio');

            tempGuests.unshift({ id: Date.now(), name, email, phone, contact: email || phone || '---' });
            document.getElementById('manual_name').value = '';
            document.getElementById('manual_email').value = '';
            document.getElementById('manual_phone').value = '';
            renderTempGuests();
        }

        /**
         * Elimina un invitado de la lista temporal utilizando su identificador único.
         */
        function removeTempGuest(id) {
            tempGuests = tempGuests.filter(g => g.id !== id);
            renderTempGuests();
        }

        /**
         * Actualiza el listado visual en tabla de invitados que están guardados temporalmente en la creación.
         */
        function renderTempGuests() {
            const body = document.getElementById('temp-guests-body');
            const count = document.getElementById('temp-count');
            body.innerHTML = '';

            tempGuests.forEach(g => {
                const row = document.createElement('tr');
                row.className = 'hover:bg-slate-50/50 transition-colors';
                row.innerHTML = `
                    <td class="px-8 py-4 text-sm font-bold text-slate-700">${g.name}</td>
                    <td class="px-8 py-4 text-xs text-slate-500">${g.contact}</td>
                    <td class="px-8 py-4 text-right">
                        <button type="button" onclick="removeTempGuest(${g.id})" class="p-2 text-slate-300 hover:text-red-500 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </td>
                `;
                body.appendChild(row);
            });
            count.innerText = `${tempGuests.length} Invitados`;
        }

        /**
         * Empaqueta la lista temporal y la envía a través del formulario para ser almacenada permanentemente.
         */
        function saveList() {
            if (tempGuests.length === 0) return alert('Añade al menos un invitado');

            const listName = document.getElementById('list_name').value.trim();
            if (!listName) {
                return alert('Ingresa un nombre para la lista.');
            }

            const guestsPayload = tempGuests.map(g => ({ name: g.name, email: g.email, phone: g.phone }));
            document.getElementById('guests_json').value = JSON.stringify(guestsPayload);
            document.getElementById('createListForm').submit();
        }
    </script>

    @include('invitados.partials.modal-seleccion')
    @include('invitados.partials.modal-manual')
    @include('invitados.partials.modal-importar')

    <style>
        .view-content { animation: fadeIn 0.4s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        /* Custom Scrollbar for Premium Look */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { bg: transparent; }
        ::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
    </style>
</x-app-layout>
