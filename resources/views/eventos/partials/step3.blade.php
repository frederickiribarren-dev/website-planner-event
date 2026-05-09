            <div id="step3" class="step-content hidden max-w-7xl mx-auto px-4">
                <div class="text-center mb-10">
                    <h3 class="text-3xl font-bold text-gray-800 mb-2 italic">Selecciona una Imagen</h3>
                    <p class="text-gray-500 max-w-2xl mx-auto font-medium">Elige la estética de tu invitación. Mira cómo queda en el móvil a la derecha.</p>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
                    <div class="lg:col-span-8">
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <div class="relative group h-48">
                                <label class="cursor-pointer h-full flex flex-col items-center justify-center gap-3 bg-cyan-50 border-2 border-dashed border-cyan-200 rounded-[2rem] hover:bg-cyan-100 transition-all">
                                    <div class="w-10 h-10 bg-cyan-600 text-white rounded-full flex items-center justify-center shadow-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg></div>
                                    <span class="text-xs font-bold text-cyan-700">Subir propia</span>
                                    <input type="file" id="custom_image" class="hidden" accept="image/*" onchange="previewSelectedImage(this, 'custom')">
                                </label>
                            </div>
                            @php
                                $templates = [
                                    'https://img.freepik.com/vector-premium/lindo-baby-shower-invitacion-bebe-nino-elefante_23-2148443916.jpg',
                                    'https://img.freepik.com/vector-gratis/plantilla-invitacion-baby-shower-dibujada-mano_23-2148943360.jpg',
                                    'https://img.freepik.com/vector-gratis/plantilla-invitacion-baby-shower-acuarela_23-2148943361.jpg',
                                    'https://img.freepik.com/vector-premium/invitacion-baby-shower-bebe-bebe-linda-cigüena_23-2148450123.jpg',
                                    'https://img.freepik.com/vector-gratis/tarjeta-baby-shower-dibujada-mano_23-2148943362.jpg',
                                    'https://img.freepik.com/vector-premium/invitacion-baby-shower-bebe-bebe-linda-oso_23-2148450124.jpg'
                                ];
                            @endphp
                            @foreach($templates as $index => $url)
                            <div onclick="selectTemplate('{{ $url }}', {{ $index }})" class="template-card relative h-48 rounded-[2rem] overflow-hidden cursor-pointer border-4 border-transparent hover:scale-[1.02] transition-all bg-gray-100">
                                <img src="{{ $url }}" class="w-full h-full object-cover" alt="Plantilla {{ $index + 1 }}">
                                <div class="absolute inset-0 flex items-center justify-center bg-cyan-900/0 hover:bg-cyan-900/10 transition-all"><div class="check-icon opacity-0 w-8 h-8 bg-cyan-600 text-white rounded-full flex items-center justify-center shadow-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></div></div>
                            </div>
                            @endforeach
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
