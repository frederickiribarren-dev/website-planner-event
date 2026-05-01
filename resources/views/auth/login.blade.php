<form action="" method="POST" class="space-y-6">
    @csrf
    
    <div class="space-y-2">
        <label for="email" class="flex items-center gap-2.5 text-xs font-black text-[#335C5C] uppercase tracking-widest ml-1">
            <div class="w-6 h-6 bg-[#335C5C]/10 rounded-lg flex items-center justify-center">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
            </div>
            Correo electrónico
        </label>
        <input type="email" id="email" name="email"
               class="w-full border-slate-200 rounded-[1.25rem] px-6 py-4 bg-white text-slate-900 focus:ring-4 focus:ring-teal-500/10 focus:border-[#335C5C] transition-all duration-300 placeholder:text-slate-300 text-sm shadow-sm hover:border-slate-300"
               placeholder="ejemplo@correo.com" required autofocus>
    </div>

    <div class="space-y-2">
        <div class="flex justify-between items-end px-1">
            <label for="password" class="flex items-center gap-2.5 text-xs font-black text-[#335C5C] uppercase tracking-widest">
                <div class="w-6 h-6 bg-[#335C5C]/10 rounded-lg flex items-center justify-center">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                </div>
                Contraseña
            </label>
            <a href="#" class="text-[10px] text-slate-400 hover:text-[#335C5C] font-bold transition-colors uppercase tracking-wider">¿Olvidaste tu contraseña?</a>
        </div>
        <div class="relative group">
            <input type="password" id="password" name="password"
                   class="w-full border-slate-200 rounded-[1.25rem] px-6 py-4 bg-white text-slate-900 focus:ring-4 focus:ring-teal-500/10 focus:border-[#335C5C] transition-all duration-300 placeholder:text-slate-300 text-sm shadow-sm hover:border-slate-300"
                   placeholder="Ingresa tu contraseña" required>
            <button type="button" class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-300 hover:text-[#335C5C] transition-colors p-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
            </button>
        </div>
    </div>

    <p class="text-center text-sm text-slate-500 mt-10 pt-6 border-t border-slate-100">
        ¿No eres miembro? <button type="button" onclick="closeModal('loginModal'); openModal('registerModal');" class="text-indigo-600 font-bold hover:text-indigo-700 transition-colors">Crea una cuenta</button>
    </p>

    <div class="pt-6">
        <button type="submit" class="w-full group relative bg-[#335C5C] hover:bg-[#264545] text-white font-black py-4.5 px-6 rounded-2xl shadow-xl shadow-[#335C5C]/20 flex items-center justify-center gap-3 transition-all duration-300 active:scale-95 overflow-hidden">
            <!-- Efecto Shimmer -->
            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:animate-shimmer"></div>
            
            <span class="relative z-10 uppercase tracking-widest text-sm">Iniciar Sesión</span>
            <svg class="w-5 h-5 relative z-10 transition-transform duration-300 group-hover:translate-x-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
        </button>
    </div>
</form>

<style>
@keyframes shimmer {
    100% { transform: translateX(100%); }
}
.animate-shimmer {
    animation: shimmer 1.5s infinite;
}
.py-4.5 { padding-top: 1.125rem; padding-bottom: 1.125rem; }
</style>
