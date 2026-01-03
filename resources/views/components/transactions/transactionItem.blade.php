@props(['title', 'date', 'amount', 'icon' => null, 'positive' => false])

<div class="list-item">
    <div class="flex items-center gap-3">
        <div class="bg-surface-light flex h-10 w-10 items-center justify-center rounded-lg text-xl">
            {{ $icon ?? '💰' }}
        </div>
        <div>
            <div class="text-text-main text-sm font-medium">{{ $title }}</div>
            <div class="text-text-muted text-xs">{{ $date }}</div>
        </div>
    </div>
    <div @class([
        'text-sm font-bold',
        'text-accent-green' => $positive,
        'text-text-main' => !$positive,
    ])>
        {{ $positive ? '+' : '-' }} {{ $amount }} €
    </div>
</div>
