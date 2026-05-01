{{-- resources/views/partials/hero.blade.php --}}
<section class="relative bg-gradient-to-b from-white via-cyan-50/30 to-gray-100 overflow-hidden py-16 lg:py-24 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-8 items-center">

            <!-- Columna Izquierda: Texto y Botones -->
            <div class="max-w-xl">

                <p class="text-xs md:text-sm font-bold tracking-widest text-red-400/80 uppercase mb-4">
                    PLANIFICACIÓN SERENA
                </p>
                
                <h1 class="text-4xl md:text-5xl lg:text-5xl font-extrabold text-gray-900 leading-tight mb-6">
                    El comienzo de una hermosa historia. Organiza el Baby Shower de tus sueños sin estrés.
                </h1>
                
                <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                    PlannerEvents te ayuda a organizar el Baby Shower perfecto. Invitaciones elegantes, gestión de regalos y confirmaciones, todo en un solo lugar, con la tranquilidad que necesitas en esta etapa.
                </p>
                
                <div class="flex flex-wrap items-center gap-4">
                    <x-button href="/registro">Comenzar Ahora</x-button>
                </div>
            </div>

            <!-- Columna Derecha: Imágenes y estadísticas -->
            <div class="relative mt-10 lg:mt-0">
                <div class="grid grid-cols-2 gap-4 md:gap-6">
                    
                    <div class="col-span-1 row-span-2 bg-gray-100 rounded-3xl overflow-hidden shadow-sm min-h-[300px] md:min-h-[450px]">
                        <img src="{{ asset('img/image-hero-one.jpg') }}" alt="Decoración de Baby Shower" class="w-full h-full object-contain">
                    </div>
                    
                    <div class="col-span-1 row-span-1 bg-gray-100 rounded-3xl overflow-hidden shadow-sm min-h-[140px] md:min-h-[215px]">
                        <img src="{{ asset('img/image-hero-two.jpg') }}" alt="Detalles del evento" class="w-full h-full object-cover">
                    </div>
                    
                    <div class="col-span-1 row-span-1 bg-gray-50 rounded-3xl border border-gray-100 shadow-sm min-h-[140px] md:min-h-[215px] flex items-center justify-center">
                        @include('partials.eventosCreados')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
