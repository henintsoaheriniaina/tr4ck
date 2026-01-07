<x-layout.app title="Portefeuilles">

    <div class="mb-8 flex items-center justify-between">
        <h1 class="text-3xl font-bold tracking-tight">Portefeuilles</h1>

        <x-ui.button @click="$dispatch('open-modal', 'create-wallet')" variant="primary" icon="plus">
            Nouveau
        </x-ui.button>
    </div>
    @push('modals')
        <x-ui.modal name="create-wallet" title="Nouveau Portefeuille">
            <form action="{{ route('wallets.store') }}" method="POST" class="space-y-6">
                @csrf
                <x-ui.input label="Nom du portefeuille" name="name" placeholder="ex: Compte Mvola" required />
                <x-ui.input-number label="Solde initial (Optionnel)" name="balance" step="0.01" placeholder="0.00" />

                <div class="mt-8 flex justify-end gap-3">
                    <x-ui.button type="button" variant="ghost" @click="show = false">
                        Annuler
                    </x-ui.button>
                    <x-ui.button type="submit" variant="primary">
                        Créer
                    </x-ui.button>
                </div>
            </form>
        </x-ui.modal>
    @endpush

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-3">
        @forelse ($wallets as $wallet)
            <x-wallets.wallet-card :wallet="$wallet" />
        @empty
            <div
                class="col-span-full flex flex-col items-center justify-center rounded-3xl border-2 border-dashed border-white/5 p-12 text-center">
                <div class="text-text-muted mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-white/5">
                    <i data-feather="database" class="h-8 w-8"></i>
                </div>
                <h3 class="text-text-main text-lg font-semibold">Aucun portefeuille</h3>
                <p class="text-text-muted mb-6 text-sm">Commencez par créer votre premier portefeuille pour suivre vos
                    finances.</p>
                <x-ui.button @click="$dispatch('open-modal', 'create-wallet')" variant="outline" size="sm">
                    Créer mon premier portefeuille
                </x-ui.button>
            </div>
        @endforelse
    </div>

</x-layout.app>
