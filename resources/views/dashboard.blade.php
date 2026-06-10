<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight">Resumen del Evento</h1>
                <p class="text-slate-600 font-medium mt-1">Controla cada detalle de tu gran día desde aquí.</p>
            </div>

            <div class="flex items-center gap-3">
                @if($evento)
                    <span class="px-4 py-2 bg-teal-50 text-teal-600 rounded-full text-xs font-black uppercase tracking-widest border border-teal-100">Evento Activo</span>
                    <span class="text-slate-300">|</span>
                    <div class="flex items-center gap-2">
                        <p class="text-sm font-bold text-slate-500">{{ ucfirst(\Carbon\Carbon::parse($evento->fecha_evento)->locale('es')->isoFormat('D [de] MMMM, YYYY')) }}</p>

                        {{-- Flechas de navegación solo si hay más de 1 evento activo --}}
                        @if($eventos->count() > 1)
                            <div class="flex items-center gap-1 ml-1">
                                @if($eventoIndex > 0)
                                    <a href="{{ route('dashboard', ['evento' => $eventoIndex - 1]) }}"
                                       class="w-7 h-7 flex items-center justify-center rounded-full bg-white border border-slate-200 text-slate-500 hover:bg-teal-50 hover:border-teal-300 hover:text-teal-600 transition-all shadow-sm"
                                       title="Evento anterior">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                                    </a>
                                @else
                                    <span class="w-7 h-7 flex items-center justify-center rounded-full bg-slate-50 border border-slate-100 text-slate-300 cursor-not-allowed">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                                    </span>
                                @endif

                                <span class="text-[10px] font-black text-slate-400">{{ $eventoIndex + 1 }}/{{ $eventos->count() }}</span>

                                @if($eventoIndex < $eventos->count() - 1)
                                    <a href="{{ route('dashboard', ['evento' => $eventoIndex + 1]) }}"
                                       class="w-7 h-7 flex items-center justify-center rounded-full bg-white border border-slate-200 text-slate-500 hover:bg-teal-50 hover:border-teal-300 hover:text-teal-600 transition-all shadow-sm"
                                       title="Evento siguiente">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                @else
                                    <span class="w-7 h-7 flex items-center justify-center rounded-full bg-slate-50 border border-slate-100 text-slate-300 cursor-not-allowed">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>
                @else
                    <span class="px-4 py-2 bg-slate-50 text-slate-400 rounded-full text-xs font-black uppercase tracking-widest border border-slate-100">Sin evento</span>
                    <span class="text-slate-300">|</span>
                    <p class="text-sm font-bold text-slate-400">{{ now()->format('d M, Y') }}</p>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="space-y-10 py-4">

        @if(!$evento)
        <!-- ESTADO VACÍO -->
        <div class="flex flex-col items-center justify-center py-20 text-center space-y-6">
            <div class="w-20 h-20 bg-slate-50 border border-slate-100 rounded-3xl flex items-center justify-center">
                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <h3 class="text-xl font-black text-slate-700">Aún no tienes eventos activos</h3>
                <p class="text-slate-400 font-medium mt-2 text-sm">Crea tu primer evento para ver el resumen aquí.</p>
            </div>
            <a href="{{ route('eventos.create') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-full shadow-lg shadow-teal-600/20 transition-all text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Crear nuevo evento
            </a>
        </div>
        @else

        <!-- 1. BANNER DE TIEMPO -->
        <div class="bg-slate-50 p-8 rounded-[2.5rem] border border-slate-200 relative overflow-hidden group shadow-sm">
            <div class="absolute right-0 top-0 w-64 h-64 bg-slate-200/30 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-6">
                    <div class="p-5 bg-teal-600 shadow-sm rounded-3xl border border-slate-200">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-600 uppercase tracking-[0.3em]">{{ $evento->nombre_bebe ?? 'Evento' }}</p>
                        <h4 class="text-xl font-bold text-slate-700 mt-1">
                            @if($stats['dias_restantes'] !== null && $stats['dias_restantes'] > 0)
                                Días para el evento
                            @elseif($stats['dias_restantes'] !== null && $stats['dias_restantes'] <= 0)
                                ¡El evento es hoy o ya ocurrió!
                            @else
                                Fecha no definida
                            @endif
                        </h4>
                        <p class="text-xs text-slate-400 font-medium mt-0.5">{{ ucfirst(\Carbon\Carbon::parse($evento->fecha_evento)->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY')) }}</p>
                    </div>
                </div>
                <div class="flex items-baseline gap-3 bg-white px-8 py-4 rounded-3xl border border-slate-200 shadow-sm">
                    @if($stats['dias_restantes'] !== null && $stats['dias_restantes'] > 0)
                        <span class="text-6xl font-black text-slate-800">{{ $stats['dias_restantes'] }}</span>
                        <span class="text-2xl font-bold text-teal-600 uppercase tracking-tighter">Días</span>
                    @elseif($stats['dias_restantes'] !== null && $stats['dias_restantes'] === 0)
                        <span class="text-3xl font-black text-teal-600">¡Hoy!</span>
                    @else
                        <span class="text-3xl font-black text-slate-400">—</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- 2. GESTIÓN DE ASISTENCIA -->
        <div class="space-y-6">
            <h3 class="text-sm font-black text-slate-600 uppercase tracking-[0.2em] flex items-center gap-3">
                Gestión de Asistencia
                <span class="h-px flex-1 bg-slate-100"></span>
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Invitados -->
                <div class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-teal-600 text-white rounded-xl border border-slate-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <span class="text-[9px] font-black text-slate-600 bg-slate-50 px-3 py-1 rounded-full border border-slate-100 uppercase tracking-widest">General</span>
                    </div>
                    <p class="text-[10px] font-bold text-slate-600 uppercase tracking-widest">Asistentes</p>
                    <p class="text-4xl font-black text-slate-800 mt-1">{{ $stats['total_invitados'] }}</p>
                    @if($stats['total_invitados'] > 0)
                        @php $confirmedPct = round(($stats['confirmados'] / $stats['total_invitados']) * 100); @endphp
                        <div class="mt-4 w-full bg-slate-100 h-1 rounded-full overflow-hidden">
                            <div class="bg-teal-600 h-full rounded-full transition-all" style="width: {{ $confirmedPct }}%"></div>
                        </div>
                        <p class="text-[10px] text-slate-400 font-medium mt-1">{{ $confirmedPct }}% confirmados</p>
                    @else
                        <div class="mt-4 w-full bg-slate-100 h-1 rounded-full overflow-hidden">
                            <div class="bg-teal-600 h-full w-0 rounded-full"></div>
                        </div>
                    @endif
                </div>

                <!-- Invitados confirmados -->
                <div class="bg-white p-6 rounded-[2rem] border border-slate-100 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-teal-600 text-white rounded-xl border border-slate-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                    </div>
                    <p class="text-[10px] font-bold text-slate-600 uppercase tracking-widest">Confirmados</p>
                    <div class="flex items-baseline gap-2">
                        <p class="text-3xl font-black text-slate-700">{{ $stats['confirmados'] }}</p>
                        <p class="text-xs font-bold text-slate-400">/ {{ $stats['total_invitados'] }} total</p>
                    </div>
                    <p class="text-[10px] font-medium text-teal-600 mt-3 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-teal-400 rounded-full"></span>
                        {{ $stats['pendientes'] }} pendientes
                    </p>
                </div>

                <!-- Ubicación -->
                <div class="bg-white p-6 rounded-[2rem] border border-slate-100 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-teal-600 text-white rounded-xl border border-slate-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                    </div>
                    <p class="text-[10px] font-bold text-slate-600 uppercase tracking-widest">Lugar</p>
                    <p class="text-sm font-black text-slate-700 mt-1 leading-snug">{{ $evento->ubicacion_nombre ?? '—' }}</p>
                    <p class="text-[10px] font-medium text-slate-400 mt-3 italic">Ubicación del evento</p>
                </div>

                <!-- Regalos -->
                <div class="bg-white p-6 rounded-[2rem] border border-slate-100 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-teal-600 text-white rounded-xl border border-slate-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12V8H4v4m16 0v8H4v-8m16 0H4m12-4V4H8v4m8 0H8"></path></svg>
                        </div>
                    </div>
                    <p class="text-[10px] font-bold text-slate-600 uppercase tracking-widest">Regalos</p>
                    <div class="flex items-baseline gap-2">
                        <p class="text-3xl font-black text-slate-700">{{ $stats['total_regalos'] }}</p>
                        @if($stats['regalos_pendientes'] > 0)
                            <span class="text-[10px] text-teal-600 font-bold bg-teal-50 px-2 py-0.5 rounded-md">{{ $stats['regalos_pendientes'] }} Pend.</span>
                        @endif
                    </div>
                    @if($stats['total_regalos'] > 0)
                        @php $completadosPct = round((($stats['total_regalos'] - $stats['regalos_pendientes']) / $stats['total_regalos']) * 100); @endphp
                        <div class="mt-4 w-full bg-slate-100 h-1 rounded-full overflow-hidden">
                            <div class="bg-slate-400 h-full rounded-full" style="width: {{ $completadosPct }}%"></div>
                        </div>
                    @else
                        <div class="mt-4 w-full bg-slate-100 h-1 rounded-full overflow-hidden">
                            <div class="bg-slate-400 h-full w-0 rounded-full"></div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- 3. ACCIONES Y ACTIVIDAD -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 pt-4">
            <!-- Acciones Rápidas -->
            <div class="space-y-6">
                <h3 class="text-sm font-black text-slate-600 uppercase tracking-[0.2em] flex items-center gap-3">
                    Acciones Rápidas
                    <span class="h-px flex-1 bg-slate-100"></span>
                </h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <a href="{{ route('invitados.creacion') }}" class="flex items-center gap-4 p-5 bg-white border border-slate-100 rounded-3xl hover:border-slate-300 hover:shadow-md transition-all group">
                        <div class="p-3 bg-slate-100 text-slate-600 rounded-2xl transition-all group-hover:bg-teal-600 group-hover:text-white border border-slate-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <div>
                            <p class="font-bold text-slate-700">Gestionar Invitados</p>
                            <p class="text-[10px] text-slate-600 uppercase font-bold tracking-tighter">Ver confirmaciones</p>
                        </div>
                    </a>

                    <a href="{{ route('regalos.index') }}" class="flex items-center gap-4 p-5 bg-white border border-slate-100 rounded-3xl hover:border-slate-300 hover:shadow-md transition-all group">
                        <div class="p-3 bg-slate-100 text-slate-600 rounded-2xl transition-all group-hover:bg-teal-600 group-hover:text-white border border-slate-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12V8H4v4m16 0v8H4v-8m16 0H4m12-4V4H8v4m8 0H8"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-slate-700">Lista de Regalos</p>
                            <p class="text-[10px] text-slate-600 uppercase font-bold tracking-tighter">Actualizar catálogo</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Actividad Reciente -->
            <div class="space-y-6">
                <h3 class="text-sm font-black text-slate-600 uppercase tracking-[0.2em] flex items-center gap-3">
                    Actividad Reciente
                    <span class="h-px flex-1 bg-slate-100"></span>
                </h3>
                
                <div class="bg-white border border-slate-100 rounded-[2rem] overflow-hidden shadow-sm">
                    <div class="p-6 space-y-6">
                        @forelse($actividadReciente as $index => $actividad)
                            <div class="flex items-center gap-4 {{ $index > 0 ? 'border-t border-slate-50 pt-6' : '' }}">
                                @if($actividad['tipo'] === 'confirmacion')
                                    <div class="w-10 h-10 bg-slate-100 text-slate-600 border border-slate-200 rounded-full flex items-center justify-center font-bold text-xs italic flex-shrink-0">
                                        {{ $actividad['iniciales'] }}
                                    </div>
                                @else
                                    <div class="w-10 h-10 bg-slate-50 text-slate-600 border border-slate-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12V8H4v4m16 0v8H4v-8m16 0H4m12-4V4H8v4m8 0H8"></path>
                                        </svg>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <p class="text-sm font-bold text-slate-700">{{ $actividad['texto'] }}</p>
                                    <p class="text-[10px] text-slate-400 uppercase tracking-widest">
                                        {{ \Carbon\Carbon::parse($actividad['fecha'])->diffForHumans() }}
                                    </p>
                                </div>
                                <span class="w-2 h-2 {{ $actividad['tipo'] === 'confirmacion' ? 'bg-teal-500' : 'bg-slate-300' }} rounded-full flex-shrink-0"></span>
                            </div>
                        @empty
                            <div class="flex flex-col items-center justify-center py-6 text-center space-y-2">
                                <div class="w-10 h-10 bg-slate-50 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <p class="text-sm font-bold text-slate-400">Sin actividad reciente</p>
                                <p class="text-xs text-slate-300">Las confirmaciones y regalos seleccionados aparecerán aquí.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>
    </div>
</x-app-layout>
