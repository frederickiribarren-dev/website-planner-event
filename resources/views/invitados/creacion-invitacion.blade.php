<x-app-layout>
    <script>
        function openModal(id) {
            document.getElementById(id).style.display = 'block';
            document.body.style.overflow = 'hidden'; // Evitar scroll
        }

        function closeModal(id) {
            document.getElementById(id).style.display = 'none';
            document.body.style.overflow = 'auto'; // Restaurar scroll
        }

        function closeAllModals() {
            const modals = ['modalSelection', 'modalManual', 'modalImport'];
            modals.forEach(id => {
                const el = document.getElementById(id);
                if (el) el.style.display = 'none';
            });
            document.body.style.overflow = 'auto';
        }
    </script>
    
    <div>
        <x-slot name="header">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                        {{ __('Gestión de Invitados') }}
                    </h2>
                    <p class="text-sm text-slate-500 mt-1">Organiza y administra la lista de personas para tu evento.</p>
                </div>
                <button onclick="openModal('modalSelection')" class="inline-flex items-center justify-center px-6 py-2 rounded-full text-sm font-semibold transition-all transform active:scale-95 cursor-pointer bg-cyan-700 text-white hover:bg-cyan-800 gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Añadir Invitado
                </button>
            </div>
        </x-slot>

        <!-- Resumen Rápido -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-cyan-100 text-cyan-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Invitados</p>
                        <p class="text-2xl font-black text-slate-800">124</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Confirmados</p>
                        <p class="text-2xl font-black text-slate-800">82</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pendientes</p>
                        <p class="text-2xl font-black text-slate-800">42</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Invitados -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-50 flex items-center justify-between bg-slate-50/50">
                <h3 class="font-bold text-slate-800">Lista de Invitados</h3>
                <div class="flex items-center gap-2">
                    <div class="relative">
                        <input type="text" placeholder="Buscar invitado..." class="pl-10 pr-4 py-2 border-slate-200 rounded-xl text-sm focus:ring-cyan-500 focus:border-cyan-500">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80">
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Nombre del Invitado</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Cantidad (A/N)</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Estado Invitación</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Regalo Asignado</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <!-- Fila de ejemplo 1 -->
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-cyan-50 text-cyan-600 flex items-center justify-center font-bold text-sm">
                                        JP
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800">Juan Pérez</p>
                                        <p class="text-xs text-slate-500">juan.perez@email.com</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-1 bg-slate-100 rounded-lg text-xs font-bold text-slate-600">2 Adultos</span>
                                    <span class="px-2 py-1 bg-slate-100 rounded-lg text-xs font-bold text-slate-600">1 Niño</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-bold">
                                    Confirmado
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-slate-600">biberón</p>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button class="p-2 text-slate-400 hover:text-red-500 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </td>
                        </tr>

                        <!-- Fila de ejemplo 2 -->
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center font-bold text-sm">
                                        MG
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800">María García</p>
                                        <p class="text-xs text-slate-500">maria.g@email.com</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-1 bg-slate-100 rounded-lg text-xs font-bold text-slate-600">1 Adulto</span>
                                    <span class="px-2 py-1 bg-slate-100 rounded-lg text-xs font-bold text-slate-600">0 Niños</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-bold">
                                    Pendiente
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-slate-400 italic text-xs">Sin asignar</p>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button class="p-2 text-slate-400 hover:text-red-500 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Paginación placeholder -->
            <div class="p-4 border-t border-slate-50 bg-slate-50/30 flex justify-center">
                <nav class="flex gap-1">
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-white border border-slate-200 text-slate-400 hover:bg-slate-50">1</button>
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-cyan-600 text-white font-bold shadow-lg shadow-cyan-100">2</button>
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-white border border-slate-200 text-slate-400 hover:bg-slate-50">3</button>
                </nav>
            </div>
        </div>

        <!-- Modales -->
        @include('invitados.partials.modal-seleccion')
        @include('invitados.partials.modal-manual')
        @include('invitados.partials.modal-importar')
    </div>
</x-app-layout>
