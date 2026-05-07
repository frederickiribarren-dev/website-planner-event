<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Mis Eventos') }}
            </h2>
            <a href="{{ route('eventos.create') }}" class="bg-cyan-700 hover:bg-cyan-800 text-white px-6 py-2 rounded-full text-sm font-medium transition">
                + Crear Nuevo
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        @if($eventos->isEmpty())
            <div class="bg-white p-8 rounded-2xl border border-dashed border-gray-300 text-center text-gray-500">
                Aún no tienes eventos creados.
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($eventos as $evento)
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-lg text-gray-900">{{ $evento->nombre_bebe }}</h3>
                        <p class="text-sm text-gray-500 mt-1">Fecha: {{ $evento->fecha_evento }}</p>
                        @if($evento->ubicacion_nombre)
                            <p class="text-sm text-gray-500 mt-1">Lugar: {{ $evento->ubicacion_nombre }}</p>
                        @endif
                        <p class="text-xs text-gray-400 mt-1">Estado: {{ $evento->estado ?? 'Borrador' }}</p>
                        <div class="mt-4 pt-4 border-t border-gray-50 flex justify-end">
                            <a href="{{ route('eventos.edit', $evento) }}" class="text-cyan-600 text-sm font-bold">Configurar</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>