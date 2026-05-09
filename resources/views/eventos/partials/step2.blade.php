            <div id="step2" class="step-content hidden max-w-6xl mx-auto px-4">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    <div class="lg:col-span-4 space-y-6">
                        <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-4 italic underline decoration-cyan-500">Opciones de Carga Rápida</label>
                                <select onchange="loadPrebuiltList(this.value)" class="w-full bg-gray-50 border-none rounded-xl px-5 py-3 focus:ring-2 focus:ring-cyan-600 transition text-sm font-semibold text-gray-600">
                                    <option value="">Cargar lista guardada...</option>
                                    <option value="familia">Familia Directa (15)</option>
                                    <option value="amigos">Amigos Cercanos (20)</option>
                                    <option value="trabajo">Compañeros de Trabajo (10)</option>
                                </select>
                            </div>
                            <div class="pt-6 border-t border-gray-50">
                                <label class="cursor-pointer w-full flex items-center justify-center gap-3 px-6 py-4 bg-pink-50 border border-pink-100 text-pink-500 font-bold rounded-2xl hover:bg-pink-100 transition-all text-xs">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                    Importar Excel / CSV
                                    <input type="file" class="hidden" accept=".xlsx,.csv">
                                </label>
                            </div>
                        </div>
                        <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm">
                            <h3 class="font-bold text-gray-800 mb-6">Añadir Manualmente</h3>
                            <div class="space-y-4">
                                <input type="text" id="guest_name" placeholder="Nombre completo..." class="w-full bg-gray-50 border-none rounded-xl px-5 py-3 focus:ring-2 focus:ring-cyan-600 transition text-sm">
                                <input type="email" id="guest_email" placeholder="Correo electrónico..." class="w-full bg-gray-50 border-none rounded-xl px-5 py-3 focus:ring-2 focus:ring-cyan-600 transition text-sm">
                                <input type="tel" id="guest_phone" placeholder="Teléfono..." class="w-full bg-gray-50 border-none rounded-xl px-5 py-3 focus:ring-2 focus:ring-cyan-600 transition text-sm">
                                <button type="button" onclick="addGuest()" class="w-full bg-cyan-700 hover:bg-cyan-800 text-white font-bold py-4 px-6 rounded-2xl flex items-center justify-center gap-2 transition-all shadow-md shadow-cyan-900/10">Añadir invitado</button>
                            </div>
                        </div>
                    </div>
                    <div class="lg:col-span-8 flex flex-col">
                        <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden flex flex-col h-full">
                            <div class="p-8 flex items-center justify-between border-b border-gray-50">
                                <div class="flex items-center gap-4">
                                    <h3 class="font-bold text-xl text-gray-800">Lista de Invitados</h3>
                                    <span id="guest-count" class="px-4 py-1 bg-cyan-50 text-cyan-700 rounded-full text-xs font-bold uppercase tracking-widest">0 Añadidos</span>
                                </div>
                            </div>
                            <div class="flex-1 overflow-y-auto" style="max-height: 440px;">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="bg-gray-50/50 sticky top-0 z-10">
                                            <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest bg-gray-50">Nombre</th>
                                            <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest bg-gray-50">Correo</th>
                                            <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest bg-gray-50">Teléfono</th>
                                            <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-right bg-gray-50">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody id="guest-table-body" class="divide-y divide-gray-50"></tbody>
                                </table>
                            </div>
                            <div class="p-6 border-t border-gray-50 flex items-center justify-between bg-gray-50/30">
                                <p class="text-xs text-gray-400 font-medium">Mostrando <span class="font-bold text-gray-600" id="pagination-info">0-0</span> de <span class="font-bold text-gray-600" id="total-guests-label">0</span></p>
                                <div class="flex gap-2">
                                    <button type="button" id="btn-prev" onclick="prevPage()" class="px-4 py-2 rounded-lg bg-white border border-gray-200 text-gray-400 hover:text-cyan-600 transition-all text-xs font-bold">Ant.</button>
                                    <button type="button" id="btn-next" onclick="nextPage()" class="px-4 py-2 rounded-lg bg-white border border-gray-200 text-gray-400 hover:text-cyan-600 transition-all text-xs font-bold">Sig.</button>
                                </div>
                            </div>
                        </div>
                        <div class="mt-8 flex justify-between gap-4">
                            <button type="button" onclick="goToStep(1)" class="px-10 py-4 bg-white border border-gray-200 text-gray-500 font-bold rounded-full hover:bg-gray-50 transition-all shadow-sm">Volver</button>
                            <button type="button" onclick="goToStep(3)" class="px-12 py-4 bg-cyan-800 hover:bg-cyan-900 text-white font-bold rounded-full shadow-lg shadow-cyan-900/20 transition-all transform hover:scale-[1.02] active:scale-95">Continuar</button>
                        </div>
                    </div>
                </div>
            </div>
