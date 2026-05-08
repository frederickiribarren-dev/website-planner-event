<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight">Resumen del Evento</h1>
                <p class="text-slate-400 font-medium mt-1">Controla cada detalle de tu gran día desde aquí.</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="px-4 py-2 bg-emerald-50 text-emerald-600 rounded-full text-xs font-black uppercase tracking-widest border border-emerald-100">Evento Activo</span>
                <span class="text-slate-300">|</span>
                <p class="text-sm font-bold text-slate-500">{{ now()->format('d M, Y') }}</p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-8">
        <!-- SECCIÓN DE INVITADOS (FRACCIONADA) -->
        <div class="space-y-4">
            <h3 class="text-xl font-black text-slate-800 flex items-center gap-3">
                Gestión de Asistencia
                <span class="h-1 w-12 bg-cyan-600 rounded-full"></span>
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- 1. Invitados Principales -->
                <div class="bg-white p-8 rounded-[2rem] border border-slate-100 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-4 bg-cyan-50 text-cyan-600 rounded-2xl">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <span class="text-sm font-black text-cyan-600 bg-cyan-50 px-4 py-1.5 rounded-full border border-cyan-100">Invitados</span>
                    </div>
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Confirmados</p>
                    <div class="flex items-baseline gap-2 mt-1">
                        <p class="text-4xl font-black text-slate-800">30</p>
                        <p class="text-sm font-bold text-slate-400">/ 60 total</p>
                    </div>
                    <p class="text-xs font-bold text-amber-500 mt-4 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        30 faltan por confirmar
                    </p>
                </div>

                <!-- 2. Acompañantes -->
                <div class="bg-white p-8 rounded-[2rem] border border-slate-100 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-4 bg-emerald-50 text-emerald-600 rounded-2xl">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <span class="text-sm font-black text-emerald-600 bg-emerald-50 px-4 py-1.5 rounded-full border border-emerald-100">+ Acompañantes</span>
                    </div>
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Total Extra</p>
                    <div class="flex items-baseline gap-2 mt-1">
                        <p class="text-4xl font-black text-slate-800">15</p>
                        <p class="text-sm font-bold text-slate-400">confirmados</p>
                    </div>
                    <p class="text-xs font-medium text-slate-400 mt-4 italic">Confirmados por invitados principales</p>
                </div>

                <!-- 3. Total Final -->
                <div class="bg-slate-900 p-8 rounded-[2rem] transition-all duration-300 relative overflow-hidden group">
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-cyan-500/10 rounded-full blur-3xl transition-all"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-4 bg-white/10 text-white rounded-2xl">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <span class="text-sm font-black text-cyan-400 bg-white/5 px-4 py-1.5 rounded-full border border-white/10">Suma Total</span>
                        </div>
                        <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Aforo Confirmado</p>
                        <div class="flex items-baseline gap-2 mt-1">
                            <p class="text-5xl font-black text-white">45</p>
                            <p class="text-xl font-bold text-cyan-400">Asistentes</p>
                        </div>
                        <div class="mt-6 w-full bg-white/10 h-2 rounded-full overflow-hidden">
                            <div class="bg-cyan-500 h-full w-[75%] rounded-full"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECCIÓN DE REGALOS Y TIEMPO -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Regalos -->
            <div class="bg-white p-8 rounded-[2rem] border border-slate-100 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-4 bg-amber-50 text-amber-600 rounded-2xl transition-colors duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12V8H4v4m16 0v8H4v-8m16 0H4m12-4V4H8v4m8 0H8"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-black text-amber-600 bg-amber-100/50 px-4 py-1.5 rounded-full border border-amber-200">8 pendientes</span>
                </div>
                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Regalos</p>
                <div class="flex items-baseline gap-2 mt-1">
                    <p class="text-4xl font-black text-slate-800">12</p>
                    <p class="text-sm font-bold text-slate-400">seleccionados</p>
                </div>
                <div class="mt-6 w-full bg-slate-50 h-2 rounded-full overflow-hidden">
                    <div class="bg-amber-500 h-full w-[40%] rounded-full"></div>
                </div>
            </div>

            <!-- Cuenta Regresiva -->
            <div class="bg-white p-8 rounded-[2rem] border border-slate-100 relative overflow-hidden group">
                <div class="relative z-10 flex items-center gap-8">
                    <div class="p-6 bg-slate-50 text-slate-800 rounded-[2rem] border border-slate-100">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Faltan para el evento</p>
                        <div class="flex items-baseline gap-2 mt-1">
                            <p class="text-5xl font-black text-slate-800">24</p>
                            <p class="text-xl font-bold text-cyan-600 uppercase tracking-tighter">Días</p>
                        </div>
                        <p class="text-xs text-slate-400 mt-2 font-medium italic">Fecha del evento: 15 de Junio, 2024</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Secciones de Acción y Actividad -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Acciones Rápidas -->
            <div class="space-y-6">
                <h3 class="text-xl font-black text-slate-800 flex items-center gap-3">
                    Acciones Rápidas
                    <span class="h-1 w-12 bg-cyan-600 rounded-full"></span>
                </h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <a href="{{ route('invitados.creacion') }}" class="flex items-center gap-4 p-5 bg-white border border-slate-100 rounded-3xl hover:border-cyan-200 hover:bg-cyan-50/30 transition-all group">
                        <div class="p-3 bg-cyan-50 text-cyan-600 rounded-2xl group-hover:bg-cyan-600 group-hover:text-white transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <div>
                            <p class="font-bold text-slate-800">Gestionar Invitados</p>
                            <p class="text-xs text-slate-400">Ver confirmaciones</p>
                        </div>
                    </a>

                    <a href="{{ route('regalos.index') }}" class="flex items-center gap-4 p-5 bg-white border border-slate-100 rounded-3xl hover:border-cyan-200 hover:bg-cyan-50/30 transition-all group">
                        <div class="p-3 bg-amber-50 text-amber-600 rounded-2xl group-hover:bg-amber-500 group-hover:text-white transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12V8H4v4m16 0v8H4v-8m16 0H4m12-4V4H8v4m8 0H8"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-slate-800">Lista de Regalos</p>
                            <p class="text-xs text-slate-400">Actualizar catálogo</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Última Actividad -->
            <div class="space-y-6">
                <h3 class="text-xl font-black text-slate-800 flex items-center gap-3">
                    Actividad Reciente
                    <span class="h-1 w-12 bg-emerald-500 rounded-full"></span>
                </h3>
                
                <div class="bg-white border border-slate-100 rounded-[2rem] overflow-hidden">
                    <div class="p-6 space-y-6">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-cyan-50 text-cyan-600 rounded-full flex items-center justify-center font-bold text-xs italic">FI</div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-slate-800">Frederick Iribarren ha confirmado</p>
                                <p class="text-[10px] text-slate-400 uppercase tracking-widest">Hace 2 horas</p>
                            </div>
                            <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                        </div>
                        <div class="flex items-center gap-4 border-t border-slate-50 pt-6">
                            <div class="w-10 h-10 bg-amber-50 text-amber-600 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12V8H4v4m16 0v8H4v-8m16 0H4m12-4V4H8v4m8 0H8"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-slate-800">Cuna Pro añadida a la lista</p>
                                <p class="text-[10px] text-slate-400 uppercase tracking-widest">Hace 5 horas</p>
                            </div>
                            <span class="w-2 h-2 bg-amber-500 rounded-full"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
