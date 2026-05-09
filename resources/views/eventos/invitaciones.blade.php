
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-black text-3xl text-slate-800 leading-tight tracking-tight">
                    {{ __('Gestión de Invitaciones') }}
                </h2>
                <p class="text-slate-500 text-sm font-medium">Control centralizado de tus eventos y estados.</p>
            </div>
            {{-- Botón eliminado porque ya está en el sidebar --}}
        </div>
    </x-slot>

    <div class="py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            @if($eventos->isEmpty())
                <div class="bg-white rounded-[2.5rem] border-2 border-dashed border-slate-200 p-16 text-center">
                    <div class="w-20 h-20 bg-slate-50 rounded-3xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-black text-slate-800 mb-2">Aún no tienes invitaciones</h3>
                    <p class="text-slate-500 mb-8 max-w-sm mx-auto font-medium">Crea tu evento para empezar a generar invitaciones personalizadas.</p>
                    <a href="{{ route('eventos.create') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-slate-900 text-white text-xs font-black uppercase tracking-[0.2em] rounded-2xl hover:bg-teal-600 transition-all shadow-xl shadow-slate-200">
                        Comenzar Ahora
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($eventos as $evento)
                        <div class="group bg-white rounded-[2.5rem] border border-slate-100 p-8 shadow-sm hover:shadow-xl transition-all duration-500">
                            <!-- Header de la Card -->
                            <div class="flex items-start justify-between mb-8">
                                <div class="space-y-1">
                                    <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest italic">Evento</h4>
                                    <p class="text-xl font-black text-slate-800 group-hover:text-cyan-700 transition-colors">{{ $evento->slug }}</p>
                                </div>
                                
                                @php
                                    $statusClasses = [
                                        'Borrador' => 'bg-slate-100 text-slate-500 border-slate-200',
                                        'Publicado' => 'bg-cyan-50 text-cyan-600 border-cyan-100',
                                        'Finalizado' => 'bg-slate-900 text-white border-slate-900',
                                        'Cancelado' => 'bg-red-50 text-red-500 border-red-100',
                                    ];
                                    $currentStatus = $evento->estado ?? 'Borrador';
                                    $class = $statusClasses[$currentStatus] ?? $statusClasses['Borrador'];
                                @endphp

                                <div class="px-4 py-1.5 rounded-full border text-[9px] font-black uppercase tracking-widest {{ $class }}">
                                    {{ $currentStatus }}
                                </div>
                            </div>
                            
                            <!-- Detalles -->
                            <div class="space-y-4 mb-10">
                                <div class="flex flex-col gap-1">
                                    <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Nombre del Bebé</span>
                                    <p class="text-slate-700 font-bold italic text-lg">{{ $evento->nombre_bebe }}</p>
                                </div>
                                <div class="flex items-center gap-3 text-slate-500 font-bold text-xs bg-slate-50 p-3 rounded-2xl">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    {{ \Carbon\Carbon::parse($evento->fecha_evento)->format('d / m / Y') }}
                                </div>
                            </div>

                            <!-- Acciones -->
                            <div class="grid grid-cols-2 gap-4">
                                <a href="{{ route('eventos.show', $evento->id) }}" class="flex items-center justify-center py-4 bg-cyan-700 text-white text-[10px] font-black uppercase tracking-widest rounded-2xl hover:bg-cyan-800 transition-all shadow-lg shadow-cyan-900/10 group/btn">
                                    Ver Invitación
                                </a>
                                
                                <button type="button" onclick="openCancelModal('{{ route('eventos.destroy', $evento->id) }}')" class="w-full flex items-center justify-center py-4 bg-white border border-red-100 text-red-500 text-[10px] font-black uppercase tracking-widest rounded-2xl hover:bg-red-50 transition-all">
                                    Cancelar Evento
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    @include('eventos.partials.modal-cancelar')
</x-app-layout>
