<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-black text-slate-800 tracking-tight">
                    {{ __('Configuración') }}
                </h2>
                <p class="text-slate-600 font-medium mt-1">Personaliza tu experiencia y los detalles de tu evento.</p>
            </div>
            <button class="px-6 py-2 bg-cyan-700 hover:bg-cyan-800 text-white font-semibold rounded-full transition-all transform active:scale-95">
                Guardar Cambios
            </button>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Columna Izquierda: Perfil y Preferencias -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Perfil de Usuario -->
                <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
                    <h3 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-2">
                        Perfil de Usuario
                    </h3>
                    <div class="flex flex-col md:flex-row gap-8 items-center md:items-start">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-slate-50 shadow-inner">
                                <img src="/C:/Users/frede/.gemini/antigravity/brain/c4708be9-5831-402f-969e-662284c5d4df/avatar_profile_picture_1778198441454.png" alt="Avatar" class="w-full h-full object-cover">
                            </div>
                            <button class="text-sm font-bold text-cyan-600 hover:text-cyan-700 transition-colors">
                                Cambiar Foto
                            </button>
                        </div>
                        
                        <div class="flex-1 w-full space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Nombre Completo</label>
                                <input type="text" value="ejemplo nombre" class="w-full px-4 py-3 rounded-2xl border-slate-100 bg-slate-50 focus:border-cyan-500 focus:ring-cyan-500 transition-all font-medium text-slate-700">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Correo Electrónico</label>
                                <input type="email" value="ejemplo@dominio.com" class="w-full px-4 py-3 rounded-2xl border-slate-100 bg-slate-50 focus:border-cyan-500 focus:ring-cyan-500 transition-all font-medium text-slate-700">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Preferencias -->
                <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
                    <h3 class="text-xl font-bold text-slate-800 mb-6">Preferencias</h3>
                    <div class="max-w-md">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Idioma de la Interfaz</label>
                        <div class="relative">
                            <select class="w-full px-4 py-3 rounded-2xl border-slate-100 bg-slate-50 focus:border-cyan-500 focus:ring-cyan-500 transition-all font-medium text-slate-700 appearance-none">
                                <option>Español (Latinoamérica)</option>
                                <option>English (US)</option>
                                <option>Português (Brasil)</option>
                            </select>
                            <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                        <p class="text-xs text-slate-400 mt-3 italic text-center">Esto cambiará el idioma de tu panel de administración.</p>
                    </div>
                </div>
            </div>

            <!-- Columna Derecha: Tema y Notificaciones -->
            <div class="space-y-8">
                
                <!-- Tema del Evento -->
                <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
                    <h3 class="text-xl font-bold text-slate-800 mb-6">Tema del Evento</h3>
                    <p class="text-sm text-slate-500 mb-6 italic">Elige la paleta de colores para tu página de invitación.</p>
                    
                    <div class="flex justify-between gap-4">
                        <div class="flex flex-col items-center gap-2 group cursor-pointer">
                            <div class="w-12 h-12 rounded-full bg-pink-200 border-2 border-transparent group-hover:border-pink-400 transition-all shadow-sm"></div>
                            <span class="text-xs font-bold text-slate-500 group-hover:text-slate-800 transition-colors uppercase tracking-widest">Rosa</span>
                        </div>
                        <div class="flex flex-col items-center gap-2 group cursor-pointer">
                            <div class="w-12 h-12 rounded-full bg-cyan-200 border-4 border-cyan-500 transition-all shadow-sm flex items-center justify-center">
                                <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="text-xs font-bold text-slate-800 uppercase tracking-widest">Celeste</span>
                        </div>
                        <div class="flex flex-col items-center gap-2 group cursor-pointer">
                            <div class="w-12 h-12 rounded-full bg-slate-200 border-2 border-transparent group-hover:border-slate-400 transition-all shadow-sm"></div>
                            <span class="text-xs font-bold text-slate-500 group-hover:text-slate-800 transition-colors uppercase tracking-widest">Neutral</span>
                        </div>
                    </div>
                </div>

                <!-- Notificaciones -->
                <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
                    <h3 class="text-xl font-bold text-slate-800 mb-6">Notificaciones</h3>
                    
                    <div class="space-y-6">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-sm font-bold text-slate-700">Confirmaciones de Asistencia</p>
                                <p class="text-xs text-slate-400 italic">Recibir email cuando alguien confirme.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" checked class="sr-only peer">
                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-cyan-600"></div>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-sm font-bold text-slate-700">Nuevos Mensajes en Libro de Visitas</p>
                                <p class="text-xs text-slate-400 italic">Avisarme de nuevos mensajes.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer">
                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-cyan-600"></div>
                            </label>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
