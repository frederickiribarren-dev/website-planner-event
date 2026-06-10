<!-- resources/views/auth/partials/register-form.blade.php -->

<!-- Registro Social -->
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
        <span>Registrarse con Google</span>
    </button>
</div>

<div class="relative flex items-center mb-10">
    <div class="flex-grow border-t border-slate-100"></div>
    <span class="flex-shrink-0 mx-6 text-slate-300 text-[10px] font-black uppercase tracking-[0.25em]">O completa tus datos</span>
    <div class="flex-grow border-t border-slate-100"></div>
</div>

<form method="POST" action="{{ route('register') }}" class="space-y-6">
    @csrf

    <!-- nombre -->
    <div class="space-y-2">
        <x-input-label for="name" :value="__('Nombre Completo')" class="flex items-center gap-2.5 text-xs font-black text-[#335C5C] uppercase tracking-widest ml-1" />
        <x-text-input id="name" class="w-full border-slate-200 rounded-[1.25rem] px-6 py-4 bg-white text-slate-900 focus:ring-4 focus:ring-teal-500/10 focus:border-[#335C5C] transition-all duration-300 placeholder:text-slate-300 text-sm shadow-sm hover:border-slate-300" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Tu nombre" />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <!-- Email -->
    <div class="space-y-2">
        <x-input-label for="email" :value="__('Correo Electrónico')" class="flex items-center gap-2.5 text-xs font-black text-[#335C5C] uppercase tracking-widest ml-1" />
        <x-text-input id="email" class="w-full border-slate-200 rounded-[1.25rem] px-6 py-4 bg-white text-slate-900 focus:ring-4 focus:ring-teal-500/10 focus:border-[#335C5C] transition-all duration-300 placeholder:text-slate-300 text-sm shadow-sm hover:border-slate-300" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="ejemplo@correo.com" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <!-- Password -->
    <div class="space-y-2">
        <x-input-label for="password" :value="__('Contraseña')" class="flex items-center gap-2.5 text-xs font-black text-[#335C5C] uppercase tracking-widest ml-1" />
        <x-text-input id="password" class="w-full border-slate-200 rounded-[1.25rem] px-6 py-4 bg-white text-slate-900 focus:ring-4 focus:ring-teal-500/10 focus:border-[#335C5C] transition-all duration-300 placeholder:text-slate-300 text-sm shadow-sm hover:border-slate-300"
                        type="password"
                        name="password"
                        required autocomplete="new-password" placeholder="••••••••" />
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <!-- confirmar Password -->
    <div class="space-y-2">
        <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" class="flex items-center gap-2.5 text-xs font-black text-[#335C5C] uppercase tracking-widest ml-1" />
        <x-text-input id="password_confirmation" class="w-full border-slate-200 rounded-[1.25rem] px-6 py-4 bg-white text-slate-900 focus:ring-4 focus:ring-teal-500/10 focus:border-[#335C5C] transition-all duration-300 placeholder:text-slate-300 text-sm shadow-sm hover:border-slate-300"
                        type="password"
                        name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div>

    <div class="pt-4">
        <button type="submit" class="w-full group relative bg-[#335C5C] hover:bg-[#264545] text-white font-black py-4 px-6 rounded-2xl shadow-xl shadow-[#335C5C]/20 flex items-center justify-center gap-3 transition-all duration-300 active:scale-95 overflow-hidden">
            <span class="relative z-10 uppercase tracking-widest text-sm">Registrarse</span>
            <svg class="w-5 h-5 relative z-10 transition-transform duration-300 group-hover:translate-x-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
        </button>
    </div>

    <p class="text-center text-sm text-slate-500 mt-10 pt-6 border-t border-slate-100">
        ¿Ya tienes una cuenta? 
        <a href="{{ route('login') }}" class="text-teal-600 font-bold hover:text-teal-700 transition-colors">
            Inicia sesión aquí
        </a>
    </p>
</form>
