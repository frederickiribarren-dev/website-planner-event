<!-- MODAL DE DETALLE DE REGALO -->
<div id="modalGiftDetail" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <button type="button" tabindex="-1" class="fixed inset-0 w-full h-full bg-slate-900/60 backdrop-blur-sm transition-opacity cursor-default" onclick="closeGiftModal()" aria-label="Cerrar modal"></button>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="relative z-10 inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-8 py-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-black text-slate-800 uppercase tracking-tighter" id="modalTitle">Configurar Regalo</h3>
                    <button onclick="closeGiftModal()" class="p-2 bg-slate-50 text-slate-400 hover:text-slate-600 rounded-full transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="space-y-6">
                    <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100 mb-6">
                        <img id="modalImg" src="" class="w-16 h-16 rounded-xl object-cover">
                        <div>
                            <p class="font-bold text-slate-800" id="modalItemName"></p>
                            <p class="text-xs text-slate-400" id="modalItemCat"></p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <label for="m_link1" class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Enlaces de Referencia</label>
                        <input type="text" id="m_link1" placeholder="Link 1 (Ej. Amazon, Mercado Libre...)" class="w-full px-4 py-3 rounded-xl border-slate-100 bg-slate-50 focus:border-cyan-500 focus:ring-cyan-500 transition-all text-sm font-medium">
                        <input type="text" id="m_link2" placeholder="Link 2..." class="w-full px-4 py-3 rounded-xl border-slate-100 bg-slate-50 focus:border-cyan-500 focus:ring-cyan-500 transition-all text-sm font-medium">
                        <input type="text" id="m_link3" placeholder="Link 3..." class="w-full px-4 py-3 rounded-xl border-slate-100 bg-slate-50 focus:border-cyan-500 focus:ring-cyan-500 transition-all text-sm font-medium">
                    </div>

                    <div id="qtyContainer" class="pt-2">
                        <label for="m_qty" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2" id="qtyLabel">Cantidad necesaria</label>
                        <input type="number" id="m_qty" min="1" value="1" class="w-full px-4 py-3 rounded-xl border-slate-100 bg-slate-50 focus:border-cyan-500 focus:ring-cyan-500 transition-all text-sm font-bold">
                    </div>
                </div>

                <div class="flex gap-3 mt-8">
                    <button onclick="closeGiftModal()" class="flex-1 px-4 py-3 bg-slate-100 text-slate-600 font-bold rounded-2xl hover:bg-slate-200 transition-all">Cancelar</button>
                    <button id="modalSubmitBtn" onclick="confirmAddGift()" class="flex-1 px-4 py-3 bg-cyan-700 text-white font-bold rounded-2xl hover:bg-cyan-800 transition-all">Agregar</button>
                </div>
            </div>
        </div>
    </div>
</div>
