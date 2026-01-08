@props(['title', 'value', 'icon', 'trend' => null, 'variant' => 'default'])

@php
    $variants = [
        'default' => 'text-text-main',
        'success' => 'text-emerald-400',
        'danger' => 'text-rose-400',
    ];
@endphp

<x-ui.card class="relative h-full overflow-hidden">
    <div class="flex items-start justify-between">
        <div class="space-y-2">
            <p class="text-text-muted text-xs font-medium uppercase tracking-wider">{{ $title }}</p>
            <h3 class="{{ $variants[$variant] }} text-2xl font-bold tabular-nums">
                {{ number_format($value, 2, ',', ' ') }}
                {{ auth()->user()->currency ?? '$' }}
            </h3>
        </div>
        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/5">
            <i class="fa-solid fa-{{ $icon }} text-text-muted"></i>
        </div>
    </div>

    <div class="mt-4 flex items-center gap-1 text-[10px] font-bold uppercase tracking-tighter">
        <span class="{{ $trend > 0 ? 'text-emerald-400' : 'text-rose-400' }}">
            <i class="fa-solid fa-arrow-{{ $trend > 0 ? 'up' : 'down' }}"></i>
            {{ abs($trend) }}%
        </span>
        <span class="text-text-muted/50">vs mois dernier</span>
    </div>
</x-ui.card>
