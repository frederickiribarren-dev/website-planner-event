<aside class="w-64 bg-white border-r border-gray-100 flex flex-col p-6">
    
    <div class="flex flex-col items-center text-center mb-10">
        <img src="/api/placeholder/100/100" alt="Avatar Usuario" class="w-20 h-20 rounded-full border border-gray-200 p-1 mb-3">
        <h2 class="font-bold text-gray-900 text-lg">Mi Baby Shower</h2>
        <p class="text-xs text-gray-500">Planificando con amor</p>
    </div>

    <button class="flex items-center justify-center w-full bg-cyan-700 hover:bg-cyan-800 text-white font-medium py-3 px-4 rounded-full mb-8 text-sm gap-2">
        <span><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg></span>
        Nueva Invitación
    </button>

    <nav class="flex-1 space-y-2">
        <a href="{{ route('eventos.index') }}" 
        class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm {{ request()->routeIs('eventos.*') ? 'bg-cyan-50 text-cyan-700 font-bold' : 'text-gray-500' }}">
        Eventos
        </a>
        
        <a href="#" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 hover:bg-cyan-50">
            <span class="text-gray-400"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg></span>
            Invitaciones
        </a>
        <a href="#" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 hover:bg-cyan-50">
            <span class="text-gray-400"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg></span>
            Invitados
        </a>
        <a href="#" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 hover:bg-cyan-50">
            <span class="text-gray-400"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V6a2 2 0 10-2 2h2zm0 0H9m3 0h3M12 15h3m-3 0H9m3 0v3m0-3v-3m0 3h3m-3 0H9m3 0V9m0 6v3"></path></svg></span>
            Regalos
        </a>
        <a href="#" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-cyan-800 bg-cyan-100 font-medium">
            <span class="text-cyan-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg></span>
            Configuración
        </a>
    </nav>

    <div class="border-t border-gray-100 pt-6 space-y-3 mt-10">
        <a href="#" class="flex items-center gap-3 text-gray-600 hover:text-cyan-700 text-sm">
            <span class="text-gray-400"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></span>
            Ayuda
        </a>
        <a href="#" class="flex items-center gap-3 text-red-500 hover:text-red-600 text-sm">
            <span class="text-red-400"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg></span>
            Salir
        </a>
    </div>
</aside>