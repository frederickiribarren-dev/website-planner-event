<div id="modalImport" 
     class="fixed inset-0 z-50 overflow-y-auto" 
     style="display: none;">
    
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Fondo oscuro -->
        <div class="fixed inset-0 bg-gray-500/50 transition-opacity" onclick="closeModal('modalImport')"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

        <!-- Contenido del Modal -->
        <div class="relative z-10 inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-2xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="px-6 py-8 bg-white">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-slate-800">Importar Excel</h3>
                    <button onclick="closeModal('modalImport')" class="text-slate-400 hover:text-slate-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="space-y-6">
                    <div class="p-8 border-2 border-dashed border-slate-200 rounded-2xl bg-slate-50 flex flex-col items-center justify-center group hover:border-emerald-500 hover:bg-emerald-50 transition-all cursor-pointer relative">
                        <input type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept=".xlsx, .xls, .csv">
                        <div class="w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                        </div>
                        <p class="font-bold text-slate-800">Haz clic o arrastra tu archivo</p>
                        <p class="text-sm text-slate-500 mt-1">Soporta formatos .xlsx, .xls y .csv</p>
                    </div>

                    <div class="p-4 bg-amber-50 border border-amber-100 rounded-xl flex gap-3 items-start">
                        <svg class="w-5 h-5 text-amber-600 shrine-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div class="text-xs text-amber-800 leading-relaxed">
                            <p class="font-bold mb-1">Asegúrate de seguir el formato:</p>
                            <p>El archivo debe contener las columnas: <strong>Nombre, Email, Teléfono</strong> en la primera fila.</p>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button type="button" onclick="closeModal('modalImport')" 
                                class="flex-1 px-4 py-2.5 rounded-xl font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors">
                            Cancelar
                        </button>
                        <button type="button" 
                                class="flex-1 px-4 py-2.5 rounded-xl font-semibold text-white bg-emerald-600 hover:bg-emerald-700 transition-colors shadow-lg shadow-emerald-100">
                            Procesar Archivo
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
