{{-- resources/views/partials/faq.blade.php --}}
<section id="faq" class="py-24 bg-white relative overflow-hidden scroll-mt-16">
    
    <!-- Decoración de fondo mínima -->
    <div class="absolute top-0 left-0 w-64 h-64 bg-red-50/30 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>

    <div class="max-w-4xl mx-auto px-6 lg:px-8 relative z-10">
        
        <!-- Encabezado Estilo Premium -->
        <div class="text-center max-w-3xl mx-auto mb-20 reveal-on-scroll">
            <span class="text-xs md:text-sm font-bold tracking-[0.3em] text-red-400/80 uppercase mb-4 block">
                DUDAS COMUNES
            </span>
            <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-8 tracking-tight">
                Preguntas <span class="text-teal-600">Frecuentes</span>
            </h2>
            <div class="w-20 h-1.5 bg-gradient-to-r from-red-200 to-amber-200 mx-auto rounded-full mb-10"></div>
            <p class="text-xl text-slate-500 leading-relaxed font-light italic">
                Resolvemos tus dudas para que tu única preocupación sea disfrutar del momento.
            </p>
        </div>

        <div class="space-y-6">
            
            <!-- Pregunta 1 -->
            <div class="reveal-on-scroll group" style="transition-delay: 100ms">
                <button class="faq-button w-full bg-slate-50/50 hover:bg-white hover:shadow-xl hover:shadow-teal-900/5 border border-slate-100 rounded-[2rem] p-6 md:p-8 flex items-center justify-between transition-all duration-500 group">
                    <span class="text-lg md:text-xl font-bold text-slate-800 group-hover:text-teal-600 transition-colors text-left">
                        ¿Cómo empiezo a organizar mi Baby Shower?
                    </span>
                    <div class="faq-icon w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center text-teal-500 transition-transform duration-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                </button>
                <div class="faq-content overflow-hidden transition-all duration-500 ease-in-out px-8" style="max-height: 0; opacity: 0;">
                    <div class="py-6 text-lg text-slate-600 leading-loose font-light border-t border-slate-100 mt-2">
                        Es muy sencillo. Solo tienes que registrarte, crear tu evento personalizado y empezar a gestionar tus invitados y mesa de regalos desde un solo lugar. ¡Todo en menos de 5 minutos!
                    </div>
                </div>
            </div>

            <!-- Pregunta 2 -->
            <div class="reveal-on-scroll group" style="transition-delay: 200ms">
                <button class="faq-button w-full bg-slate-50/50 hover:bg-white hover:shadow-xl hover:shadow-teal-900/5 border border-slate-100 rounded-[2rem] p-6 md:p-8 flex items-center justify-between transition-all duration-500 group">
                    <span class="text-lg md:text-xl font-bold text-slate-800 group-hover:text-teal-600 transition-colors text-left">
                        ¿El uso de la plataforma es gratuito?
                    </span>
                    <div class="faq-icon w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center text-teal-500 transition-transform duration-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                </button>
                <div class="faq-content overflow-hidden transition-all duration-500 ease-in-out px-8" style="max-height: 0; opacity: 0;">
                    <div class="py-6 text-lg text-slate-600 leading-loose font-light border-t border-slate-100 mt-2">
                        ¡Totalmente! PlannerEvents es totalmente gratis, no se te cobrara nada por el uso de la plataforma.
                    </div>
                </div>
            </div>

            <!-- Pregunta 3 -->
            <div class="reveal-on-scroll group" style="transition-delay: 300ms">
                <button class="faq-button w-full bg-slate-50/50 hover:bg-white hover:shadow-xl hover:shadow-teal-900/5 border border-slate-100 rounded-[2rem] p-6 md:p-8 flex items-center justify-between transition-all duration-500 group">
                    <span class="text-lg md:text-xl font-bold text-slate-800 group-hover:text-teal-600 transition-colors text-left">
                        ¿Puedo exportar mi lista de invitados?
                    </span>
                    <div class="faq-icon w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center text-teal-500 transition-transform duration-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                </button>
                <div class="faq-content overflow-hidden transition-all duration-500 ease-in-out px-8" style="max-height: 0; opacity: 0;">
                    <div class="py-6 text-lg text-slate-600 leading-loose font-light border-t border-slate-100 mt-2">
                        ¡Claro que sí! Puedes descargar tu lista de invitados en cualquier momento, donde contentra todos los datos de tus invitados, tanto los que asistieron como los que no
                    </div>
                </div>
            </div>

        </div>
    </div>

    <style>
        .reveal-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .reveal-on-scroll.active {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Estado Abierto del Acordeón */
        .faq-button.active .faq-icon {
            transform: rotate(180deg);
            background-color: #0d9488; /* Teal-600 */
            color: white;
        }
        .faq-button.active {
            background-color: white;
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1);
        }
    </style>

    <script>
        (function() {
            function initFaq() {
                const faqButtons = document.querySelectorAll('.faq-button');
                
                faqButtons.forEach(button => {
                    const newButton = button.cloneNode(true);
                    button.parentNode.replaceChild(newButton, button);
                    
                    newButton.addEventListener('click', function(e) {
                        e.preventDefault();
                        const content = this.nextElementSibling;
                        const isOpen = this.classList.contains('active');
                        
                        document.querySelectorAll('.faq-button').forEach(other => {
                            if (other !== this) {
                                other.classList.remove('active');
                                const otherContent = other.nextElementSibling;
                                otherContent.style.maxHeight = "0";
                                otherContent.style.opacity = "0";
                            }
                        });

                        if (isOpen) {
                            this.classList.remove('active');
                            content.style.maxHeight = "0";
                            content.style.opacity = "0";
                        } else {
                            this.classList.add('active');
                            content.style.maxHeight = content.scrollHeight + "px";
                            content.style.opacity = "1";
                        }
                    });
                });
            }

            function initReveal() {
                const observerOptions = { threshold: 0.1 };
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('active');
                            observer.unobserve(entry.target);
                        }
                    });
                }, observerOptions);

                document.querySelectorAll('.reveal-on-scroll').forEach(el => observer.observe(el));
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', () => {
                    initFaq();
                    initReveal();
                });
            } else {
                initFaq();
                initReveal();
            }
        })();
    </script>
</section>
