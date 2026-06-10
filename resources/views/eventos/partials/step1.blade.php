            <div id="step1" class="step-content max-w-3xl mx-auto px-4">
                <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-8 sm:p-12 space-y-8">
                        <div>
                            <label for="slug" class="block text-sm font-bold text-gray-700 mb-2">Nombre del evento</label>
                            <input type="text" name="slug" id="slug" value="{{ old('slug', $evento->slug ?? '') }}" class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-cyan-600 focus:bg-white transition text-gray-900" placeholder="Ej: baby-shower-liam">
                        </div>
                        <div>
                            <label for="nombre_bebe" class="block text-sm font-bold text-gray-700 mb-2">Nombre del bebé</label>
                            <input type="text" name="nombre_bebe" id="nombre_bebe" value="{{ old('nombre_bebe', $evento->nombre_bebe ?? '') }}" class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-cyan-600 focus:bg-white transition text-gray-900" placeholder="Ej: Liam, Emma..." required>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label for="genero_bebe" class="block text-sm font-bold text-gray-700 mb-2">Género del bebé</label>
                                <select name="genero_bebe" id="genero_bebe" required class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-cyan-600 focus:bg-white transition text-gray-900">
                                    @php $gen = old('genero_bebe', $evento->genero_bebe ?? ''); @endphp
                                    <option value="">Selecciona una opción</option>
                                    <option value="Niño" {{ $gen == 'Niño' ? 'selected' : '' }}>Niño</option>
                                    <option value="Niña" {{ $gen == 'Niña' ? 'selected' : '' }}>Niña</option>
                                    <option value="Sorpresa" {{ $gen == 'Sorpresa' ? 'selected' : '' }}>Sorpresa</option>
                                    <option value="Múltiple" {{ $gen == 'Múltiple' ? 'selected' : '' }}>Múltiple</option>
                                </select>
                            </div>
                            <div>
                                <label for="fecha_evento" class="block text-sm font-bold text-gray-700 mb-2">Fecha del evento</label>
                                <input type="date" name="fecha_evento" id="fecha_evento" value="{{ old('fecha_evento', isset($evento) ? \Carbon\Carbon::parse($evento->fecha_evento)->format('Y-m-d') : '') }}" required class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-cyan-600 focus:bg-white transition text-gray-900">
                            </div>
                            <div>
                                <label for="ubicacion_nombre" class="block text-sm font-bold text-gray-700 mb-2">Dirección del evento</label>
                                <input type="text" name="ubicacion_nombre" id="ubicacion_nombre" value="{{ old('ubicacion_nombre', $evento->ubicacion_nombre ?? '') }}" required class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-cyan-600 focus:bg-white transition text-gray-900" placeholder="Ej: Calle Falsa 123">
                            </div>
                        </div>
                        <div class="pt-4">
                            <button type="button" onclick="goToStep(2)" class="w-full bg-cyan-800 hover:bg-cyan-900 text-white font-bold py-4 px-8 rounded-full shadow-lg transition-all transform hover:scale-[1.02] active:scale-95">Continuar</button>
                        </div>
                    </div>
                </div>
            </div>
