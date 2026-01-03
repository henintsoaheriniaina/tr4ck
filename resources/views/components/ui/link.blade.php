@props([
    'href' => '#',
    'variant' => 'primary',
])

@php
    $variants = [
        'primary' => 'link-primary font-medium',
        'underline' => 'link-underline',
        'muted' => 'link-muted text-sm',
    ];
    $class = $variants[$variant] ?? $variants['primary'];
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $class]) }}>
    {{ $slot }}
</a>
