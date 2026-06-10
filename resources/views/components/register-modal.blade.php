<!-- resources/views/components/register-modal.blade.php -->
<div id="registerModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/40 backdrop-blur-md transition-all duration-500 p-4">
    <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.15)] w-full max-w-4xl flex overflow-hidden relative max-h-[95vh] animate-fade-in-up border border-white/20">
        
        <!-- Botón de cerrar -->
        <button 
            onclick="closeModal('registerModal')" 
            class="absolute top-6 right-6 z-10 text-slate-400 hover:text-teal-700 hover:bg-teal-50 p-2 rounded-full transition-all duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Lado Izquierdo (Mejorado) -->
        <div class="hidden lg:flex w-[42%] bg-[#B5E1E1] relative flex-col items-center justify-between p-12 text-center overflow-hidden group">
            <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/dust.png')] pointer-events-none"></div>
            
            <div class="flex items-center gap-2 self-start relative z-10">
                <div class="w-9 h-9 bg-[#335C5C] rounded-xl flex items-center justify-center shadow-lg shadow-[#335C5C]/20">
                    <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
                </div>
                <span class="text-[#335C5C] font-black text-xl tracking-tighter">PlannerEvents</span>
            </div>

            <div class="relative z-10 w-full">
                <div class="relative w-64 h-64 mx-auto mb-10 group-hover:scale-105 transition-transform duration-700 ease-out">
                    <div class="absolute inset-0 rounded-full bg-[#335C5C]/5 animate-pulse"></div>
                    <div class="w-full h-full rounded-full bg-[#A3D1D1] p-4 shadow-[inset_0_2px_10px_rgba(0,0,0,0.1)] flex items-center justify-center animate-float">
                        <div class="w-full h-full rounded-full overflow-hidden border-4 border-white shadow-2xl">
                            <img src="{{ asset('img/login-register.png') }}" alt="Baby Shower" class="w-full h-full object-cover grayscale-[10%] brightness-105 transition-all duration-700 group-hover:grayscale-0 group-hover:scale-110">
                        </div>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <h2 class="text-[#335C5C] text-3xl font-black leading-tight tracking-tight">Crea recuerdos<br><span class="text-white bg-[#335C5C] px-2 py-0.5 rounded-lg">inolvidables</span></h2>
                    <p class="text-[#335C5C]/70 text-sm leading-relaxed px-6 font-medium">
                        Todo lo que necesitas para tu evento perfecto, en un solo lugar.
                    </p>
                </div>
            </div>

            <div class="relative z-10 text-[#335C5C]/40 text-[10px] font-bold uppercase tracking-[0.2em]">
                Est. 2026 • plannersevents
            </div>
            
            <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -top-20 -right-20 w-64 h-64 bg-[#335C5C]/10 rounded-full blur-3xl"></div>
        </div>

        <!-- Lado Derecho (Mejorado) -->
        <div class="w-full lg:w-[58%] p-8 lg:p-14 overflow-y-auto bg-slate-50/10">
            <div class="flex gap-10 border-b border-slate-100 mb-10 relative">
                <button onclick="closeModal('registerModal'); openModal('loginModal');" class="pb-4 text-sm font-bold text-slate-400 hover:text-slate-600 transition-all">Iniciar Sesión</button>
                <button class="pb-4 text-sm font-black text-[#335C5C] relative">
                    Registro
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-[#335C5C] rounded-full"></div>
                </button>
            </div>

            <div class="mb-10">
                <h3 class="text-3xl font-black text-slate-900 mb-3 tracking-tight">Crea tu cuenta</h3>
                <p class="text-slate-500 text-sm font-medium">Únete para empezar a organizar tu evento ideal hoy mismo.</p>
            </div>


            @include('auth.partials.register-form')
        </div>
    </div>
</div>
