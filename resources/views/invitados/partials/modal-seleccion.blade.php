<div id="modalSelection" 
     class="fixed inset-0 z-50 overflow-y-auto" 
     style="display: none;">
    
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Fondo oscuro -->
        <div class="fixed inset-0 bg-gray-500/50 transition-opacity" onclick="closeModal('modalSelection')"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

        <!-- Contenido del Modal -->
        <div class="relative z-10 inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-2xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="px-6 py-8 bg-white">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-slate-800">Añadir Invitado</h3>
                    <button onclick="closeModal('modalSelection')" class="text-slate-400 hover:text-slate-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="grid grid-cols-1 gap-4">
                    <!-- Opción Manual -->
                    <button onclick="closeModal('modalSelection'); openModal('modalManual')" 
                            class="flex items-center gap-4 p-4 text-left transition-all border-2 border-slate-100 rounded-xl hover:border-cyan-500 hover:bg-cyan-50 group">
                        <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-cyan-100 text-cyan-600 group-hover:bg-cyan-600 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div>
                            <p class="font-bold text-slate-800">Añadir Manualmente</p>
                            <p class="text-sm text-slate-500">Ingresa los datos uno por uno.</p>
                        </div>
                    </button>

                    <!-- Opción Excel -->
                    <button onclick="closeModal('modalSelection'); openModal('modalImport')" 
                            class="flex items-center gap-4 p-4 text-left transition-all border-2 border-slate-100 rounded-xl hover:border-emerald-500 hover:bg-emerald-50 group">
                        <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-emerald-100 text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div>
                            <p class="font-bold text-slate-800">Importar desde Excel</p>
                            <p class="text-sm text-slate-500">Sube un archivo .xlsx o .csv rápidamente.</p>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
