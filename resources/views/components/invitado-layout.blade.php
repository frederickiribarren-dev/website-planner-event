<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Invitación - {{ config('app.name', 'BabyCelebrate') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,900&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-900">
        <div class="min-h-screen bg-slate-50 flex">
            
            {{-- Sidebar del Invitado (Mismo diseño que admin) --}}
            <aside class="w-72 h-screen sticky top-0 bg-slate-50 border-r border-slate-200 hidden md:flex flex-col transition-all duration-300 z-10">
                <!-- Header/Logo Area -->
                <div class="px-8 py-4">
                    <div class="flex items-center gap-3">
                        <x-application-logo />
                    </div>
                </div>
                
                <!-- Perfil del Invitado Arriba -->
                <div class="px-6 py-4">
                    <div class="bg-white border border-slate-200 p-4 rounded-[2rem] shadow-sm flex items-center gap-3">
                        <div class="w-10 h-10 bg-cyan-50 rounded-full flex items-center justify-center font-bold text-cyan-600 border border-cyan-100 italic">
                            I
                        </div>
                        <div class="overflow-hidden text-ellipsis">
                            <p class="text-xs font-black text-slate-800 truncate">Hola, Invitado</p>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">¿Nos acompañas?</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 space-y-2 overflow-y-auto mt-2">
                    <div>
                        <p class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 mt-2">Menú Invitación</p>
                        
                        <x-nav-link :href="route('invitado.confirmacion')" :active="request()->routeIs('invitado.confirmacion')" 
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 hover:bg-white hover:shadow-sm group">
                            <svg class="w-5 h-5 {{ request()->routeIs('invitado.confirmacion') ? 'text-teal-600' : 'text-slate-400 group-hover:text-teal-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="font-bold text-slate-600 group-hover:text-slate-900 uppercase text-[11px] tracking-wider">Confirmar Asistencia</span>
                        </x-nav-link>
                        
                        <x-nav-link :href="route('invitado.regalos')" :active="request()->routeIs('invitado.regalos')" 
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 hover:bg-white hover:shadow-sm group mt-2">
                            <svg class="w-5 h-5 {{ request()->routeIs('invitado.regalos') ? 'text-teal-600' : 'text-slate-400 group-hover:text-teal-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                            <span class="font-bold text-slate-600 group-hover:text-slate-900 uppercase text-[11px] tracking-wider">Mesa de Regalos</span>
                        </x-nav-link>
                    </div>
                </nav>
            </aside>

            {{-- Mobile Header (solo visible en pantallas pequeñas) --}}
            <div class="md:hidden fixed top-0 left-0 right-0 h-16 bg-slate-50 border-b border-slate-200 z-20 flex items-center justify-between px-6">
                <x-application-logo />
                <button class="text-slate-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>

            {{-- Main Content (Igual que admin) --}}
            <div class="flex-1 flex flex-col h-screen overflow-y-auto pt-16 md:pt-0 bg-slate-100 md:bg-transparent" style="background-color: #f8fafc;">
                <main class="p-6 lg:p-8">
                    <div class="max-w-7xl mx-auto">
                        {{ $slot }}
                    </div>
                </main>
            </div>
            
        </div>
    </body>
</html>
