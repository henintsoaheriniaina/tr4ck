<x-layout.app title="Accueil">
    <div class="flex items-center justify-between">
        <div>
            <p>Bienvenue sur Tr4ck</p>
            <h1>{{ auth()->user()->name }}</h1>
        </div>
        <x-ui.button variant="outline" icon="bell" />
    </div>
</x-layout.app>
