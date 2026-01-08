@props(['label', 'name', 'suggestions' => []])

<div class="w-full space-y-2" x-data="{
    tags: {{ json_encode(old(str_replace(['[', ']'], '', $name), [])) }},
    newTag: '',
    addTag() {
        let val = this.newTag.trim();
        if (val && !this.tags.includes(val)) {
            this.tags.push(val);
        }
        this.newTag = '';
    },
    removeTag(index) {
        this.tags.splice(index, 1);
    }
}">
    @if ($label)
        <label class="text-text-muted ml-1 block text-sm font-medium">{{ $label }}</label>
    @endif

    {{-- Conteneur principal qui imite l'input --}}
    <div @click="$refs.inputField.focus()"
        class="form-control focus-within:ring-primary/20 focus-within:border-primary flex min-h-11 w-full cursor-text flex-wrap items-center gap-2 overflow-hidden p-3 transition-all focus-within:ring-2">

        {{-- Liste des Badges --}}
        <template x-for="(tag, index) in tags" :key="index">
            <span
                class="bg-primary/10 text-primary border-primary/20 animate-in fade-in zoom-in group flex items-center gap-1.5 rounded-md border px-2 py-0.5 text-xs font-semibold duration-150">
                <span x-text="tag"></span>
                <input type="hidden" name="{{ $name }}" :value="tag">
                <button type="button" @click.stop="removeTag(index)"
                    class="text-primary/40 hover:text-primary transition-colors">
                    <i class="fa-solid fa-x h-3 w-3"></i>
                </button>
            </span>
        </template>

        {{-- L'input "Invisible" --}}
        <input type="text" x-ref="inputField" x-model="newTag" @keydown.enter.prevent="addTag()"
            @keydown.comma.prevent="addTag()" @keydown.backspace="if (newTag === '') removeTag(tags.length - 1)"
            placeholder="{{ count($suggestions) > 0 ? '' : 'Ajouter des tags...' }}" {{-- Ici on force border-none et outline-none --}}
            class="placeholder:text-text-muted/40 min-w-80px h-7 flex-1 border-none bg-transparent p-0 text-sm shadow-none focus:outline-none focus:ring-0">
    </div>
</div>
