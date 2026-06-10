<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased min-h-screen relative overflow-x-hidden">
    <!-- Imagen de fondo con Overlay para mejorar legibilidad -->
    <div class="fixed inset-0 z-0 mask-repeat-space">
        <img src="{{ asset('img/fondo-login.jpg') }}" class="w-full h-full object-cover" alt="Background">
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-[2px]"></div>
    </div>
    <!-- Contenido -->
    <div class="relative z-10 min-h-screen flex flex-col sm:justify-center items-center py-10 p-4">
        {{ $slot }}
    </div>
</html>
