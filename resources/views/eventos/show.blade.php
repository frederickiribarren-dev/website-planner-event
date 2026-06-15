<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-black text-slate-800 tracking-tight">
            {{ __('Vista Previa de la Invitación') }}
        </h2>
        <p class="text-slate-600 font-medium mt-1">Revisa los detalles de la invitación antes de compartirla.</p>
    </x-slot>

    <div class="py-12 max-w-6xl mx-auto px-4 mt-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
            
            <!-- Columna Izquierda: Vista previa del correo -->
            <div class="lg:col-span-5 space-y-4">
                <div class="bg-gray-100/80 rounded-[2rem] border border-gray-200 shadow-sm overflow-hidden flex flex-col relative">
                    <!-- Cabecera del correo -->
                    <div class="p-6 border-b border-gray-200/60 bg-gray-50/80 space-y-3">
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-bold text-gray-500 w-12">Para:</span>
                            <span class="px-3 py-1 bg-gray-200/80 text-gray-700 rounded-full text-[11px] font-bold">Lista de Invitados</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-xs font-bold text-gray-500 w-12 mt-1">Asunto:</span>
                            <span class="text-sm font-bold text-gray-800 leading-tight">¡Estás invitado a celebrar!</span>
                        </div>
                    </div>
                    
                    <!-- Contenedor interno -->
                    <div class="p-4 sm:p-8 flex-1 bg-[#F5F5F0]" @if($evento->color_tema) style="background-color: {{ $evento->color_tema }}20;" @endif>
                        <div class="bg-white rounded-[2rem] shadow-sm overflow-hidden max-w-sm mx-auto">
                            <div class="aspect-[16/10] bg-gray-100 relative overflow-hidden">
                                @if($evento->imagen_portada_url)
                                    <img src="{{ $evento->imagen_portada_url }}" class="w-full h-full object-cover" alt="Invitación">
                                @else
                                    <img src="https://img.freepik.com/vector-premium/lindo-baby-shower-invitacion-bebe-nino-elefante_23-2148443916.jpg" class="w-full h-full object-cover" alt="Invitación">
                                @endif
                            </div>
                            <div class="p-6 text-center space-y-6">
                                <span class="inline-block px-4 py-1.5 bg-[#EEF5F5] text-[#427A79] rounded-full text-[10px] font-bold uppercase tracking-widest">Estás Invitado</span>
                                <h4 class="text-2xl font-bold text-gray-800">{{ $evento->slug ?? 'Baby Shower' }} de <br><span class="italic text-[#427A79] font-medium">{{ $evento->nombre_bebe }}</span></h4>
                                <p class="text-xs text-gray-500 leading-relaxed font-medium break-words" style="word-break: break-word; overflow-wrap: break-word;">{{ $evento->mensaje_invitacion ?? 'Estamos muy emocionados de compartir este momento tan especial contigo. Acompáñanos a celebrar.' }}</p>
                                
                                <div class="bg-[#F8F9FA] rounded-2xl p-4 text-left space-y-4 border border-gray-100">
                                    <div class="flex items-start gap-3">
                                        <div class="mt-0.5 w-6 h-6 rounded-full bg-[#EEF5F5] flex items-center justify-center text-[#427A79] shadow-sm flex-shrink-0">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Cuándo</p>
                                            <p class="text-[11px] font-bold text-gray-700">{{ ucfirst(\Carbon\Carbon::parse($evento->fecha_evento)->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY')) }}</p>
                                        </div>
                                    </div>
                                    <div class="h-px bg-gray-200/60 w-full"></div>
                                    <div class="flex items-start gap-3">
                                        <div class="mt-0.5 w-6 h-6 rounded-full bg-[#EEF5F5] flex items-center justify-center text-[#427A79] shadow-sm flex-shrink-0">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Dónde</p>
                                            <p class="text-[11px] font-bold text-gray-700">{{ $evento->ubicacion_nombre ?? 'Lugar por definir' }}</p>
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
                
                <!-- Tarjeta: Resumen del Evento -->
                <div class="bg-white rounded-[2rem] p-8 sm:p-10 border border-gray-100 shadow-sm space-y-8">
                    <h3 class="text-2xl font-bold text-gray-800">Resumen del Evento</h3>
                    
                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-[#EEF5F5] flex items-center justify-center text-[#427A79]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Estado de la Invitación</p>
                                <p class="text-lg font-bold text-gray-800">{{ $evento->estado ?? 'Borrador' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-[#EEF5F5] flex items-center justify-center text-[#427A79]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total de Invitados</p>
                                <p class="text-lg font-bold text-gray-800">{{ $evento->invitados->count() }} Invitados</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-[#EEF5F5] flex items-center justify-center text-[#427A79]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Nombres de Listas de Invitados</p>
                                <p class="text-sm font-bold text-gray-800 mt-1">
                                    @if($evento->listasInvitados->count() > 0)
                                        {{ $evento->listasInvitados->pluck('nombre')->join(', ') }}
                                    @else
                                        Sin listas asignadas
                                    @endif
                                </p>
                            </div>
                        </div>
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
                            <p class="text-sm text-gray-500 font-medium">Detalles de la lista asignada a este evento</p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-gray-700">
                            @if($evento->listaRegalo)
                                {{ $evento->listaRegalo->nombre }} ({{ $evento->listaRegalo->regalos->count() }} regalo(s) asignado(s))
                            @elseif($evento->regalos->count() > 0)
                                {{ $evento->regalos->count() }} Regalo(s) asignado(s)
                            @else
                                (Ninguna lista asignada todavía)
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <a href="{{ route('eventos.index') }}" class="w-full bg-cyan-700 text-white hover:bg-cyan-800 font-bold py-4 px-8 rounded-full shadow-sm flex justify-center items-center gap-2 uppercase tracking-widest text-xs transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        Cerrar
                    </a>
                    @if($evento->estado === 'Borrador')
                    <a href="{{ route('eventos.edit', $evento->id) }}" class="w-full bg-emerald-600 text-white hover:bg-emerald-700 font-bold py-4 px-8 rounded-full shadow-sm flex justify-center items-center gap-2 uppercase tracking-widest text-xs transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Seguir Editando
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
