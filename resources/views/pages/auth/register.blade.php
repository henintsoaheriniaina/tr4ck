<x-layout.guest title="Créer un compte">
    <div class="mb-8 space-y-1">
        <p class="text-text-muted text-sm">Bienvenue sur Flux!</p>
        <h1
            class="bg-linear-to-r to-text-muted from-white bg-clip-text text-3xl font-extrabold tracking-tight text-transparent">
            Créer un compte
        </h1>
    </div>

    <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data" class="space-y-5"
        x-data="{
            imagePreview: null,
            handleFileChange(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => { this.imagePreview = e.target.result; };
                    reader.readAsDataURL(file);
                }
            }
        }">
        @csrf

        <div class="flex flex-col items-center justify-center space-y-3 pb-2">
            <label @class([
                'group relative flex h-24 w-24 cursor-pointer items-center justify-center overflow-hidden rounded-full border-2 border-dashed transition-all',
                'border-input-border bg-input-bg hover:border-primary/50' => !$errors->has(
                    'image'),
                'border-error bg-error/10 shake' => $errors->has('image'),
            ])>
                <input type="file" name="image" id="image" class="hidden" accept="image/*"
                    @change="handleFileChange" />

                <template x-if="!imagePreview">
                    <div @class([
                        'transition-colors',
                        'text-text-muted group-hover:text-primary' => !$errors->has('image'),
                        'text-error' => $errors->has('image'),
                    ])>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                </template>

                <template x-if="imagePreview">
                    <div class="relative h-full w-full">
                        <img :src="imagePreview" class="h-full w-full object-cover" />
                        <div
                            class="absolute inset-0 flex items-center justify-center bg-black/50 opacity-0 transition-opacity group-hover:opacity-100">
                            <span class="text-[10px] font-bold uppercase text-white">Changer</span>
                        </div>
                    </div>
                </template>
            </label>

            <span
                class="{{ $errors->has('image') ? 'text-error' : 'text-text-muted' }} text-[10px] font-bold uppercase tracking-widest">
                {{ $errors->has('image') ? $errors->first('image') : 'Photo de profil' }}
            </span>
        </div>

        <div class="space-y-4">
            <x-ui.input label="Nom complet" name="name" id="name" type="text" placeholder="Alex Johnson"
                required autofocus />
            <x-ui.input label="Email" name="email" id="email" type="email" placeholder="alex@example.com"
                required />

            <div class="grid grid-cols-2 gap-4">
                <x-ui.input label="Mot de passe" type="password" id="password" name="password" placeholder="••••••••"
                    required />
                <x-ui.input label="Confirmation" type="password" id="password_confirmation" name="password_confirmation"
                    placeholder="••••••••" required />
            </div>
        </div>

        <div class="flex items-start">
            <x-ui.checkbox name="terms" id="terms">
                <x-slot:label>
                    <span class="text-xs">J'accepte les <x-ui.link href="#" variant="underline">Conditions
                            d'utilisation</x-ui.link></span>
                </x-slot:label>
            </x-ui.checkbox>
        </div>

        <x-ui.button type="submit" variant="primary" size="lg" class="w-full">
            S'inscrire
        </x-ui.button>
        <p class="text-center">Déjà membre ? <a href="{{ route('loginPage') }}" variant="underline"
                class="text-white">Se connecter</a> </p>

    </form>
</x-layout.guest>
