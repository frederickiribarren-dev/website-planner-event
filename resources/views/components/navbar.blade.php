{{-- resources/views/components/navbar.blade.php --}}
<nav class="bg-white/80 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative flex items-center justify-center h-16">

            <!--  Links de Navegación -->
            <div class="hidden sm:flex items-center space-x-4 md:space-x-10">
                <a href="{{ url('/') }}" class="text-gray-600 hover:text-cyan-500 px-1 py-2 text-sm font-semibold transition-colors border-b-2 border-transparent hover:border-cyan-500">Inicio</a>
                <a href="{{ url('/#mision') }}" class="text-gray-600 hover:text-cyan-500 px-1 py-2 text-sm font-semibold transition-colors border-b-2 border-transparent hover:border-cyan-500">Misión</a>
                <a href="{{ url('/#instrucciones') }}" class="text-gray-600 hover:text-cyan-500 px-1 py-2 text-sm font-semibold transition-colors border-b-2 border-transparent hover:border-cyan-500">Instrucciones</a>
                <a href="{{ route('contacto') }}" class="text-gray-600 hover:text-cyan-500 px-1 py-2 text-sm font-semibold transition-colors border-b-2 border-transparent hover:border-cyan-500">Contacto</a>
                <a href="{{ url('/#faq') }}" class="text-gray-600 hover:text-cyan-500 px-1 py-2 text-sm font-semibold transition-colors border-b-2 border-transparent hover:border-cyan-500">FAQ</a>
            </div>

            <!-- Botón Móvil -->
            <div class="absolute right-0 flex items-center sm:hidden">
                <button type="button" class="text-gray-500 hover:text-cyan-600 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>
