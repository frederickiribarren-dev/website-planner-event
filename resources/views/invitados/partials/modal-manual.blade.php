<div id="modalManual" 
     class="fixed inset-0 z-50 overflow-y-auto" 
     style="display: none;">
    
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Fondo oscuro -->
        <div class="fixed inset-0 bg-gray-500/50 transition-opacity" onclick="closeModal('modalManual')"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

        <!-- Contenido del Modal -->
        <div class="relative z-10 inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-2xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="px-6 py-8 bg-white">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-slate-800">Añadir Manualmente</h3>
                    <button onclick="closeModal('modalManual')" class="text-slate-400 hover:text-slate-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Nombre Completo</label>
                        <input type="text" class="w-full px-4 py-2.5 rounded-xl border-slate-200 focus:border-cyan-500 focus:ring-cyan-500 transition-all" placeholder="Ej. Juan Pérez">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Correo Electrónico</label>
                        <input type="email" class="w-full px-4 py-2.5 rounded-xl border-slate-200 focus:border-cyan-500 focus:ring-cyan-500 transition-all" placeholder="juan@ejemplo.com">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Teléfono / WhatsApp</label>
                        <input type="tel" class="w-full px-4 py-2.5 rounded-xl border-slate-200 focus:border-cyan-500 focus:ring-cyan-500 transition-all" placeholder="+56 9 ...">
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button type="button" onclick="closeModal('modalManual')" 
                                class="flex-1 px-4 py-2.5 rounded-xl font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors">
                            Cancelar
                        </button>
                        <button type="submit" 
                                class="flex-1 px-4 py-2.5 rounded-xl font-semibold text-white bg-cyan-600 hover:bg-cyan-700 transition-colors shadow-lg shadow-cyan-100">
                            Guardar Invitado
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
