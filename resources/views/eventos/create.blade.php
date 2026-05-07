
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('eventos.index') }}" class="text-gray-400 hover:text-cyan-700 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Crear Nuevo Evento') }}
            </h2>
        </div>
        <!-- Barra de pasos -->
        <div class="flex justify-center mt-6 mb-2">
            <div class="flex items-center gap-6">
                <div class="flex flex-col items-center">
                    <div class="w-8 h-8 flex items-center justify-center rounded-full bg-cyan-700 text-white font-bold border-4 border-cyan-700">1</div>
                    <span class="text-xs mt-1 font-semibold text-cyan-700">Evento</span>
                </div>
                <div class="w-8 h-1 bg-cyan-200"></div>
                <div class="flex flex-col items-center">
                    <div class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-200 text-gray-400 font-bold border-4 border-gray-200">2</div>
                    <span class="text-xs mt-1 font-semibold text-gray-400">Invitados</span>
                </div>
                <div class="w-8 h-1 bg-cyan-200"></div>
                <div class="flex flex-col items-center">
                    <div class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-200 text-gray-400 font-bold border-4 border-gray-200">3</div>
                    <span class="text-xs mt-1 font-semibold text-gray-400">Mensaje</span>
                </div>
                <div class="w-8 h-1 bg-cyan-200"></div>
                <div class="flex flex-col items-center">
                    <div class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-200 text-gray-400 font-bold border-4 border-gray-200">4</div>
                    <span class="text-xs mt-1 font-semibold text-gray-400">Resumen</span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto py-10">
        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-8 sm:p-12">
                <form method="POST" action="{{ route('eventos.store') }}" class="space-y-8">
                    @csrf

                    <div>
                        <label for="slug" class="block text-sm font-bold text-gray-700 mb-2">Nombre del evento</label>
                        <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                            class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-cyan-600 focus:bg-white transition text-gray-900 placeholder-gray-400"
                            placeholder="Ej: baby-shower-liam">
                        @error('slug') <p class="mt-2 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror

                    <div>
                        <label for="nombre_bebe" class="block text-sm font-bold text-gray-700 mb-2">Nombre del bebé</label>
                        <input type="text" name="nombre_bebe" id="nombre_bebe" value="{{ old('nombre_bebe') }}"
                            class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-cyan-600 focus:bg-white transition text-gray-900 placeholder-gray-400"
                            placeholder="Ej: Liam, Emma..." required>
                        @error('nombre_bebe') <p class="mt-2 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label for="genero_bebe" class="block text-sm font-bold text-gray-700 mb-2">Género del bebé</label>
                            <select name="genero_bebe" id="genero_bebe" required
                                class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-cyan-600 focus:bg-white transition text-gray-900">
                                <option value="">Selecciona una opción</option>
                                <option value="Niño" {{ old('genero_bebe')=='Niño' ? 'selected' : '' }}>Niño</option>
                                <option value="Niña" {{ old('genero_bebe')=='Niña' ? 'selected' : '' }}>Niña</option>
                                <option value="Sorpresa" {{ old('genero_bebe')=='Sorpresa' ? 'selected' : '' }}>Sorpresa</option>
                                <option value="Múltiple" {{ old('genero_bebe')=='Múltiple' ? 'selected' : '' }}>Múltiple</option>
                            </select>
                            @error('genero_bebe') <p class="mt-2 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="fecha_evento" class="block text-sm font-bold text-gray-700 mb-2">Fecha del evento</label>
                            <input type="date" name="fecha_evento" id="fecha_evento" value="{{ old('fecha_evento') }}"
                                class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-cyan-600 focus:bg-white transition text-gray-900" required>
                            @error('fecha_evento') <p class="mt-2 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label for="ubicacion_nombre" class="block text-sm font-bold text-gray-700 mb-2">Nombre del lugar / Dirección</label>
                            <input type="text" name="ubicacion_nombre" id="ubicacion_nombre" value="{{ old('ubicacion_nombre') }}"
                                class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-cyan-600 focus:bg-white transition text-gray-900 placeholder-gray-400"
                                placeholder="Ej: Salón Las Palmeras">
                            @error('ubicacion_nombre') <p class="mt-2 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                        </div>
                        <div class="flex gap-4">
                            <div class="w-1/2">
                                <label for="lat" class="block text-sm font-bold text-gray-700 mb-2">Latitud (opcional)</label>
                                <input type="text" name="lat" id="lat" value="{{ old('lat') }}"
                                    class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-cyan-600 focus:bg-white transition text-gray-900 placeholder-gray-400"
                                    placeholder="Latitud">
                                @error('lat') <p class="mt-2 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                            </div>
                            <div class="w-1/2">
                                <label for="lng" class="block text-sm font-bold text-gray-700 mb-2">Longitud (opcional)</label>
                                <input type="text" name="lng" id="lng" value="{{ old('lng') }}"
                                    class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-cyan-600 focus:bg-white transition text-gray-900 placeholder-gray-400"
                                    placeholder="Longitud">
                                @error('lng') <p class="mt-2 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="mensaje_invitacion" class="block text-sm font-bold text-gray-700 mb-2">Mensaje de invitación (opcional)</label>
                        <textarea name="mensaje_invitacion" id="mensaje_invitacion" rows="3"
                            class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-cyan-600 focus:bg-white transition text-gray-900 placeholder-gray-400"
                            placeholder="Escribe un mensaje especial para tus invitados...">{{ old('mensaje_invitacion') }}</textarea>
                        @error('mensaje_invitacion') <p class="mt-2 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label for="color_tema" class="block text-sm font-bold text-gray-700 mb-2">Color del tema (opcional)</label>
                            <input type="color" name="color_tema" id="color_tema" value="{{ old('color_tema', '#60A5FA') }}"
                                class="w-16 h-12 p-0 border-none rounded-2xl focus:ring-2 focus:ring-cyan-600 focus:bg-white transition">
                            @error('color_tema') <p class="mt-2 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="estado" class="block text-sm font-bold text-gray-700 mb-2">Estado del evento</label>
                            <select name="estado" id="estado"
                                class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-cyan-600 focus:bg-white transition text-gray-900">
                                <option value="Borrador" {{ old('estado')=='Borrador' ? 'selected' : '' }}>Borrador</option>
                                <option value="Publicado" {{ old('estado')=='Publicado' ? 'selected' : '' }}>Publicado</option>
                                <option value="Finalizado" {{ old('estado')=='Finalizado' ? 'selected' : '' }}>Finalizado</option>
                                <option value="Cancelado" {{ old('estado')=='Cancelado' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                            @error('estado') <p class="mt-2 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="imagen_portada_url" class="block text-sm font-bold text-gray-700 mb-2">URL de imagen de portada (opcional)</label>
                        <input type="text" name="imagen_portada_url" id="imagen_portada_url" value="{{ old('imagen_portada_url') }}"
                            class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-cyan-600 focus:bg-white transition text-gray-900 placeholder-gray-400"
                            placeholder="https://...">
                        @error('imagen_portada_url') <p class="mt-2 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-cyan-800 hover:bg-cyan-900 text-white font-bold py-4 px-8 rounded-full shadow-lg shadow-cyan-900/20 transition-all transform hover:scale-[1.02] active:scale-95">
                            {{ __('Guardar Evento y Continuar') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>