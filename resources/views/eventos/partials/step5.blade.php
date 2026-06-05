            <div id="step5" class="step-content hidden max-w-6xl mx-auto px-4 mt-6">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
                    
                    <!-- Columna Izquierda: Vista previa del correo -->
                    <div class="lg:col-span-5 space-y-4">
                        <div class="flex items-center gap-3 px-2">
                            <svg class="w-6 h-6 text-[#7FB0B0]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <h3 class="text-2xl font-bold text-gray-800">Vista previa del correo</h3>
                        </div>
                        
                        <div class="bg-gray-100/80 rounded-[2rem] border border-gray-200 shadow-sm overflow-hidden flex flex-col relative">
                            <!-- Cabecera del correo -->
                            <div class="p-6 border-b border-gray-200/60 bg-gray-50/80 space-y-3">
                                <div class="flex items-center gap-3">
                                    <span class="text-xs font-bold text-gray-500 w-12">Para:</span>
                                    <span class="px-3 py-1 bg-gray-200/80 text-gray-700 rounded-full text-[11px] font-bold" id="preview-to-count">Lista de Invitados (0)</span>
                                </div>
                                <div class="flex items-start gap-3">
                                    <span class="text-xs font-bold text-gray-500 w-12 mt-1">Asunto:</span>
                                    <span class="text-sm font-bold text-gray-800 leading-tight" id="preview-subject-final">¡Estás invitado al Baby Shower!</span>
                                </div>
                            </div>
                            
                            <!-- Contenedor interno -->
                            <div class="p-4 sm:p-8 flex-1 bg-[#F5F5F0]">
                                <div class="bg-white rounded-[2rem] shadow-sm overflow-hidden max-w-sm mx-auto">
                                    <div class="aspect-[16/10] bg-gray-100 relative overflow-hidden">
                                        <img id="final_preview_img" src="https://img.freepik.com/vector-premium/lindo-baby-shower-invitacion-bebe-nino-elefante_23-2148443916.jpg" class="w-full h-full object-cover" alt="Invitación">
                                    </div>
                                    <div class="p-6 text-center space-y-6">
                                        <span class="inline-block px-4 py-1.5 bg-[#EEF5F5] text-[#427A79] rounded-full text-[10px] font-bold uppercase tracking-widest">Estás Invitado</span>
                                        <h4 class="text-2xl font-bold text-gray-800" id="final_preview_title">Baby Shower de <br><span class="italic text-[#427A79] font-medium">Leo</span></h4>
                                        <p class="text-xs text-gray-500 leading-relaxed font-medium" id="final_preview_message">Estamos muy emocionados de compartir este momento tan especial contigo. Acompáñanos a celebrar la llegada de nuestro pequeño.</p>
                                        
                                        <div class="bg-[#F8F9FA] rounded-2xl p-4 text-left space-y-4 border border-gray-100">
                                            <div class="flex items-start gap-3">
                                                <div class="mt-0.5 w-6 h-6 rounded-full bg-[#EEF5F5] flex items-center justify-center text-[#427A79] shadow-sm flex-shrink-0">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                </div>
                                                <div>
                                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Cuándo</p>
                                                    <p class="text-[11px] font-bold text-gray-700" id="final_preview_date">Sábado, 15 de Noviembre</p>
                                                </div>
                                            </div>
                                            <div class="h-px bg-gray-200/60 w-full"></div>
                                            <div class="flex items-start gap-3">
                                                <div class="mt-0.5 w-6 h-6 rounded-full bg-[#EEF5F5] flex items-center justify-center text-[#427A79] shadow-sm flex-shrink-0">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                </div>
                                                <div>
                                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Dónde</p>
                                                    <p class="text-[11px] font-bold text-gray-700" id="final_preview_location">Jardín Botánico Los Pinos</p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <button type="button" class="w-full py-3 bg-[#427A79] hover:bg-[#346261] transition-colors text-white rounded-xl text-xs font-bold shadow-sm">Confirmar Asistencia</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Columna Derecha: Tarjetas de Resumen y Botones -->
                    <div class="lg:col-span-7 space-y-6">
                        
                        <!-- Tarjeta: Resumen del Envío -->
                        <div class="bg-white rounded-[2rem] p-8 sm:p-10 border border-gray-100 shadow-sm space-y-8">
                            <h3 class="text-2xl font-bold text-gray-800">Resumen del Envío</h3>
                            
                            <div class="space-y-6">
                                <div class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-full bg-[#EEF5F5] flex items-center justify-center text-[#427A79]">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Destinatarios totales</p>
                                        <p class="text-lg font-bold text-gray-800" id="summary-guest-count">0 Invitados</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-full bg-[#EEF5F5] flex items-center justify-center text-[#427A79]">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Momento de envío</p>
                                        <p class="text-lg font-bold text-gray-800">Inmediato</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-[#EEF5F5]/60 rounded-2xl p-5 flex gap-4 items-start border border-[#EEF5F5]">
                                <div class="w-6 h-6 rounded-full bg-[#427A79] text-white flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <p class="text-sm text-[#346261] font-medium leading-relaxed">Una vez que confirmes, las invitaciones se enviarán automáticamente a los correos registrados. Recibirás una copia de confirmación en tu bandeja de entrada.</p>
                            </div>
                        </div>

                        <!-- Tarjeta: Conectar Lista de Regalos -->
                        <div class="bg-white rounded-[2rem] p-8 sm:p-10 border border-gray-100 shadow-sm space-y-6">
                            <div class="flex items-center gap-4 mb-2">
                                <div class="w-12 h-12 rounded-full bg-[#F5EDEB] flex items-center justify-center text-[#9E6A5E]">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-xl font-bold text-gray-800">Lista de Regalos</h4>
                                    <p class="text-sm text-gray-500 font-medium">Asigna una lista a tu evento</p>
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                <select name="lista_regalos" class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-[#427A79] transition text-sm font-bold text-gray-700">
                                    <option value="">Seleccionar lista de regalos guardada...</option>
                                    <option value="1">Mi Lista de Baby Shower</option>
                                    <option value="2">Regalos Ropa de Bebé</option>
                                </select>
                                
                                <p class="text-[11px] text-gray-400 font-semibold italic text-center px-4 leading-relaxed">* Nota: Esta lista <span class="text-red-400">no se enviará directamente</span> en el correo de invitación. Solo se vinculará internamente con el evento para llevar el control.</p>
                            </div>
                        </div>

                        <!-- Botones de Acción (Lado a lado) -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-4">
                            <button type="button" onclick="goToStep(4)" class="w-full sm:w-1/2 bg-white border border-gray-200 text-gray-500 font-bold rounded-full hover:bg-gray-50 transition-all shadow-sm transition-all flex justify-center items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                Volver a Editar
                            </button>
                            <button type="submit" class="w-full sm:w-1/2 bg-cyan-800 hover:bg-cyan-900 text-white font-bold py-4 px-8 rounded-full shadow-lg transition-all transform hover:scale-[1.02] active:scale-95 flex justify-center items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                Confirmar y Enviar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
