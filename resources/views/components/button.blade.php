@props([
    'href' => null,
    'type' => 'button',
])

@php
    $classes = $attributes->get('class', '');
    $hasPadding = preg_match('/\b(p|px|py)-/', $classes);
    
    $baseClasses = "inline-flex items-center justify-center cursor-pointer transition-all focus:outline-none font-semibold rounded-full ring-1 ring-inset";
    if (!$hasPadding) {
        $baseClasses .= " px-8 py-2.5";
    }
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $baseClasses]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $baseClasses]) }}>
        {{ $slot }}
    </button>
@endif
