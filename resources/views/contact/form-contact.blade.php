@extends('layouts.app')

@section('content')
<section class="min-h-[calc(100vh-100px)] bg-gray-50/50 py-16 lg:py-24">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-6">Contáctanos</h1>
            <p class="text-lg text-gray-600">
                ¿Tienes alguna duda o necesitas ayuda con tu evento? Escríbenos y nuestro equipo te responderá lo más pronto posible.
            </p>
        </div>

        <div class="max-w-5xl mx-auto bg-white rounded-3xl shadow-lg shadow-gray-200/50 border border-gray-100 overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-5">
                
                <div class="lg:col-span-2 bg-gradient-to-br from-cyan-600 to-cyan-800 p-10 text-white flex flex-col justify-between">
                    <div>
                        <h3 class="text-2xl font-bold mb-4">Información de Contacto</h3>
                        <p class="text-cyan-100 mb-10 leading-relaxed text-sm">
                            Estamos aquí para ayudarte a planificar el Baby Shower perfecto. No dudes en comunicarte con nosotros.
                        </p>
                        
                        <div class="space-y-8">
                            <div class="flex items-start gap-4">
                                <div class="bg-cyan-500/30 p-3 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-cyan-100">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-cyan-200 mb-1">Correo Electrónico</p>
                                    <p class="font-medium">soporte@plannerevents.com</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="bg-cyan-500/30 p-3 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-cyan-100">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.896-1.596-5.54-4.24-7.136-7.136l1.292-.97c.363-.271.527-.734.418-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-cyan-200 mb-1">Teléfono</p>
                                    <p class="font-medium">+(56) 9 1234 1234</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="bg-cyan-500/30 p-3 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-cyan-100">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-cyan-200 mb-1">Ubicación</p>
                                    <p class="font-medium">Los Capuchinos, Tralalerito, Santiago</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-16 flex space-x-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-cyan-500/40 hover:bg-cyan-400/50 transition-colors flex items-center justify-center">
                            <span class="font-bold text-sm">Fb</span>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-cyan-500/40 hover:bg-cyan-400/50 transition-colors flex items-center justify-center">
                            <span class="font-bold text-sm">Ig</span>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-cyan-500/40 hover:bg-cyan-400/50 transition-colors flex items-center justify-center">
                            <span class="font-bold text-sm">Tw</span>
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-3 p-10 md:p-14 bg-white">
                    <form action="#" method="POST" class="space-y-6">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nombre Completo</label>
                                <input type="text" id="name" name="name" class="w-full border-gray-200 rounded-xl shadow-sm focus:border-cyan-500 focus:ring-cyan-500 px-4 py-3 bg-gray-50/50" placeholder="Ej. María Pérez">
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Correo Electrónico</label>
                                <input type="email" id="email" name="email" class="w-full border-gray-200 rounded-xl shadow-sm focus:border-cyan-500 focus:ring-cyan-500 px-4 py-3 bg-gray-50/50" placeholder="maria@ejemplo.com">
                            </div>
                        </div>
                        
                        <div>
                            <label for="subject" class="block text-sm font-semibold text-gray-700 mb-2">Asunto</label>
                            <input type="text" id="subject" name="subject" class="w-full border-gray-200 rounded-xl shadow-sm focus:border-cyan-500 focus:ring-cyan-500 px-4 py-3 bg-gray-50/50" placeholder="¿En qué te podemos ayudar?">
                        </div>
                        
                        <div>
                            <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">Mensaje</label>
                            <textarea id="message" name="message" rows="5" class="w-full border-gray-200 rounded-xl shadow-sm focus:border-cyan-500 focus:ring-cyan-500 px-4 py-3 bg-gray-50/50 resize-none" placeholder="Escribe tu mensaje aquí..."></textarea>
                        </div>
                        
                        <div class="pt-4">
                            <x-button type="submit" class="w-full justify-center py-4 text-lg">
                                Enviar Mensaje
                            </x-button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        
    </div>
</section>
@endsection
