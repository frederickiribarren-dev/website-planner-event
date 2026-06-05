<aside class="w-72 h-screen sticky top-0 bg-slate-50 border-r border-slate-200 flex flex-col transition-all duration-300">
    <!-- Header/Logo Area -->
    <div class="px-8 py-4">
        <div class="flex items-center gap-3 group">
            <x-application-logo />
        </div>
    </div>

    <!-- Acción Principal: Crear Evento -->
    <div class="px-6 py-4">
        <a href="{{ route('eventos.create') }}" class="w-full flex items-center justify-center gap-2 py-3 bg-white border border-slate-200 rounded-2xl shadow-sm hover:border-teal-400 hover:text-teal-600 transition-all group">
            <svg class="w-4 h-4 text-slate-400 group-hover:text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span class="text-[10px] font-black uppercase tracking-widest text-slate-600 group-hover:text-teal-600">Crear Evento</span>
        </a>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 space-y-2 overflow-y-auto">
        <div>
            <p class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 mt-2">Menú Principal</p>
            
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 hover:bg-white hover:shadow-sm group">
                <svg class="w-5 h-5 text-slate-400 group-hover:text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span class="font-bold text-slate-600 group-hover:text-slate-900 uppercase text-[11px] tracking-wider">Dashboard</span>
            </x-nav-link>

            <x-nav-link :href="route('invitados.creacion')" :active="request()->routeIs('invitados.*')" 
                class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 hover:bg-white hover:shadow-sm group">
                <svg class="w-5 h-5 text-slate-400 group-hover:text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <span class="font-bold text-slate-600 group-hover:text-slate-900 uppercase text-[11px] tracking-wider">Invitados</span>
            </x-nav-link>

            <x-nav-link :href="route('eventos.index')" :active="request()->routeIs('eventos.index')" 
                class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 hover:bg-white hover:shadow-sm group">
                <svg class="w-5 h-5 text-slate-400 group-hover:text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                <span class="font-bold text-slate-600 group-hover:text-slate-900 uppercase text-[11px] tracking-wider">Invitaciones</span>
            </x-nav-link>

            <x-nav-link :href="route('regalos.index')" :active="request()->routeIs('regalos.*')" 
                class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 hover:bg-white hover:shadow-sm group">
                <svg class="w-5 h-5 text-slate-400 group-hover:text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12V8H4v4m16 0v8H4v-8m16 0H4m12-4V4H8v4m8 0H8"></path></svg>
                <span class="font-bold text-slate-600 group-hover:text-slate-900 uppercase text-[11px] tracking-wider">Regalos</span>
            </x-nav-link>

            <x-nav-link :href="route('configuracion')" :active="request()->routeIs('configuracion')" 
                class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 hover:bg-white hover:shadow-sm group">
                <svg class="w-5 h-5 text-slate-400 group-hover:text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <span class="font-bold text-slate-600 group-hover:text-slate-900 uppercase text-[11px] tracking-wider">Configuración</span>
            </x-nav-link>
        </div>
    </nav>

    <!-- Perfil de Usuario (Estilo Suave) -->
    <div class="p-6">
        <div class="bg-white border border-slate-200 p-4 rounded-[2rem] shadow-sm">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center font-bold text-slate-600 border border-slate-200 italic">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="overflow-hidden text-ellipsis">
                    <p class="text-xs font-black text-slate-800 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[9px] font-bold text-slate-400 uppercase">Administrador</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full py-3 bg-slate-50 hover:bg-red-600 hover:text-white text-slate-600 text-[10px] font-black uppercase tracking-widest rounded-2xl transition-all border border-slate-200">
                    Cerrar Sesión
                </button>
            </form>
        </div>
    </div>
</aside>