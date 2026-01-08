<x-layout.app title="Transactions">
    <div class="mb-8 flex items-center justify-between">
        <h1 class="text-text-main text-3xl font-bold tracking-tight">Transactions</h1>

        <x-ui.button @click="$dispatch('open-modal', 'create-transaction')" variant="primary" icon="fa-solid fa-plus">
            <span>Ajouter</span>
        </x-ui.button>
    </div>

    <form action="{{ route('transactions.index') }}" method="GET"
        class="mb-6 grid gap-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5">
        <div class="grid gap-2 sm:col-span-2">
            <label for="search" class="text-text-muted ml-1 block text-sm font-medium">
                Rechercher
            </label>
            <div class="relative">
                <i
                    class="fa-solid fa-magnifying-glass text-text-muted absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Rechercher une transaction..." class="form-control pl-10 text-sm">
            </div>
        </div>
        <div class="grid gap-2">
            <label for="type" class="text-text-muted ml-1 block text-sm font-medium">
                Type
            </label>
            <x-ui.select name="type" class="w-full" @change="$el.closest('form').submit()" :value="request('type', 'all')"
                :options="[
                    ['label' => 'Tous les types', 'value' => 'all'],
                    ['label' => 'Dépense', 'value' => 'expense'],
                    ['label' => 'Revenu', 'value' => 'income'],
                ]" />
        </div>
    </form>

    <x-ui.card class="p-0!">
        <div class="divide-y divide-white/5">
            @forelse($transactions as $transaction)
                <x-transactions.transaction-item :transaction="$transaction" :wallets="$wallets" :tags="$tags" />
            @empty
                <x-ui.empty-state icon="plus" title="Pas de transactions"
                    description="Vous n'avez pas encore enregistré de mouvements ce mois-ci."
                    button-label="Ajouter une transaction" :is-link="true" :button-action="route('transactions.index')" />
            @endforelse
        </div>
    </x-ui.card>

    <div class="mt-6">
        {{ $transactions->links() }}
    </div>

    @push('modals')
        <x-ui.modal name="create-transaction" title="Nouvelle Transaction" x-init="@if ($errors->any()) $nextTick(() => { show = true }) @endif">
            <form action="{{ route('transactions.store') }}" method="POST" class="space-y-5 p-1">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <x-ui.select label="Type" name="type" :value="old('type', 'expense')" :options="[
                        ['label' => 'Dépense', 'value' => 'expense'],
                        ['label' => 'Revenu', 'value' => 'income'],
                    ]" />
                    <x-ui.select label="Portefeuille" name="wallet_id" :value="old('wallet_id')" :options="$wallets->map(fn($w) => ['label' => $w->name, 'value' => $w->id])->toArray()" />
                </div>

                <x-ui.input label="Description" name="description" placeholder="ex: Courses hebdomadaires" required />

                <x-ui.input-number label="Montant" name="amount" step="0.01" placeholder="0.00" required />
                <x-ui.tag-input label="Tags" name="tags[]" :suggestions="$tags" />

                <x-ui.input label="Date" type="date" name="happened_at" value="{{ date('Y-m-d') }}" />

                <div class="mt-8 flex justify-end gap-3">
                    <x-ui.button type="button" variant="ghost" @click="show = false">Annuler</x-ui.button>
                    <x-ui.button type="submit" variant="primary">Enregistrer</x-ui.button>
                </div>
            </form>
        </x-ui.modal>
    @endpush
</x-layout.app>
