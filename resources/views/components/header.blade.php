{{-- resources/views/components/header.blade.php --}}
<header class="bg-white/80 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-full mx-auto px-6 sm:px-10 flex items-center justify-between h-16">
        
        <div class="flex items-center gap-3">
                <x-application-logo />
        </div>

        <div class="flex items-center gap-4">
           @auth
               <a href="{{ route('dashboard') }}" class="inline-flex items-center px-6 py-2.5 bg-cyan-600 border border-transparent rounded-full font-bold text-xs text-white uppercase tracking-widest hover:bg-cyan-700 active:bg-cyan-900 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md shadow-cyan-900/10">
                   Ir a Dashboard
               </a>
           @else
               <x-button variant="login" onclick="openModal('loginModal')">
                    Inicio de Sesión
               </x-button>
           @endauth
        </div>
           
            <a href="#" class="sm:hidden flex items-center justify-center w-10 h-10 bg-cyan-100 rounded-full text-cyan-600 border-2 border-cyan-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>  
            </a>
        </div>
    </div>
</header>
