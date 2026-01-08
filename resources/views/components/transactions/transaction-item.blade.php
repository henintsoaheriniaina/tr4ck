@props(['transaction', 'wallets', 'tags' => []])

@php
    $isIncome = $transaction->type === 'income';
@endphp

<div class="hover:bg-white/2 group relative flex items-center justify-between p-4 transition-colors">
    <div class="flex items-center gap-4">
        <div @class([
            'flex h-12 w-12 items-center justify-center rounded-2xl text-xl shadow-sm transition-transform group-hover:scale-110',
            'bg-emerald-500/10 text-emerald-400' => $isIncome,
            'bg-rose-500/10 text-rose-400' => !$isIncome,
        ])>
            <i class="fa-solid fa-arrow-trend-{{ $isIncome ? 'up' : 'down' }}"></i>
        </div>

        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <span class="text-text-main text-sm font-semibold leading-none">
                    {{ $transaction->description }}
                </span>
                <span
                    class="text-text-muted rounded bg-white/5 px-1.5 py-0.5 text-[10px] font-medium uppercase tracking-wider">
                    {{ $transaction->wallet->name }}
                </span>
            </div>

            <div class="flex items-center gap-2">
                <span class="text-text-muted text-xs">
                    {{ $transaction->happened_at->format('d M, H:i') }}
                </span>
                <div class="flex gap-1">
                    @foreach ($transaction->tags->take(2) as $tag)
                        <span class="text-primary/60 text-[10px]">#{{ $tag->name }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="flex items-center gap-4">
        <div class="text-right">
            <div @class([
                'text-sm font-bold tabular-nums',
                'text-emerald-400' => $isIncome,
                'text-danger' => !$isIncome,
            ])>
                {{ $isIncome ? '+' : '-' }} {{ number_format($transaction->amount, 2, ',', ' ') }}
                <span class="text-primary"> {{ auth()->user()->currency ?? '$' }} </span>
            </div>
        </div>
    </div>
</div>
