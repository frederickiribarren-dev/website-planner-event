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

                <form action="{{ route('invitados.creacion.store') }}" method="POST" class="space-y-4" onsubmit="prepareGuestsJson(event)">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Nombre de la Lista</label>
                        <input type="text" name="list_name" class="w-full px-4 py-2.5 rounded-xl border-slate-200 focus:border-cyan-500 focus:ring-cyan-500 transition-all" placeholder="Ej. Familia Directa" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Categoría (opcional)</label>
                        <input type="text" name="list_category" class="w-full px-4 py-2.5 rounded-xl border-slate-200 focus:border-cyan-500 focus:ring-cyan-500 transition-all" placeholder="Familia, Amigos, Trabajo...">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Evento (opcional)</label>
                        <select name="evento_id" class="w-full px-4 py-2.5 rounded-xl border-slate-200 focus:border-cyan-500 focus:ring-cyan-500 transition-all">
                            <option value="">Sin evento</option>
                            @isset($eventos)
                                @foreach($eventos as $ev)
                                    <option value="{{ $ev->id }}">{{ $ev->nombre ?? $ev->titulo ?? ('Evento ' . $ev->id) }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>

                    <hr class="my-2">

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Nombre Completo</label>
                        <input type="text" id="manual_name" name="manual_name" class="w-full px-4 py-2.5 rounded-xl border-slate-200 focus:border-cyan-500 focus:ring-cyan-500 transition-all" placeholder="Ej. Juan Pérez" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Correo Electrónico</label>
                        <input type="email" id="manual_email" name="manual_email" class="w-full px-4 py-2.5 rounded-xl border-slate-200 focus:border-cyan-500 focus:ring-cyan-500 transition-all" placeholder="juan@ejemplo.com">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Teléfono / WhatsApp</label>
                        <input type="tel" id="manual_phone" name="manual_phone" class="w-full px-4 py-2.5 rounded-xl border-slate-200 focus:border-cyan-500 focus:ring-cyan-500 transition-all" placeholder="+56 9 ...">
                    </div>

                    <input type="hidden" name="guests_json" id="guests_json">

                    <div class="flex gap-3 pt-4">
                        <button type="button" onclick="closeModal('modalManual')" 
                                class="flex-1 px-4 py-2.5 rounded-xl font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors">
                            Cancelar
                        </button>
                        <button type="submit" 
                                class="flex-1 px-4 py-2.5 rounded-xl font-semibold text-white bg-cyan-600 hover:bg-cyan-700 transition-colors shadow-lg shadow-cyan-100">
                            Guardar Lista y Invitado
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function prepareGuestsJson(e) {
        // build guests array from manual inputs
        const name = document.getElementById('manual_name').value.trim();
        if (!name) {
            e.preventDefault();
            alert('El nombre del invitado es obligatorio.');
            return false;
        }
        const email = document.getElementById('manual_email').value.trim();
        const phone = document.getElementById('manual_phone').value.trim();

        const guest = { name: name };
        if (email) guest.email = email;
        if (phone) guest.phone = phone;

        document.getElementById('guests_json').value = JSON.stringify([guest]);
        return true;
    }
</script>
