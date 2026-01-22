<x-layout.guest title="Connexion">
    <div class="mb-8 space-y-1">
        <p class="text-text-muted text-sm">Veuillez entrer vos identifiants.</p>
        <h1
            class="bg-linear-to-r to-text-muted from-white bg-clip-text text-3xl font-extrabold tracking-tight text-transparent">
            Ravi de te revoir !
        </h1>
    </div>

    <form action="{{ route('login') }}" method="POST" class="space-y-6">
        @csrf
        <div class="space-y-4">
            <x-ui.input label="Email" name="email" id="email" type="email" placeholder="alex@example.com"
                autofocus required />
            <x-ui.input label="Mot de passe" type="password" id="password" name="password" placeholder="••••••••"
                required />
        </div>

        <div class="flex items-center justify-between">
            <x-ui.checkbox name="remember" id="remember" label="Se souvenir de moi" />
            <x-ui.link href="#" variant="underline" class="text-xs">
                Mot de passe oublié ?
            </x-ui.link>
        </div>

        <x-ui.button type="submit" variant="primary" class="w-full">
            Se connecter
        </x-ui.button>

        <p class="text-center">Vous n'avez pas de compte ? <a href="{{ route('registerPage') }}" variant="underline"
                class="text-white">S'inscrire</a> </p>
    </form>
</x-layout.guest>
