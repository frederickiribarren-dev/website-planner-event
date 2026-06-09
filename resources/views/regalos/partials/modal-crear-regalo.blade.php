<!-- MODAL CREAR REGALO PERSONALIZADO -->
<div id="modalCreateGift" class="fixed inset-0 z-[60] overflow-y-auto hidden" style="">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeCreateGiftModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="relative z-10 inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full">
            <div class="bg-white px-8 py-8">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-2xl font-black text-slate-800">Nuevo Regalo</h3>
                        <p class="text-sm text-slate-400">Crea un ítem personalizado para tu lista.</p>
                    </div>
                    <button onclick="closeCreateGiftModal()" class="p-2 bg-slate-50 text-slate-400 hover:text-slate-600 rounded-full transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Subida de Imagen -->
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Imagen del Regalo</label>
                        <div onclick="document.getElementById('newGiftImgInput').click()" class="aspect-square rounded-3xl border-2 border-dashed border-slate-200 bg-slate-50 flex flex-col items-center justify-center cursor-pointer hover:border-cyan-500 hover:bg-cyan-50/30 transition-all overflow-hidden relative group">
                            <img id="newGiftPreview" src="" class="absolute inset-0 w-full h-full object-cover hidden">
                            <div id="newGiftPlaceholder" class="flex flex-col items-center gap-2 text-slate-400 group-hover:text-cyan-600 transition-colors">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span class="text-xs font-bold">Subir Imagen</span>
                            </div>
                            <input type="file" id="newGiftImgInput" class="hidden" accept="image/*" onchange="previewNewGiftImg(this)">
                        </div>
                    </div>

                    <!-- Datos del Regalo -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Nombre</label>
                            <input type="text" id="n_name" placeholder="Ej. Monitor de Bebé" class="w-full px-4 py-3 rounded-xl border-slate-100 bg-slate-50 focus:border-cyan-500 focus:ring-cyan-500 transition-all text-sm font-bold" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Categoría</label>
                            <select id="n_cat" class="w-full px-4 py-3 rounded-xl border-slate-100 bg-slate-50 focus:border-cyan-500 focus:ring-cyan-500 transition-all text-sm font-bold">
                                <option value="Ropa">Ropa</option>
                                <option value="Utensilios">Utensilios</option>
                                <option value="Accesorios">Accesorios</option>
                                <option value="Grupal">Grupal</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Descripción</label>
                            <textarea id="n_desc" placeholder="Breve descripción..." rows="3" class="w-full px-4 py-3 rounded-xl border-slate-100 bg-slate-50 focus:border-cyan-500 focus:ring-cyan-500 transition-all text-sm font-medium resize-none"></textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Precio Estimado (opcional)</label>
                            <input type="number" id="giftPrice" step="0.01" min="0" placeholder="$" class="w-full px-4 py-3 rounded-xl border-slate-100 bg-slate-50 focus:border-cyan-500 focus:ring-cyan-500 transition-all text-sm font-medium">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Cantidad</label>
                            <input type="number" id="giftQty" min="1" value="1" class="w-full px-4 py-3 rounded-xl border-slate-100 bg-slate-50 focus:border-cyan-500 focus:ring-cyan-500 transition-all text-sm font-medium">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Links de Referencia</label>
                            <input type="url" id="giftLink1" placeholder="Link 1 (Amazon, MercadoLibre...)" class="w-full px-4 py-2 mb-2 rounded-xl border-slate-100 bg-slate-50 focus:border-cyan-500 focus:ring-cyan-500 transition-all text-sm font-medium">
                            <input type="url" id="giftLink2" placeholder="Link 2 (opcional)" class="w-full px-4 py-2 mb-2 rounded-xl border-slate-100 bg-slate-50 focus:border-cyan-500 focus:ring-cyan-500 transition-all text-sm font-medium">
                            <input type="url" id="giftLink3" placeholder="Link 3 (opcional)" class="w-full px-4 py-2 rounded-xl border-slate-100 bg-slate-50 focus:border-cyan-500 focus:ring-cyan-500 transition-all text-sm font-medium">
                        </div>
                    </div>
                </div>

                <div class="flex gap-4 mt-10">
                    <button onclick="closeCreateGiftModal()" class="flex-1 px-6 py-4 bg-slate-100 text-red-600 font-bold rounded-2xl hover:bg-slate-200 transition-all">Cancelar</button>
                    <button onclick="createNewGift()" class="flex-1 px-6 py-4 bg-cyan-800 text-white font-bold rounded-2xl hover:bg-cyan-900 shadow-xl transition-all">Crear Regalo</button>
                </div>
            </div>
        </div>
    </div>
</div>
