            <div id="step3" class="step-content hidden max-w-7xl mx-auto px-4">
                <div class="text-center mb-10">
                    <h3 class="text-3xl font-bold text-gray-800 mb-2 italic">Selecciona una Imagen</h3>
                    <p class="text-gray-500 max-w-2xl mx-auto font-medium">Elige la estética de tu invitación. Mira cómo queda en el móvil a la derecha.</p>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
                    <div class="lg:col-span-8">
                        <div id="image-grid-container" class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <!-- Este contenedor se llenará con JavaScript -->
                        </div>
                        <div class="mt-6 flex justify-between items-center bg-gray-50/50 rounded-2xl p-4 border border-gray-100">
                            <button type="button" id="btn-prev-image" onclick="prevImagePage()" class="px-5 py-2.5 rounded-xl bg-white border border-gray-200 text-gray-500 hover:text-cyan-700 hover:border-cyan-200 transition-all text-sm font-bold shadow-sm disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg> Anterior
                            </button>
                            <span id="image-pagination-info" class="text-sm font-semibold text-gray-500">Página 1</span>
                            <button type="button" id="btn-next-image" onclick="nextImagePage()" class="px-5 py-2.5 rounded-xl bg-white border border-gray-200 text-gray-500 hover:text-cyan-700 hover:border-cyan-200 transition-all text-sm font-bold shadow-sm disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
                                Siguiente <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </button>
                        </div>
                        <div class="mt-8 flex justify-between gap-4">
                            <button type="button" onclick="goToStep(2)" class="px-10 py-4 bg-white border border-gray-200 text-gray-500 font-bold rounded-full hover:bg-gray-50 transition-all shadow-sm">Volver</button>
                            <button type="button" onclick="goToStep(4)" class="px-12 py-4 bg-cyan-800 hover:bg-cyan-900 text-white font-bold rounded-full shadow-lg transition-all transform hover:scale-[1.02] active:scale-95">Continuar</button>
                        </div>
                    </div>
                    <div class="lg:col-span-4 flex justify-center">
                        <div class="relative w-[280px] h-[560px] bg-slate-900 rounded-[3rem] border-[6px] border-slate-800 shadow-2xl overflow-hidden shadow-cyan-900/20">
                            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-24 h-5 bg-slate-800 rounded-b-xl z-20"></div>
                            <div class="h-full bg-gray-50 pt-8 px-3">
                                <div class="bg-white rounded-[2rem] shadow-sm overflow-hidden border border-gray-100 max-w-sm mx-auto">
                                    <div class="aspect-[16/10] bg-gray-100 relative overflow-hidden">
                                        <img id="step3_preview_img" src="https://img.freepik.com/vector-premium/lindo-baby-shower-invitacion-bebe-nino-elefante_23-2148443916.jpg" class="w-full h-full object-cover" alt="Invitación">
                                    </div>
                                    <div class="p-6 text-center space-y-4 pb-8">
                                        <div class="h-4 w-24 bg-gray-100 rounded-full mx-auto"></div>
                                        <div class="h-6 w-3/4 bg-gray-100 rounded-full mx-auto"></div>
                                        <div class="h-4 w-full bg-gray-50 rounded-full mx-auto mt-4"></div>
                                        <div class="h-4 w-5/6 bg-gray-50 rounded-full mx-auto"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
