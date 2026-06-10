            <div id="step4" class="step-content hidden max-w-6xl mx-auto px-4">
                <div class="text-center mb-12">
                    <h3 class="text-3xl font-bold text-gray-800 mb-2 italic">Diseño del Mensaje</h3>
                    <p class="text-gray-500 max-w-2xl mx-auto font-medium">Dale un toque personal a tu invitación. Escribe un mensaje cálido para tus invitados que acompañe tu diseño.</p>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
                    <div class="bg-white rounded-[2.5rem] p-8 sm:p-10 border border-gray-100 shadow-sm space-y-8">
                        <h4 class="font-bold text-xl text-gray-800 mb-6">Detalles del correo</h4>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">Asunto del correo</label>
                            <input type="text" id="email_subject" name="email_subject" oninput="updatePreview()" class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-cyan-600 transition text-gray-900" placeholder="¡Estás invitado al Baby Shower!">
                        </div>
                        <div>
                            <style>
                                #email_message_editor:empty::before {
                                    content: attr(placeholder);
                                    color: #a1a1aa; /* text-zinc-400 */
                                    pointer-events: none;
                                }
                                #email_message_editor, #preview_message {
                                    word-break: break-word !important;
                                    overflow-wrap: break-word !important;
                                }
                            </style>
                            <label class="block text-sm font-bold text-gray-700 mb-3">Mensaje</label>
                            <div class="bg-gray-50 rounded-2xl overflow-hidden border border-gray-100">
                                <div class="flex items-center gap-2 px-6 py-3 border-b border-gray-200 bg-gray-100/50">
                                    <button type="button" onclick="formatText('bold')" class="text-gray-400 font-bold hover:text-gray-600 w-8 h-8 rounded-lg hover:bg-gray-200/60 transition-colors flex items-center justify-center text-sm">B</button>
                                    <button type="button" onclick="formatText('italic')" class="text-gray-400 hover:text-gray-600 italic w-8 h-8 rounded-lg hover:bg-gray-200/60 transition-colors flex items-center justify-center text-sm">I</button>
                                    <button type="button" onclick="formatText('underline')" class="text-gray-400 hover:text-gray-600 underline w-8 h-8 rounded-lg hover:bg-gray-200/60 transition-colors flex items-center justify-center text-sm">U</button>
                                </div>
                                <div id="email_message_editor" contenteditable="true" oninput="syncEditorContent()" class="w-full bg-transparent border-none px-6 py-4 focus:outline-none transition text-gray-900 min-h-[180px] overflow-y-auto" placeholder="Escribe aquí tu mensaje cálido..."></div>
                                <input type="hidden" id="email_message" name="mensaje_invitacion" value="{{ old('mensaje_invitacion', $evento->mensaje_invitacion ?? '') }}">
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="relative w-[320px] h-[640px] bg-slate-900 rounded-[3rem] border-[8px] border-slate-800 shadow-2xl overflow-hidden shadow-cyan-900/20">
                            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-6 bg-slate-800 rounded-b-2xl z-20"></div>
                            <div class="h-full bg-gray-50 overflow-y-auto pt-10 px-4">
                                <div class="bg-white rounded-[2rem] shadow-sm overflow-hidden border border-gray-100 max-w-sm mx-auto">
                                    <div class="aspect-[16/10] bg-gray-100 relative overflow-hidden">
                                        <img id="mobile_preview_img" src="https://img.freepik.com/vector-premium/lindo-baby-shower-invitacion-bebe-nino-elefante_23-2148443916.jpg" class="w-full h-full object-cover" alt="Invitación">
                                    </div>
                                    <div class="p-6 text-center space-y-6">
                                        <span class="inline-block px-4 py-1.5 bg-[#EEF5F5] text-[#427A79] rounded-full text-[10px] font-bold uppercase tracking-widest">Estás Invitado</span>
                                        <h4 class="text-2xl font-bold text-gray-800" id="preview_title">Baby Shower de <br><span class="italic text-[#427A79] font-medium">Leo</span></h4>
                                        <p class="text-xs text-gray-500 leading-relaxed font-medium break-words" id="preview_message">Estamos muy emocionados de compartir este momento tan especial contigo. Acompáñanos a celebrar la llegada de nuestro pequeño.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-8 flex justify-between gap-4">
                    <button type="button" onclick="goToStep(3)" class="px-10 py-4 bg-white border border-gray-200 text-gray-500 font-bold rounded-full hover:bg-gray-50 transition-all shadow-sm">Volver</button>
                    <button type="button" onclick="goToStep(5)" class="px-12 py-4 bg-cyan-800 hover:bg-cyan-900 text-white font-bold rounded-full shadow-lg transition-all transform hover:scale-[1.02] active:scale-95">Continuar</button>
                </div>
            </div>
