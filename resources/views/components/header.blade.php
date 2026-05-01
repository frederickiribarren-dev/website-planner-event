{{-- resources/views/components/header.blade.php --}}
<header class="bg-white/80 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-full mx-auto px-6 sm:px-10 flex items-center justify-between h-16">
        
        <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-cyan-600 rounded-lg flex items-center justify-center text-white font-bold">
                    P 
                </div>
                
                <span class="text-lg font-bold text-cyan-600 hidden sm:block">
                    Planificador de eventos
                </span>
        </div>

        <div class="flex items-center">
           <x-button href="/registro">Inicio de Sesión</x-button>

            <a href="#" class="sm:hidden flex items-center justify-center w-10 h-10 bg-cyan-100 rounded-full text-cyan-600 border-2 border-cyan-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>  
            </a>
        </div>
    </div>
</header>
