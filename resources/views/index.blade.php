<x-layout.app title="Tableau de Bord">
    <div class="mb-8">
        <p class="text-text-muted text-sm font-medium">Content de vous revoir,</p>
        <h1 class="text-text-main text-3xl font-bold tracking-tight">{{ auth()->user()->name }} 👋</h1>
    </div>
    <div class="mb-8 grid gap-4 lg:grid-cols-4 xl:grid-cols-3">

        <x-ui.card class="relative overflow-hidden lg:col-span-4 xl:col-span-2 xl:row-span-2">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <p class="text-text-muted text-xs font-medium uppercase tracking-wider">Évolution du Solde</p>
                    <h3 class="text-text-main text-2xl font-bold">{{ number_format($totalBalance, 2, ',', ' ') }} <span
                            class="text-primary"> {{ auth()->user()->currency ?? '$' }} </span></h3>
                </div>

            </div>
            <div class="h-75 w-full">
                <canvas id="balanceChart"></canvas>
            </div>
        </x-ui.card>
        <div class="lg:col-span-2 xl:col-span-1">
            <x-ui.stat-card title="Revenus du mois" :value="$monthlyIncome" icon="arrow-up-long" variant="success"
                :trend="$incomeTrend" />
        </div>
        <div class="lg:col-span-2 xl:col-span-1">
            <x-ui.stat-card title="Dépenses du mois" :value="$monthlyExpenses" icon="arrow-down-long" variant="danger"
                :trend="$expenseTrend" class="lg:col-span-2 xl:col-span-1" />
        </div>

    </div>

    <div class="grid gap-6 xl:grid-cols-3">
        <div class="space-y-6">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-text-main font-bold">Mes Portefeuilles</h2>
                <a href="{{ route('wallets.index') }}" class="text-primary text-xs font-semibold hover:underline">Voir
                    tout</a>
            </div>
            <div class="space-y-3">
                @forelse  (auth()->user()->wallets as $wallet)
                    <div
                        class="bg-surface flex items-center justify-between rounded-2xl border border-white/5 p-4 shadow-sm transition-transform hover:scale-[1.02]">
                        <div class="flex items-center gap-3">
                            <div
                                class="bg-primary/10 text-primary flex h-10 w-10 items-center justify-center rounded-xl font-bold">
                                {{ substr($wallet->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-text-main text-sm font-semibold">{{ $wallet->name }}</p>
                                <p class="text-text-muted text-[10px] font-bold uppercase">{{ $wallet->currency }}</p>
                            </div>
                        </div>
                        <p class="text-text-main text-sm font-bold">{{ number_format($wallet->balance, 2, ',', ' ') }}
                            <span class="text-primary"> {{ auth()->user()->currency ?? '$' }} </span>
                        </p>
                    </div>
                @empty
                    <x-ui.card class="p-0! overflow-hidden">
                        <x-ui.empty-state icon="wallet" title="Pas de portefeuilles"
                            description="Vous n'avez pas encore enregistré de portefeuilles."
                            button-label="Ajouter un portefeuille" :is-link="true" :button-action="route('wallets.index')" />
                    </x-ui.card>
                @endforelse
            </div>
        </div>
        <div class="xl:col-span-2">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-text-main font-bold">Dernières activités</h2>
                <a href="{{ route('transactions.index') }}"
                    class="text-primary text-xs font-semibold hover:underline">Voir tout</a>
            </div>

            <x-ui.card class="p-0! overflow-hidden">
                <div class="divide-y divide-white/5">
                    @forelse($recentTransactions as $transaction)
                        <x-transactions.transaction-item :transaction="$transaction" />
                    @empty
                        <x-ui.empty-state icon="plus" title="Pas de transactions"
                            description="Vous n'avez pas encore enregistré de mouvements ce mois-ci."
                            button-label="Ajouter une transaction" :is-link="true" :button-action="route('transactions.index')" />
                    @endforelse
                </div>
            </x-ui.card>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('balanceChart').getContext('2d');
                const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                gradient.addColorStop(0, 'rgba(16, 185, 129, 0.2)');
                gradient.addColorStop(1, 'rgba(16, 185, 129, 0)');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @js($days),
                        datasets: [{
                            data: @js($dailyData),
                            borderColor: '#10b981',
                            borderWidth: 3,
                            fill: true,
                            backgroundColor: gradient,
                            tension: 0.4,
                            pointRadius: 0,
                            pointHoverRadius: 6,
                            pointBackgroundColor: '#10b981',
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.05)',
                                    drawBorder: false
                                },
                                ticks: {
                                    color: '#94a3b8',
                                    font: {
                                        size: 10
                                    },
                                    callback: (v) => v + ' €'
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: '#94a3b8',
                                    font: {
                                        size: 10
                                    }
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
</x-layout.app>
