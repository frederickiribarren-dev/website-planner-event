<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-black text-slate-800 tracking-tight">
                    {{ __('Propuestas de Regalos') }}
                </h2>
                <p class="text-slate-600 font-medium mt-1">Descubre y gestiona las ideas personalizadas enviadas por tus invitados.</p>
            </div>
            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center gap-2 px-6 py-3 rounded-full text-xs font-bold bg-white border border-slate-200 text-slate-500 hover:text-cyan-600 hover:border-cyan-200 shadow-sm uppercase tracking-widest transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Volver al Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-16 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-[3rem] border border-slate-100 p-10 md:p-16 text-center shadow-xl shadow-slate-100/50 relative overflow-hidden">
            {{-- Fondo de gradiente decorativo sutil --}}
            <div class="absolute right-0 top-0 w-80 h-80 bg-teal-50/40 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
            <div class="absolute left-0 bottom-0 w-80 h-80 bg-cyan-50/30 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>

            <div class="relative z-10 space-y-8 max-w-xl mx-auto">
                {{-- Contenedor del Icono/Ilustración sutil --}}
                <div class="w-24 h-24 bg-gradient-to-tr from-teal-50 to-cyan-50 border border-teal-100 rounded-[2rem] flex items-center justify-center mx-auto shadow-inner">
                    <svg class="w-10 h-10 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                </div>

                {{-- Textos principales --}}
                <div class="space-y-3">
                    <span class="inline-block px-4 py-1.5 bg-teal-50 text-teal-700 border border-teal-100 rounded-full text-[10px] font-black uppercase tracking-[0.2em]">Próximamente</span>
                    <h3 class="text-3xl font-black text-slate-800 leading-tight">Sección de Propuestas Personalizadas</h3>
                    <p class="text-slate-500 font-medium text-sm leading-relaxed">
                        Muy pronto podrás visualizar y autorizar las propuestas de regalos que tus invitados ingresen de forma manual en sus tableros de confirmación.
                    </p>
                </div>

                {{-- Lista de características futuras en cajas premium --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-left pt-4">
                    <div class="bg-slate-50/50 border border-slate-100 p-5 rounded-2xl">
                        <p class="font-bold text-slate-700 text-xs uppercase tracking-wide mb-1">Aprobación Rápida</p>
                        <p class="text-[11px] text-slate-400 font-medium leading-relaxed">Acepta propuestas personalizadas con un solo clic para agregarlas a tu lista oficial.</p>
                    </div>
                    <div class="bg-slate-50/50 border border-slate-100 p-5 rounded-2xl">
                        <p class="font-bold text-slate-700 text-xs uppercase tracking-wide mb-1">Evita Duplicados</p>
                        <p class="text-[11px] text-slate-400 font-medium leading-relaxed">El sistema mantendrá el registro de propuestas para evitar que dos invitados regalen lo mismo.</p>
                    </div>
                </div>

                {{-- Botón de acción --}}
                <div class="pt-6">
                    <a href="{{ route('dashboard') }}"
                       class="inline-flex items-center justify-center px-10 py-4 bg-teal-600 hover:bg-teal-700 text-white text-xs font-black uppercase tracking-widest rounded-full shadow-lg shadow-teal-600/20 transition-all transform hover:scale-[1.02] active:scale-95">
                        Entendido, volver
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
