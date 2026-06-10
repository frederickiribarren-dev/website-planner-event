<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-black text-slate-800 tracking-tight">Editar Lista</h2>
                <p class="text-slate-500 font-medium mt-1">{{ $lista_invitado->nombre }}</p>
            </div>
            <a href="{{ route('invitados.creacion') }}"
               class="inline-flex items-center gap-2 px-6 py-3 rounded-full text-xs font-bold bg-white border border-slate-200 text-slate-500 hover:text-cyan-600 hover:border-cyan-200 shadow-sm uppercase tracking-widest transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        @if($errors->any())
            <div class="mb-6 px-6 py-4 bg-red-50 border border-red-200 text-red-700 rounded-3xl text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="mb-6 px-6 py-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-3xl text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Columna Izquierda: Editar nombre y categoría --}}
            <div class="space-y-6">
                <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6">Datos de la Lista</h3>
                    <form method="POST" action="{{ route('listas-invitados.update', $lista_invitado->id) }}" class="space-y-5">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-2">Nombre</label>
                            <input type="text" name="nombre" value="{{ old('nombre', $lista_invitado->nombre) }}"
                                   class="w-full bg-slate-50 border-none rounded-2xl px-5 py-3.5 focus:ring-2 focus:ring-cyan-600 text-sm font-medium text-slate-700" required>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-2">Categoría</label>
                            <select name="categoria" class="w-full bg-slate-50 border-none rounded-2xl px-5 py-3.5 focus:ring-2 focus:ring-cyan-600 text-sm font-medium text-slate-600">
                                <option value="">Sin categoría</option>
                                @foreach(['Familia', 'Amigos', 'Trabajo', 'Compañeros', 'Otros'] as $cat)
                                    <option value="{{ $cat }}" {{ old('categoria', $lista_invitado->categoria) === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="w-full py-4 bg-cyan-700 hover:bg-cyan-800 text-white font-bold rounded-2xl shadow-lg shadow-cyan-900/20 transition-all uppercase tracking-widest text-xs">
                            Guardar Cambios
                        </button>
                    </form>
                </div>

                {{-- Añadir invitado nuevo --}}
                <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6">Añadir Invitado</h3>
                    <form method="POST" action="{{ route('listas-invitados.addGuest', $lista_invitado->id) }}" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-2">Nombre *</label>
                            <input type="text" name="nombre" placeholder="Nombre completo"
                                   class="w-full bg-slate-50 border-none rounded-2xl px-5 py-3.5 focus:ring-2 focus:ring-cyan-600 text-sm font-medium text-slate-700" required>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-2">Email</label>
                            <input type="email" name="email" placeholder="correo@ejemplo.com"
                                   class="w-full bg-slate-50 border-none rounded-2xl px-5 py-3.5 focus:ring-2 focus:ring-cyan-600 text-sm font-medium text-slate-700">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-2">Teléfono</label>
                            <input type="tel" name="telefono" placeholder="+56 9 ..."
                                   class="w-full bg-slate-50 border-none rounded-2xl px-5 py-3.5 focus:ring-2 focus:ring-cyan-600 text-sm font-medium text-slate-700">
                        </div>
                        <button type="submit" class="w-full py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-2xl shadow-lg shadow-emerald-600/20 transition-all uppercase tracking-widest text-xs flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Añadir a la lista
                        </button>
                    </form>
                </div>
            </div>

            {{-- Columna Derecha: Tabla de invitados --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-50 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-black text-slate-800">Invitados en la lista</h3>
                            <p class="text-xs text-slate-400 font-medium mt-0.5">{{ $lista_invitado->invitados->count() }} persona(s)</p>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/50 border-b border-slate-100">
                                    <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Nombre</th>
                                    <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Contacto</th>
                                    <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Estado</th>
                                    <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="guest-edit-table-body" class="divide-y divide-slate-50">
                                @forelse($lista_invitado->invitados as $invitado)
                                    <tr class="hover:bg-slate-50/30 transition-colors group">
                                        <td class="px-8 py-5 font-bold text-slate-700">{{ $invitado->nombre }}</td>
                                        <td class="px-8 py-5 text-sm text-slate-500">
                                            @if($invitado->email)
                                                <span class="block">{{ $invitado->email }}</span>
                                            @endif
                                            @if($invitado->telefono)
                                                <span class="block text-slate-400">{{ $invitado->telefono }}</span>
                                            @endif
                                            @if(!$invitado->email && !$invitado->telefono)
                                                <span class="text-slate-300">—</span>
                                            @endif
                                        </td>
                                        <td class="px-8 py-5">
                                            @php
                                                $color = match($invitado->estado_asistencia) {
                                                    'Confirmado' => 'bg-emerald-100 text-emerald-700',
                                                    'Rechazado'  => 'bg-red-100 text-red-600',
                                                    default      => 'bg-slate-100 text-slate-500',
                                                };
                                            @endphp
                                            <span class="px-3 py-1 {{ $color }} rounded-full text-[10px] font-black uppercase tracking-widest">
                                                {{ $invitado->estado_asistencia ?? 'Sin responder' }}
                                            </span>
                                        </td>
                                        <td class="px-8 py-5 text-right">
                                            <form method="POST" action="{{ route('listas-invitados.removeGuest', [$lista_invitado->id, $invitado->id]) }}"
                                                  onsubmit="return confirm('¿Eliminar a {{ addslashes($invitado->nombre) }} de la lista?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-bold transition-colors">
                                                    ✕ Eliminar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="no-guests">
                                        <td colspan="4" class="px-8 py-10 text-center">
                                            <p class="text-slate-400 font-medium text-sm">Esta lista no tiene invitados aún.</p>
                                            <p class="text-slate-300 text-xs mt-1">Usa el formulario de la izquierda para añadir personas.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($lista_invitado->invitados->count() > 0)
                        <div class="p-6 border-t border-slate-50 flex items-center justify-between bg-slate-50/10">
                            <p class="text-xs text-slate-400 font-medium">Mostrando <span class="font-bold text-slate-600" id="pag-info">0-0</span> de <span class="font-bold text-slate-600" id="total-count">{{ $lista_invitado->invitados->count() }}</span></p>
                            <div class="flex gap-2">
                                <button type="button" id="btn-pag-prev" onclick="goToPrevPage()" class="px-4 py-2 rounded-lg bg-white border border-gray-200 text-gray-400 hover:text-cyan-600 transition-all text-xs font-bold">Ant.</button>
                                <button type="button" id="btn-pag-next" onclick="goToNextPage()" class="px-4 py-2 rounded-lg bg-white border border-gray-200 text-gray-400 hover:text-cyan-600 transition-all text-xs font-bold">Sig.</button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentEditPage = 1;
        const editItemsPerPage = 6;
        const rows = Array.from(document.querySelectorAll('#guest-edit-table-body tr')).filter(row => !row.classList.contains('no-guests'));

        /**
         * Renderiza la tabla de edición de invitados aplicando paginación visual y controlando los botones.
         */
        function renderEditTable() {
            if (rows.length === 0) return;

            const totalPages = Math.ceil(rows.length / editItemsPerPage);
            if (currentEditPage > totalPages) currentEditPage = totalPages;
            if (currentEditPage < 1) currentEditPage = 1;

            const startIndex = (currentEditPage - 1) * editItemsPerPage;
            const endIndex = startIndex + editItemsPerPage;

            rows.forEach((row, index) => {
                if (index >= startIndex && index < endIndex) {
                    row.classList.remove('hidden');
                } else {
                    row.classList.add('hidden');
                }
            });

            document.getElementById('pag-info').innerText = `${startIndex + 1}-${Math.min(endIndex, rows.length)}`;
            
            const btnPrev = document.getElementById('btn-pag-prev');
            const btnNext = document.getElementById('btn-pag-next');

            btnPrev.disabled = currentEditPage <= 1;
            btnNext.disabled = currentEditPage >= totalPages;

            if (currentEditPage <= 1) {
                btnPrev.classList.add('opacity-50', 'cursor-not-allowed');
                btnPrev.classList.remove('hover:text-cyan-600');
            } else {
                btnPrev.classList.remove('opacity-50', 'cursor-not-allowed');
                btnPrev.classList.add('hover:text-cyan-600');
            }

            if (currentEditPage >= totalPages) {
                btnNext.classList.add('opacity-50', 'cursor-not-allowed');
                btnNext.classList.remove('hover:text-cyan-600');
            } else {
                btnNext.classList.remove('opacity-50', 'cursor-not-allowed');
                btnNext.classList.add('hover:text-cyan-600');
            }
        }

        /**
         * Navega a la página anterior de la tabla de invitados, si no está en la primera página.
         */
        function goToPrevPage() {
            if (currentEditPage > 1) {
                currentEditPage--;
                renderEditTable();
            }
        }

        /**
         * Navega a la página siguiente de la tabla de invitados, si no está en la última página.
         */
        function goToNextPage() {
            const totalPages = Math.ceil(rows.length / editItemsPerPage);
            if (currentEditPage < totalPages) {
                currentEditPage++;
                renderEditTable();
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            renderEditTable();
        });
    </script>
</x-app-layout>
