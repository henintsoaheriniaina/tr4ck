@props(['title' => 'Flux'])
<!doctype html>
<html class="bg-background">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>{{ $title ? ucfirst("Flux | $title") : 'Flux' }}</title>
</head>

<body class="text-text-main font-sans antialiased" x-data="{ mobileMenu: false }">
    <div class="flex min-h-screen">
        <aside :class="mobileMenu ? 'translate-x-0' : '-translate-x-full'"
            class="bg-background/95 fixed inset-y-0 left-0 z-50 w-72 transform border-r border-white/5 backdrop-blur-xl transition-transform duration-300 lg:static lg:translate-x-0">
            <div class="flex h-full flex-col px-6 py-8">
                <div class="mb-12 flex items-center gap-3 px-2">
                    <div
                        class="bg-primary text-background flex h-8 w-8 items-center justify-center rounded-lg font-black shadow-[0_0_15px_var(--color-primary)]">
                        T</div>
                    <span class="text-xl font-bold tracking-tighter">Flux</span>
                </div>

                <nav class="flex-1 space-y-2">
                    <p class="text-text-muted mb-4 px-4 text-[10px] font-bold uppercase tracking-widest">Navigation</p>
                    <x-ui.nav-link href="{{ route('index') }}" icon="fa-solid fa-chart-line" :active="request()->routeIs('index')">
                        Dashboard
                    </x-ui.nav-link>
                    <i class=""></i>
                    <x-ui.nav-link href="{{ route('wallets.index') }}" icon="fa-solid fa-wallet" :active="request()->routeIs('wallets.index')">
                        Portefeuille
                    </x-ui.nav-link>
                    <x-ui.nav-link href="{{ route('transactions.index') }}" icon="fa-solid fa-right-left"
                        :active="request()->routeIs('transactions.index')">
                        Transactions
                    </x-ui.nav-link>
                    <x-ui.nav-link href="{{ route('settings.index') }}" icon="fa-solid fa-gear" :active="request()->routeIs('settings.index')">
                        Paramètres
                    </x-ui.nav-link>
                </nav>
                <div class="mt-auto border-t border-white/5 pt-6">
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit"
                            class="nav-link w-full text-red-400 hover:bg-red-500/10 hover:text-red-400">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            <span>Déconnexion</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>
        <div x-show="mobileMenu" @click="mobileMenu = false" x-cloak
            class="fixed inset-0 z-40 bg-black/60 backdrop-blur-sm lg:hidden"></div>

        <div class="flex min-w-0 flex-1 flex-col overflow-hidden">
            {{-- header --}}
            <header class="border-primary/20 flex items-center justify-between border-b px-8 py-6 lg:justify-end">
                <x-ui.button @click="mobileMenu = true" icon="fa-solid fa-bars" variant="ghost"
                    class="lg:hidden"></x-ui.button>
                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <p class="text-text-main text-sm font-bold">{{ auth()->user()->name }}</p>
                        <p class="text-text-muted text-[10px] tracking-wider">{{ auth()->user()->email }}</p>
                    </div>
                    <img src="{{ auth()->user()->image_url ?? 'https://ui-avatars.com/api/?name=' . auth()->user()->name }}"
                        class="border-primary/20 shadow-primary/10 h-10 w-10 rounded-full border-2 shadow-lg">
                </div>
            </header>

            {{-- main --}}
            <main class="flex flex-1 flex-col overflow-y-auto px-8 py-12">
                {{ $slot }}
            </main>
        </div>
    </div>

    <x-ui.toaster />
    @stack('modals')
    @stack('scripts')
</body>

</html>
