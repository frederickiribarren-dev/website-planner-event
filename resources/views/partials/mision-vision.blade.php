{{-- resources/views/partials/mision-vision.blade.php --}}
<section id="mision" class="py-24 bg-white relative overflow-hidden scroll-mt-16">
    <!-- Elementos Decorativos de Fondo -->
    <div class="absolute top-0 left-0 w-96 h-96 bg-teal-50/40 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
    <div class="absolute bottom-0 right-0 w-[30rem] h-[30rem] bg-amber-50/40 rounded-full blur-3xl translate-x-1/3 translate-y-1/3 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
        
        <!-- Encabezado Principal -->
        <div class="text-center max-w-3xl mx-auto mb-32 reveal-on-scroll">
            <span class="text-xs md:text-sm font-bold tracking-[0.2em] text-teal-600 uppercase mb-4 block text-red-400/80">
                NUESTRA ESENCIA
            </span>
            <h2 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-slate-900 mb-8 tracking-tight">
                Nuestro Propósito
            </h2> 
            <div class="w-24 h-1 bg-gradient-to-r from-teal-200 to-amber-200 mx-auto rounded-full mb-10"></div>
            <p class="text-xl md:text-2xl text-slate-600 leading-relaxed font-light italic mb-12">
                "Acompañamos a cada familia en la dulce espera, creando un espacio digital donde el amor y la organización se unen para celebrar la vida."
            </p>
        </div>

        <div class="space-y-40 lg:space-y-48">
            <!-- SECCIÓN: MISIÓN -->
            <div class="reveal-on-scroll">
                <div class="flex flex-col lg:flex-row items-center lg:gap-32">
                    <div class="w-full lg:w-1/2 order-1 lg:order-1">
                        <!-- Título Centrado en su Columna con Espacio -->
                        <div class="text-center mb-12 lg:mb-10">
                            <h3 class="text-3xl lg:text-4xl font-bold text-slate-900 inline-flex items-center gap-4">
                                <span class="h-px w-8 bg-teal-200"></span>
                                Nuestra Misión
                                <span class="h-px w-8 bg-teal-200"></span>
                            </h3>
                        </div>

                        <div class="text-left px-4 lg:px-0 mb-16 lg:mb-12">
                            <p class="text-lg lg:text-xl text-slate-600 leading-loose">
                                Facilitar la creación de momentos inolvidables. Nuestra misión es quitar el peso de la logística para que los padres puedan enfocarse en lo que realmente importa: <span class="text-teal-600 font-medium italic">la alegría de recibir a un nuevo integrante en la familia.</span>
                            </p>
                        </div>
                    </div>
                    <div class="w-full lg:w-1/2 order-2 lg:order-2 mb-20 lg:mb-0">
                        <div class="relative group">
                            <div class="absolute -top-6 -right-6 w-32 h-32 bg-[radial-gradient(#2dd4bf_2px,transparent_2px)] [background-size:16px_16px] opacity-20 transition-transform duration-500 group-hover:scale-110"></div>
                            <div class="absolute -inset-4 bg-teal-50/80 rounded-[3rem] rotate-2 blur-sm"></div>
                            <div class="relative aspect-[16/10] bg-slate-100 rounded-[2.5rem] overflow-hidden shadow-2xl border-[12px] border-white transition-transform duration-700 group-hover:scale-[1.02]">
                                <img src="{{ asset('img/mision-img.jpg') }}" class="w-full h-full object-cover" alt="Nuestra Misión">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/10 to-transparent"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECCIÓN: VISIÓN -->
            <div class="reveal-on-scroll">
                <div class="flex flex-col-reverse lg:flex-row items-center lg:gap-32">
                    <div class="w-full lg:w-1/2 order-2 lg:order-1">
                        <div class="relative group">
                            <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-[radial-gradient(#fbbf24_2px,transparent_2px)] [background-size:16px_16px] opacity-20 transition-transform duration-500 group-hover:scale-110"></div>
                            <div class="absolute -inset-4 bg-amber-50/80 rounded-[3rem] -rotate-2 blur-sm"></div>
                            <div class="relative aspect-[16/10] bg-slate-100 rounded-[2.5rem] overflow-hidden shadow-2xl border-[12px] border-white transition-transform duration-700 group-hover:scale-[1.02]">
                                <img src="{{ asset('img/vision-img.jpg') }}" class="w-full h-full object-cover" alt="Nuestra Visión">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/10 to-transparent"></div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full lg:w-1/2 order-1 lg:order-2">
                        <!-- Título Centrado en su Columna con Espacio -->
                        <div class="text-center mb-12 lg:mb-10">
                            <h3 class="text-3xl lg:text-4xl font-bold text-slate-900 inline-flex items-center gap-4">
                                <span class="h-px w-8 bg-amber-200"></span>
                                Nuestra Visión
                                <span class="h-px w-8 bg-amber-200"></span>
                            </h3>
                        </div>

                        <div class="text-left px-4 lg:px-0 mb-16 lg:mb-0">
                            <p class="text-lg lg:text-xl text-slate-600 leading-loose">
                                Convertirnos en el compañero de confianza de cada familia a nivel global, conéctando a seres queridos a través de celebraciones organizadas con <span class="text-amber-600 font-medium italic">amor, tranquilidad</span> y una estética moderna que trascienda generaciones, haciendo que cada dulce espera sea inolvidable.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .reveal-on-scroll {
            opacity: 0;
            transform: translateY(40px);
            transition: all 1s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .reveal-on-scroll.active {
            opacity: 1;
            transform: translateY(0);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const observerOptions = { threshold: 0.15 };
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.reveal-on-scroll').forEach(el => observer.observe(el));
        });
    </script>
</section>

 </script>
</section>