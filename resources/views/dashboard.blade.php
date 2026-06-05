<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight">Resumen del Evento</h1>
                <p class="text-slate-600 font-medium mt-1">Controla cada detalle de tu gran día desde aquí.</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="px-4 py-2 bg-teal-50 text-teal-600 rounded-full text-xs font-black uppercase tracking-widest border border-teal-100">Evento Activo</span>
                <span class="text-slate-300">|</span>
                <p class="text-sm font-bold text-slate-500">{{ now()->format('d M, Y') }}</p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-10 py-4">
        <!-- 1. BANNER DE TIEMPO (SUAVIZADO - GRIS PREMIUM) -->
        <div class="bg-slate-50 p-8 rounded-[2.5rem] border border-slate-200 relative overflow-hidden group shadow-sm">
            <div class="absolute right-0 top-0 w-64 h-64 bg-slate-200/30 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-6">
                    <div class="p-5 bg-white shadow-sm rounded-3xl border border-slate-200">
                        <svg class="w-10 h-10 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-600 uppercase tracking-[0.3em]">REMAINING TIME</p>
                        <h4 class="text-xl font-bold text-slate-700 mt-1">Días para el evento</h4>
                    </div>
                </div>
                <div class="flex items-baseline gap-3 bg-white px-8 py-4 rounded-3xl border border-slate-200 shadow-sm">
                    <span class="text-6xl font-black text-slate-800">24</span>
                    <span class="text-2xl font-bold text-teal-600 uppercase tracking-tighter">Días</span>
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
                <!-- Total Asistentes (Gris Resaltado) -->
                <div class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-slate-100 text-slate-600 rounded-xl border border-slate-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <span class="text-[9px] font-black text-slate-600 bg-slate-50 px-3 py-1 rounded-full border border-slate-100 uppercase tracking-widest">General</span>
                    </div>
                    <p class="text-[10px] font-bold text-slate-600 uppercase tracking-widest">Asistentes</p>
                    <p class="text-4xl font-black text-slate-800 mt-1">45</p>
                    <div class="mt-4 w-full bg-slate-100 h-1 rounded-full overflow-hidden">
                        <div class="bg-teal-600 h-full w-[75%] rounded-full"></div>
                    </div>
                </div>

                <!-- Invitados -->
                <div class="bg-white p-6 rounded-[2rem] border border-slate-100 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-slate-50 text-slate-600 rounded-xl border border-slate-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                    </div>
                    <p class="text-[10px] font-bold text-slate-600 uppercase tracking-widest">Invitados</p>
                    <div class="flex items-baseline gap-2">
                        <p class="text-3xl font-black text-slate-700">30</p>
                        <p class="text-xs font-bold text-slate-600">/ 60 total</p>
                    </div>
                    <p class="text-[10px] font-medium text-teal-600 mt-3 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-teal-400 rounded-full"></span>
                        Pendientes
                    </p>
                </div>

                <!-- Acompañantes -->
                <div class="bg-white p-6 rounded-[2rem] border border-slate-100 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-slate-50 text-slate-600 rounded-xl border border-slate-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                    </div>
                    <p class="text-[10px] font-bold text-slate-600 uppercase tracking-widest">Acompañantes</p>
                    <p class="text-3xl font-black text-slate-700">15</p>
                    <p class="text-[10px] font-medium text-slate-600 mt-3 italic">Extra confirmados</p>
                </div>

                <!-- Regalos -->
                <div class="bg-white p-6 rounded-[2rem] border border-slate-100 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-slate-50 text-slate-600 rounded-xl border border-slate-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12V8H4v4m16 0v8H4v-8m16 0H4m12-4V4H8v4m8 0H8"></path></svg>
                        </div>
                    </div>
                    <p class="text-[10px] font-bold text-slate-600 uppercase tracking-widest">Regalos</p>
                    <div class="flex items-baseline gap-2">
                        <p class="text-3xl font-black text-slate-700">12</p>
                        <span class="text-[10px] text-teal-600 font-bold bg-teal-50 px-2 py-0.5 rounded-md">8 Pend.</span>
                    </div>
                    <div class="mt-4 w-full bg-slate-100 h-1 rounded-full overflow-hidden">
                        <div class="bg-slate-400 h-full w-[40%] rounded-full"></div>
                    </div>
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

            <!-- Última Actividad -->
            <div class="space-y-6">
                <h3 class="text-sm font-black text-slate-600 uppercase tracking-[0.2em] flex items-center gap-3">
                    Actividad Reciente
                    <span class="h-px flex-1 bg-slate-100"></span>
                </h3>
                
                <div class="bg-white border border-slate-100 rounded-[2rem] overflow-hidden shadow-sm">
                    <div class="p-6 space-y-6">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-slate-100 text-slate-600 border border-slate-200 rounded-full flex items-center justify-center font-bold text-xs italic">FI</div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-slate-700">Frederick Iribarren ha confirmado</p>
                                <p class="text-[10px] text-slate-600 uppercase tracking-widest">Hace 2 horas</p>
                            </div>
                            <span class="w-2 h-2 bg-teal-500 rounded-full"></span>
                        </div>
                        <div class="flex items-center gap-4 border-t border-slate-50 pt-6">
                            <div class="w-10 h-10 bg-slate-50 text-slate-600 border border-slate-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12V8H4v4m16 0v8H4v-8m16 0H4m12-4V4H8v4m8 0H8"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-slate-700">Cuna Pro añadida a la lista</p>
                                <p class="text-[10px] text-slate-600 uppercase tracking-widest">Hace 5 horas</p>
                            </div>
                            <span class="w-2 h-2 bg-slate-200 rounded-full"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
