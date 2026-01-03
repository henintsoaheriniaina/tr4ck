@props([
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
    'icon' => null,
    'type' => 'button',
])

@php
    // variants
    $variants = [
        'primary' => 'btn-primary',
        'outline' => 'btn-outline',
        'ghost' => 'btn-ghost',
        'danger' => 'btn-danger',
        'secondary' => 'btn-secondary',
    ];

    // sizes
    $sizes = [
        'sm' => 'px-3 py-1.5 text-xs',
        'md' => 'px-4 py-2.5 text-sm',
        'lg' => 'px-6 py-3 text-base',
    ];

    $classes = 'btn ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon)
            <span class="mr-2">{{ $icon }}</span>
        @endif
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon)
            <span class="mr-2">{{ $icon }}</span>
        @endif
        {{ $slot }}
    </button>
@endif
