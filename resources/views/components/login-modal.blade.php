<!-- resources/views/components/login-modal.blade.php -->
<div id="loginModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/40 backdrop-blur-md transition-all duration-500 p-4">
    <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.15)] w-full max-w-4xl flex overflow-hidden relative max-h-[95vh] animate-fade-in-up border border-white/20">
        
        <!-- Botón de cerrar con efecto hover mejorado -->
        <button 
            onclick="closeModal('loginModal')" 
            class="absolute top-6 right-6 z-10 text-slate-400 hover:text-teal-700 hover:bg-teal-50 p-2 rounded-full transition-all duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Lado Izquierdo (Mejorado con Animaciones y Profundidad) -->
        <div class="hidden lg:flex w-[42%] bg-[#B5E1E1] relative flex-col items-center justify-between p-12 text-center overflow-hidden group">
            <!-- Patrón de fondo sutil -->
            <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/dust.png')] pointer-events-none"></div>
            
            <div class="flex items-center gap-2 self-start relative z-10">
                <div class="w-9 h-9 bg-[#335C5C] rounded-xl flex items-center justify-center shadow-lg shadow-[#335C5C]/20">
                    <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
                </div>
                <span class="text-[#335C5C] font-black text-xl tracking-tighter">PlannerEvents</span>
            </div>

            <div class="relative z-10 w-full">
                <!-- Imagen Circular con Animación de Flotación -->
                <div class="relative w-64 h-64 mx-auto mb-10 group-hover:scale-105 transition-transform duration-700 ease-out">
                    <div class="absolute inset-0 rounded-full bg-[#335C5C]/5 animate-pulse"></div>
                    <div class="w-full h-full rounded-full bg-[#A3D1D1] p-4 shadow-[inset_0_2px_10px_rgba(0,0,0,0.1)] flex items-center justify-center animate-float">
                        <div class="w-full h-full rounded-full overflow-hidden border-4 border-white shadow-2xl">
                            <img src="{{ asset('img/login-register.png') }}" alt="Baby Shower" class="w-full h-full object-cover grayscale-[10%] brightness-105 transition-all duration-700 group-hover:grayscale-0 group-hover:scale-110">
                        </div>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <h2 class="text-[#335C5C] text-3xl font-black leading-tight tracking-tight">El comienzo de<br><span class="text-white bg-[#335C5C] px-2 py-0.5 rounded-lg">algo hermoso</span></h2>
                    <p class="text-[#335C5C]/70 text-sm leading-relaxed px-6 font-medium">
                        Crea recuerdos que duren para siempre con nuestra plataforma de planificación inteligente.
                    </p>
                </div>
            </div>

            <div class="relative z-10 text-[#335C5C]/40 text-[10px] font-bold uppercase tracking-[0.2em]">
                Est. 2026 • plannersevents
            </div>
            
            <!-- Decoraciones de fondo -->
            <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -top-20 -right-20 w-64 h-64 bg-[#335C5C]/10 rounded-full blur-3xl"></div>
        </div>

        <!-- Lado Derecho (Mejorado con Refinamiento UX) -->
        <div class="w-full lg:w-[58%] p-8 lg:p-14 overflow-y-auto bg-slate-50/10">
            <!-- Pestañas con indicador animado (Simulado con CSS) -->
            <div class="flex gap-10 border-b border-slate-100 mb-10 relative">
                <button class="pb-4 text-sm font-black text-[#335C5C] relative">
                    Iniciar Sesión
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-[#335C5C] rounded-full"></div>
                </button>
                <button onclick="closeModal('loginModal'); openModal('registerModal');" class="pb-4 text-sm font-bold text-slate-400 hover:text-slate-600 transition-all">Registro</button>
            </div>

            <div class="mb-10">
                <h3 class="text-3xl font-black text-slate-900 mb-3 tracking-tight">¡Hola de nuevo!</h3>
                <p class="text-slate-500 text-sm font-medium">Ingresa para continuar organizando tu evento ideal.</p>
            </div>

            <!-- Login Social con Efecto Hover Premium -->
            <div class="mb-8">
                <button type="button" class="w-full group flex items-center justify-center gap-3 bg-white border border-slate-200 rounded-2xl px-4 py-3.5 text-sm font-bold text-slate-700 hover:border-teal-200 hover:bg-teal-50/30 transition-all duration-300 shadow-sm active:scale-95">
                    <div class="bg-white p-1 rounded-lg shadow-sm border border-slate-100">
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                        </svg>
                    </div>
                    <span>Continuar con Google</span>
                </button>
            </div>

            <div class="relative flex items-center mb-10">
                <div class="flex-grow border-t border-slate-100"></div>
                <span class="flex-shrink-0 mx-6 text-slate-300 text-[10px] font-black uppercase tracking-[0.25em]">O usa tu email</span>
                <div class="flex-grow border-t border-slate-100"></div>
            </div>

            @include('auth.login')
        </div>
    </div>
</div>

<style>
@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-12px); }
}
.animate-float {
    animation: float 4s ease-in-out infinite;
}
</style>
