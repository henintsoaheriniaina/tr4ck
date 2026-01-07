@props(['wallet', 'statuses'])

@php
    $statusColors = [
        'active' => 'bg-emerald-500/10 text-emerald-500',
        'inactive' => 'bg-orange-500/10 text-orange-500',
        'archived' => 'bg-white/5 text-text-muted',
    ];

    $colorClass = $statusColors[$wallet->status->value] ?? 'bg-white/5 text-text-muted';

    $specialClasses =
        'group relative  transition-all hover:border-primary/30 hover:shadow-[0_0_30px_-10px_rgba(var(--color-primary),0.2)]';
    if ($wallet->status->value === 'archived') {
        $specialClasses .= ' opacity-75 grayscale-[0.5]';
    }
@endphp

<x-ui.card x-data="{ dropdownOpen: false }" {{ $attributes->merge(['class' => $specialClasses]) }} ::class="dropdownOpen ? 'z-50 relative' : 'relative hover:z-20'">
    <div
        class="bg-primary/5 absolute -right-10 -top-10 h-32 w-32 rounded-full opacity-0 blur-3xl transition-opacity group-hover:opacity-100">
    </div>

    <div class="relative flex h-full flex-col justify-between space-y-4">
        <div class="flex items-center justify-between">
            <div class="bg-primary/10 text-primary flex h-12 w-12 items-center justify-center rounded-2xl shadow-inner">
                <i data-feather="briefcase" class="h-6 w-6"></i>
            </div>

            <span
                class="{{ $colorClass }} rounded-md px-2 py-1 text-[10px] font-bold uppercase tracking-widest transition-colors">
                {{ $wallet->status->label }}
            </span>
        </div>

        <div>
            <p class="text-text-muted mb-1 text-sm font-medium">{{ $wallet->name }}</p>
            <h3 class="text-text-main flex items-center gap-2 text-2xl font-bold tracking-tight">
                <span class="text-primary">{{ auth()->user()->currency ?? '$' }}</span>
                <span>{{ number_format($wallet->balance, 2, ',', ' ') }}</span>
            </h3>
        </div>

        <div class="flex items-center justify-between border-t border-white/5 pt-3">
            <span class="text-text-muted text-[11px] italic">
                {{ $wallet->updated_at->diffForHumans() }}
            </span>

            {{-- Le Dropdown de changement de statut --}}
            <x-ui.dropdown align="right">
                <x-slot:trigger>
                    <button class="text-text-muted hover:text-primary cursor-pointer p-1 transition-colors">
                        <i data-feather="more-horizontal" class="h-5 w-5"></i>
                    </button>
                </x-slot:trigger>

                <x-slot:content>
                    <div class="text-text-muted/50 px-3 py-2 text-[10px] font-bold uppercase tracking-widest">
                        Changer le statut
                    </div>
                    @foreach ($statuses as $status)
                        <form action="{{ route('wallets.update-status', $wallet) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="{{ $status['value'] }}">
                            <button type="submit" @class([
                                'flex w-full items-center gap-2 px-3 py-2 text-sm transition-colors rounded-xl',
                                'text-primary bg-primary/5 font-semibold' =>
                                    $wallet->status->value === $status['value'],
                                'text-text-muted hover:bg-white/5 hover:text-text-main' =>
                                    $wallet->status->value !== $status['value'],
                            ])>
                                <i data-feather="{{ $status['value'] === 'active' ? 'check-circle' : ($status['value'] === 'archived' ? 'archive' : 'slash') }}"
                                    class="h-4 w-4"></i>
                                {{ $status['label'] }}
                            </button>
                        </form>
                    @endforeach

                    <div class="my-1 border-t border-white/5"></div>
                    <form action="{{ route('wallets.destroy', $wallet) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button
                            class="flex w-full items-center gap-2 rounded-xl px-3 py-2 text-sm text-red-400 transition-colors hover:bg-red-500/10">
                            <i data-feather="trash-2" class="h-4 w-4"></i>
                            Supprimer
                        </button>
                    </form>

                </x-slot:content>
            </x-ui.dropdown>
        </div>
    </div>
</x-ui.card>
