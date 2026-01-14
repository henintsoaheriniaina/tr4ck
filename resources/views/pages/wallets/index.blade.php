<x-layout.app title="Portefeuilles">

    <div class="mb-8 flex items-center justify-between">
        <h1 class="text-3xl font-bold tracking-tight">Portefeuilles</h1>
        <div class="flex items-center justify-center gap-2">

            <x-ui.button @click="$dispatch('open-modal', 'trash')" variant="outline" icon="fa-solid fa-trash">
                <span class="hidden md:inline">Corbeille</span>
            </x-ui.button>
            <x-ui.button @click="$dispatch('open-modal', 'create-wallet')" variant="primary" icon="fa-solid fa-plus">
                <span class="hidden md:inline">Ajouter</span>
            </x-ui.button>
        </div>
    </div>
    @push('modals')
        <x-ui.modal name="trash" title="Corbeille">
            <div class="overflow-y-auto" style="height: calc(100vh - 200px);">
                <div class="flex items-center justify-end gap-2">
                    <form action="{{ route('wallets.restoreAll') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <x-ui.button type="button" variant="primary">
                            Restaurer
                        </x-ui.button>
                    </form>
                    <form action="{{ route('wallets.clearTrash') }}" method="POST">
                        @csrf
                        @method('delete')
                        <x-ui.button type="button" variant="danger">
                            Vider
                        </x-ui.button>
                    </form>
                </div>
                <div class="mt-4 flex flex-col gap-2">
                    @forelse ($trashed as $trashed_item)
                        <div class="flex items-center justify-between gap-2">
                            <span>
                                {{ $trashed_item->name }}
                            </span>
                            <div class="flex items-center justify-between gap-2">
                                <form method="POST" action="{{ route('wallets.restoreOne', $trashed_item) }}">
                                    @csrf
                                    @method('PUT')
                                    <x-ui.button variant="primary" icon="fa-solid fa-plus" type="submit" />
                                </form>
                                <form method="POST" action="{{ route('wallets.forceDestroy', $trashed_item) }}">
                                    @csrf
                                    @method('DELETE')
                                    <x-ui.button variant="danger" icon="fa-solid fa-trash" type="submit" />
                                </form>
                            </div>
                        </div>
                    @empty
                        La corbeille est vide.
                    @endforelse
                </div>

            </div>
        </x-ui.modal>
    @endpush
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
            <x-ui.empty-state icon="wallet" title="Aucun portefeuille"
                description="Commencez par créer votre premier portefeuille pour suivre vos finances."
                button-label="Créer mon premier portefeuille"
                button-action="$dispatch('open-modal', 'create-wallet')" />
        @endforelse
    </div>
    {{ $wallets->links() }}

</x-layout.app>
