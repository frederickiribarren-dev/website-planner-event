            <div id="step2" class="step-content hidden max-w-6xl mx-auto px-4">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    <div class="lg:col-span-4 space-y-6">
                        <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm space-y-6">
                            <div>
                                <label for="lista_invitado_id" class="block text-sm font-bold text-gray-700 mb-4 italic underline decoration-cyan-500">Cargar Lista Existente</label>
                                <select id="lista_invitado_id" name="lista_invitado_id" class="w-full bg-gray-50 border-none rounded-xl px-5 py-3 focus:ring-2 focus:ring-cyan-600 transition text-sm font-semibold text-gray-600" onchange="loadExistingList(this.value)">
                                    <option value="">Selecciona una lista...</option>
                                    @forelse($listasInvitados as $lista)
                                        <option value="{{ $lista->id }}" data-count="{{ $lista->invitados->count() }}">
                                            {{ $lista->nombre }} ({{ $lista->invitados->count() }} invitados)
                                        </option>
                                    @empty
                                        <option value="" disabled>No hay listas de invitados disponibles</option>
                                    @endforelse
                                </select>
                                <p class="text-xs text-gray-400 mt-2">Si no tienes listas creadas, agrega los invitados manualmente.</p>
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
