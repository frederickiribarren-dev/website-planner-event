@props([
    'variant' => 'primary', // Opciones: primary, secondary, outline
    'href' => null          // Si se envía, se renderiza como <a>
])

@php
    // Clases base que tienen TODOS los botones
    $baseClasses = "inline-flex items-center justify-center px-6 py-2 rounded-full text-sm font-semibold transition-all transform active:scale-95";
    
    // Variantes de diseño (Adaptadas a los colores de tu proyecto)
    $variants = [
        'primary' => 'bg-cyan-700 text-white hover:bg-cyan-800 hover:shadow-lg hover:shadow-cyan-100',
        'secondary' => 'bg-gray-100 text-gray-700 hover:bg-gray-200 hover:shadow-md',
        'outline' => 'bg-transparent border-2 border-cyan-500 text-cyan-600 hover:bg-cyan-50',
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
