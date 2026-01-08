<x-layout.app title="Paramètres">
    <div class="mx-auto max-w-4xl space-y-8">

        <x-ui.card class="z-10">
            <div class="mb-6">
                <h2 class="text-text-main text-xl font-bold">Mon Profil</h2>
                <p class="text-text-muted text-sm">Gérez vos informations personnelles et votre devise.</p>
            </div>

            <form action="{{ route('settings.profile.update') }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                @method('PUT')

                <div class="flex items-center gap-6">
                    <div class="group relative">
                        <img src="{{ $user->image_url ?? 'https://ui-avatars.com/api/?name=' . $user->name }}"
                            alt="Avatar" class="size-24 rounded-2xl border-2 border-white/10 object-cover">
                        <label
                            class="absolute inset-0 flex cursor-pointer items-center justify-center rounded-2xl bg-black/50 transition-opacity">
                            <i class="fa-solid fa-camera text-white"></i>
                            <input type="file" name="image" class="hidden" accept="image/*">
                        </label>
                    </div>
                    <div>
                        <h4 class="text-text-main font-medium">Photo de profil</h4>
                        <p class="text-text-muted text-xs">JPG, PNG ou GIF. Max 2Mo.</p>
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <x-ui.input label="Nom complet" name="name" :value="$user->name" required />
                    <x-ui.input label="Email" type="email" name="email" :value="$user->email" required />

                    <x-ui.select label="Devise" name="currency" :value="$user->currency" :options="[
                        ['label' => 'Dollar ($)', 'value' => '$'],
                        ['label' => 'Euro (€)', 'value' => '€'],
                        ['label' => 'CFA (FCFA)', 'value' => 'FCFA'],
                        ['label' => 'Ariary (MGA)', 'value' => 'MGA'],
                    ]" />
                </div>

                <div class="flex justify-end">
                    <x-ui.button type="submit">Sauvegarder les changements</x-ui.button>
                </div>
            </form>
        </x-ui.card>
        <x-ui.card>
            <div class="mb-6">
                <h2 class="text-text-main text-xl font-bold">Sécurité</h2>
                <p class="text-text-muted text-sm">Assurez-vous d'utiliser un mot de passe robuste.</p>
            </div>

            <form action="{{ route('settings.password.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid gap-4 md:grid-cols-3">
                    <x-ui.input label="Mot de passe actuel" type="password" name="current_password" required />
                    <x-ui.input label="Nouveau mot de passe" type="password" name="password" required />
                    <x-ui.input label="Confirmation" type="password" name="password_confirmation" required />
                </div>

                <div class="flex justify-end pt-2">
                    <x-ui.button type="submit" variant="outline">Modifier le mot de passe</x-ui.button>
                </div>
            </form>
        </x-ui.card>
    </div>
</x-layout.app>
