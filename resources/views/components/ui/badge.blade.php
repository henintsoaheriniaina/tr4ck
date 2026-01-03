@props(['variant' => 'info'])

@php
    $variants = [
        'success' => 'bg-accent-green/10 text-accent-green border-accent-green/20',
        'info' => 'bg-primary/10 text-primary border-primary/20',
        'warning' => 'bg-accent-gold/10 text-accent-gold border-accent-gold/20',
        'danger' => 'bg-red-500/10 text-red-400 border-red-500/20',
    ];
    $class = $variants[$variant] ?? $variants['info'];
@endphp

<span {{ $attributes->merge(['class' => "badge $class"]) }}>
    {{ $slot }}
</span>
