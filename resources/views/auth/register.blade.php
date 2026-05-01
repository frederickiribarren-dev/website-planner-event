<form action="/registro" method="POST" class="space-y-5">
    @csrf
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="space-y-2">
            <label for="nombre" class="flex items-center gap-2.5 text-xs font-black text-[#335C5C] uppercase tracking-widest ml-1">
                <div class="w-6 h-6 bg-[#335C5C]/10 rounded-lg flex items-center justify-center">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                </div>
                Nombre completo
            </label>
            <input type="text" id="nombre" name="nombre"
                   class="w-full border-slate-200 rounded-2xl px-6 py-3.5 bg-white text-slate-900 text-sm focus:ring-4 focus:ring-teal-500/10 focus:border-[#335C5C] transition-all duration-300 shadow-sm"
                   placeholder="Dinos tu nombre..." required autofocus>
        </div>

        <div class="space-y-2">
            <label for="telefono" class="flex items-center gap-2.5 text-xs font-black text-[#335C5C] uppercase tracking-widest ml-1">
                <div class="w-6 h-6 bg-[#335C5C]/10 rounded-lg flex items-center justify-center">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                </div>
                Teléfono <span class="text-slate-300 font-bold ml-1 tracking-normal">(Opcional)</span>
            </label>
            <input type="tel" id="telefono" name="telefono"
                   class="w-full border-slate-200 rounded-2xl px-6 py-3.5 bg-white text-slate-900 text-sm focus:ring-4 focus:ring-teal-500/10 focus:border-[#335C5C] transition-all duration-300 shadow-sm"
                   placeholder="+34 600 000 000">
        </div>
    </div>

    <div class="space-y-2">
        <label for="email" class="flex items-center gap-2.5 text-xs font-black text-[#335C5C] uppercase tracking-widest ml-1">
            <div class="w-6 h-6 bg-[#335C5C]/10 rounded-lg flex items-center justify-center">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
            </div>
            Correo electrónico
        </label>
        <input type="email" id="email" name="email"
               class="w-full border-slate-200 rounded-2xl px-6 py-3.5 bg-white text-slate-900 text-sm focus:ring-4 focus:ring-teal-500/10 focus:border-[#335C5C] transition-all duration-300 shadow-sm"
               placeholder="tu@correo.com" required>
    </div>

    <div class="space-y-2">
        <label for="password" class="flex items-center gap-2.5 text-xs font-black text-[#335C5C] uppercase tracking-widest ml-1">
            <div class="w-6 h-6 bg-[#335C5C]/10 rounded-lg flex items-center justify-center">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
            </div>
            Contraseña
        </label>
        <div class="relative">
            <input type="password" id="password" name="password"
                   class="w-full border-slate-200 rounded-2xl px-6 py-3.5 bg-white text-slate-900 text-sm focus:ring-4 focus:ring-teal-500/10 focus:border-[#335C5C] transition-all duration-300 shadow-sm"
                   placeholder="Mínimo 8 caracteres" required>
            <button type="button" class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-300 hover:text-[#335C5C] transition-colors p-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
            </button>
        </div>
        <p class="text-[10px] text-slate-400 mt-2 flex items-center gap-1.5 ml-1 font-medium">
            <svg class="w-3 h-3 text-teal-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" /></svg>
            Usa una combinación de letras y números.
        </p>
    </div>

    <div class="flex items-start gap-3 pt-2">
        <input type="checkbox" id="terms" name="terms" class="mt-1 h-4 w-4 text-[#335C5C] focus:ring-[#335C5C]/20 border-slate-300 rounded cursor-pointer" required>
        <label for="terms" class="text-[11px] text-slate-500 leading-relaxed cursor-pointer select-none">
            Acepto los <a href="#" class="font-bold text-slate-700 underline decoration-teal-500/30 hover:decoration-teal-500 transition-all">Términos de servicio</a> y la <a href="#" class="font-bold text-slate-700 underline decoration-teal-500/30 hover:decoration-teal-500 transition-all">Política de privacidad</a>.
        </label>
    </div>

    <div class="pt-6">
        <button type="submit" class="w-full group relative bg-[#335C5C] hover:bg-[#264545] text-white font-black py-4.5 px-6 rounded-2xl shadow-xl shadow-[#335C5C]/20 flex items-center justify-center gap-3 transition-all duration-300 active:scale-95 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:animate-shimmer"></div>
            <span class="relative z-10 uppercase tracking-widest text-sm">Crear mi cuenta</span>
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
