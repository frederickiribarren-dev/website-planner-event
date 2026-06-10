<!-- MODAL VER DETALLE DE LISTA -->
<div id="modalViewList" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <button type="button" tabindex="-1" class="fixed inset-0 w-full h-full bg-slate-900/60 backdrop-blur-sm transition-opacity cursor-default" onclick="closeViewListModal()" aria-label="Cerrar modal"></button>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="relative z-10 inline-block align-bottom bg-white rounded-[2.5rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
            <div class="bg-white px-8 py-8">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-2xl font-black text-slate-800" id="viewListName">Detalle de la Lista</h3>
                        <p class="text-sm text-slate-400">Consulta el estado de los regalos seleccionados.</p>
                    </div>
                    <button onclick="closeViewListModal()" class="p-2 bg-slate-50 text-slate-400 hover:text-slate-600 rounded-full transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="viewListItemsGrid">
                    <!-- Inyectado por JS -->
                </div>

                <div class="mt-10 flex justify-end">
                    <button onclick="closeViewListModal()" class="px-8 py-3 bg-cyan-800 text-white font-bold rounded-2xl hover:bg-cyan-900 transition-all">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
