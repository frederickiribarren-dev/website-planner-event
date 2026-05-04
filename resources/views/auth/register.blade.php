<x-guest-layout>
    <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.15)] w-full max-w-4xl flex overflow-hidden relative max-h-[95vh] border border-white/20">
        
        <!-- Lado Izquierdo -->
        <div class="hidden lg:flex w-[42%] bg-[#B5E1E1] relative flex-col items-center justify-between p-12 text-center overflow-hidden group">
            <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/dust.png')] pointer-events-none"></div>
            
            <div class="flex items-center gap-2 self-start relative z-10">
                <a href="/">
                    <x-application-logo />
                </a>
            </div>

            <div class="relative z-10 w-full">
                <div class="relative w-56 h-56 mx-auto mb-10 group-hover:scale-105 transition-transform duration-700 ease-out">
                    <div class="absolute inset-0 rounded-full bg-[#335C5C]/5 animate-pulse"></div>
                    <div class="w-full h-full rounded-full bg-[#A3D1D1] p-4 shadow-[inset_0_2px_10px_rgba(0,0,0,0.1)] flex items-center justify-center animate-float">
                        <div class="w-full h-full rounded-full overflow-hidden border-4 border-white shadow-2xl">
                            <img src="{{ asset('img/login-register.png') }}" alt="Planner Logo" class="w-full h-full object-cover grayscale-[10%] brightness-105 transition-all duration-700 group-hover:grayscale-0 group-hover:scale-110">
                        </div>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <h2 class="text-[#335C5C] text-2xl font-black leading-tight tracking-tight">Únete a nuestra<br><span class="text-white bg-[#335C5C] px-2 py-0.5 rounded-lg">comunidad</span></h2>
                    <p class="text-[#335C5C]/70 text-xs leading-relaxed px-6 font-medium">
                        Empieza a planificar tus momentos especiales con la mejor herramienta del mercado.
                    </p>
                </div>
            </div>

            <div class="relative z-10 text-[#335C5C]/40 text-[10px] font-bold uppercase tracking-[0.2em]">
                Est. 2026 • plannersevents
            </div>
        </div>

        <!-- Lado Derecho -->
        <div class="w-full lg:w-[58%] p-8 lg:p-14 overflow-y-auto bg-slate-50/10">
            <div class="mb-10">
                <h3 class="text-3xl font-black text-slate-900 mb-3 tracking-tight">Crear cuenta</h3>
                <p class="text-slate-500 text-sm font-medium">Únete a nuestra plataforma hoy mismo.</p>
            </div>

            @include('auth.partials.register-form')
        </div>
    </div>
</x-guest-layout>

<style>
@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-12px); }
}
.animate-float {
    animation: float 4s ease-in-out infinite;
}
</style>
