
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
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
                    </div>
                    <div class="pt-4">
                        <button type="submit" class="w-full bg-cyan-800 hover:bg-cyan-900 text-white font-bold py-4 px-8 rounded-full shadow-lg shadow-cyan-900/20 transition-all transform hover:scale-[1.02] active:scale-95">
                            {{ __('Continuar') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>