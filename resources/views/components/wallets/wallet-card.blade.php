@props(['wallet'])

@php

    $specialClasses =
        'group relative  transition-all hover:border-primary/30 hover:shadow-[0_0_30px_-10px_rgba(var(--color-primary),0.2)]';

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

            <x-ui.dropdown align="right">
                <x-slot:trigger>
                    <button class="text-text-muted hover:text-primary cursor-pointer p-1 transition-colors">
                        <i data-feather="more-horizontal" class="h-5 w-5"></i>
                    </button>
                </x-slot:trigger>
                <x-slot:content>
                    <button @click="$dispatch('open-modal', 'edit-wallet-{{ $wallet->id }}')"
                        @class([
                            'flex w-full items-center gap-2 px-3 py-2 text-sm transition-colors rounded-xl text-primary hover:bg-primary/5 font-semibold',
                        ])>
                        <i data-feather="edit" class="h-4 w-4"></i>
                        Modifier
                    </button>
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
        <div>
            <p class="text-text-muted mb-1 text-sm font-medium">{{ $wallet->name }}</p>
            <h3 class="text-text-main flex items-center gap-2 text-2xl font-bold tracking-tight">
                <span class="text-primary">{{ auth()->user()->currency ?? '$' }}</span>
                <span>{{ number_format($wallet->balance, 2, ',', ' ') }}</span>
            </h3>
        </div>
    </div>
    @push('modals')
        <x-ui.modal name="edit-wallet-{{ $wallet->id }}" title="Modifier le Portefeuille">
            <form action="{{ route('wallets.update', $wallet) }}" method="POST" class="space-y-6 p-6">
                @csrf
                @method('PUT')

                <x-ui.input label="Nom du portefeuille" name="name" :value="$wallet->name" required />

                <x-ui.input-number label="Solde actuel" name="balance" step="0.01" :value="$wallet->balance" />

                <div class="mt-8 flex justify-end gap-3">
                    <x-ui.button type="button" variant="ghost" @click="show = false">
                        Annuler
                    </x-ui.button>
                    <x-ui.button type="submit" variant="primary">
                        Enregistrer
                    </x-ui.button>
                </div>
            </form>
        </x-ui.modal>
    @endpush

</x-ui.card>
