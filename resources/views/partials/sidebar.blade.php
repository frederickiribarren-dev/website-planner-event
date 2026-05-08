<aside class="w-64 bg-white border-r border-gray-100 flex flex-col p-6 h-screen sticky top-0">
    <!-- Perfil -->
    <div class="flex flex-col items-center text-center mb-8">
        <div class="w-20 h-20 bg-cyan-50 rounded-full border-2 border-cyan-100 flex items-center justify-center mb-3 overflow-hidden">
            <svg class="w-12 h-12 text-cyan-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
            </svg>
        </div>
        <h2 class="text-lg font-bold text-cyan-900 leading-tight">Mi Baby Shower</h2>
        <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Planificando con amor</p>
    </div>

    <!-- Botón Principal -->
    <x-button 
        :href="route('eventos.create')" 
        variant="primary"
        class="w-full py-3.5 mb-8 shadow-md hover:shadow-lg gap-2"
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Crear Evento
    </x-button>

    <!-- Navegación -->
    <nav class="flex-1 space-y-1">
        <a href="{{ route('dashboard') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('dashboard') ? 'bg-cyan-50 text-cyan-700 font-bold' : 'text-gray-500 hover:bg-cyan-50' }}">
            <span class="{{ request()->routeIs('dashboard') ? 'text-cyan-600' : 'text-gray-400' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m3-2h5a2 2 0 012 2v10a2 2 0 01-2 2h-2M9 7a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            </span>
            Resumen
        </a>
        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-colors text-gray-500 hover:bg-cyan-50">
            <span class="text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </span>
            Invitaciones
        </a>
        <a href="{{ route('invitados.creacion') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('invitados.*') ? 'bg-cyan-50 text-cyan-700 font-bold' : 'text-gray-500 hover:bg-cyan-50' }}">
            <span class="{{ request()->routeIs('invitados.*') ? 'text-cyan-600' : 'text-gray-400' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </span>
            Invitados
        </a>
        <a href="{{ route('regalos.index') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('regalos.*') ? 'bg-cyan-50 text-cyan-700 font-bold' : 'text-gray-500 hover:bg-cyan-50' }}">
            <span class="{{ request()->routeIs('regalos.*') ? 'text-cyan-600' : 'text-gray-400' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12V8H4v4m16 0v8H4v-8m16 0H4m12-4V4H8v4m8 0H8"></path>
                </svg>
            </span>
            Regalos
        </a>
        <!-- Configuración -->
        <a href="{{ route('configuracion') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('configuracion') ? 'bg-cyan-50 text-cyan-700 font-bold' : 'text-gray-500 hover:bg-cyan-50' }}">
            <span class="{{ request()->routeIs('configuracion') ? 'text-teal-600' : 'text-gray-400' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </span>
            Configuración
        </a>
    </nav>

    <!-- Footer -->
    <div class="border-t border-gray-100 pt-6 space-y-4">
        <a href="#" class="flex items-center gap-3 text-gray-500 hover:text-cyan-700 text-sm font-medium transition-colors">
            <span class="text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </span>
            Ayuda
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center gap-3 text-red-600 hover:text-red-700 text-sm font-bold transition-colors w-full group cursor-pointer">
                <span class="text-red-500 group-hover:text-red-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </span>
                Salir
            </button>
        </form>
    </div>
</aside>