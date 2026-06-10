@props([
    'variant' => 'primary', // Opciones: primary, secondary,tertiary,login, outline
    'href' => null          // Si se envía, se renderiza como <a>
])

@php
    // Clases base que tienen TODOS los botones
    $baseClasses = "inline-flex items-center justify-center px-6 py-2 rounded-full text-sm font-semibold transition-all transform active:scale-95 cursor-pointer";
    
    // Variantes de diseño (Adaptadas a los colores de tu proyecto)
    $variants = [
        'primary' => 'bg-teal-600 text-white hover:bg-teal-700 hover:shadow-lg hover:shadow-teal-100',
        'secondary' => 'bg-gray-100 text-gray-700 hover:bg-gray-200 hover:shadow-md',
        'tertiary' => 'bg-transparent border-2 border-cyan-600 text-cyan-700 hover:bg-cyan-50',
        'login' => 'bg-cyan-600 text-white hover:bg-cyan-700',
        'outline' => 'bg-transparent border-2 border-teal-500 text-teal-600 hover:bg-teal-50',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 hover:shadow-lg hover:shadow-red-100',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
