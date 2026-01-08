{{-- resources/views/components/ui/select.blade.php --}}
@props([
    'label' => null,
    'name' => '',
    'value' => null,
    'options' => [],
    'placeholder' => 'Choisir...',
])

<div {{ $attributes->merge(['class' => 'w-full space-y-2']) }} x-data="{
    open: false,
    selected: @js($value),
    options: @js($options),
    get currentLabel() {
        if (!this.selected) return '{{ $placeholder }}';
        let opt = this.options.find(o => String(o.value) === String(this.selected));
        return opt ? opt.label : '{{ $placeholder }}';
    },
    select(val) {
        this.selected = val;
        this.open = false;
        $nextTick(() => {
            $root.dispatchEvent(new CustomEvent('change', { detail: val, bubbles: true }));
        });
    }
}" @click.away="open = false">

    @if ($label)
        <label class="text-text-muted ml-1 block text-sm font-medium">{{ $label }}</label>
    @endif

    <div class="relative">
        <input type="hidden" name="{{ $name }}" :value="selected">

        <button type="button" @click="open = !open"
            class="form-control focus:ring-primary/20 flex w-full items-center justify-between px-4 py-2.5 text-left text-sm shadow-none transition-all focus:ring-2"
            :class="open ? 'border-primary ring-2 ring-primary/20' : ''">

            <span x-text="currentLabel" :class="!selected ? 'text-text-muted' : 'text-text-main'"></span>

            <i class="fa-solid fa-chevron-down text-text-muted h-4 w-4 transition-transform duration-200"
                :class="open ? 'rotate-180' : ''"></i>
        </button>

        <div x-show="open" x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-cloak
            class="bg-surface/90 no-scrollbar z-100 absolute mt-2 max-h-60 w-full overflow-auto rounded-2xl border border-white/5 p-1.5 shadow-2xl backdrop-blur-xl">

            <div class="flex flex-col gap-0.5">
                <template x-for="option in options" :key="option.value">
                    <button type="button" @click="select(option.value)"
                        class="text-text-main flex w-full items-center rounded-xl px-3 py-2.5 text-sm transition-colors hover:bg-white/5"
                        :class="selected == option.value ? 'bg-primary/10 text-primary font-bold' : ''">

                        <span x-text="option.label"></span>

                        <template x-if="selected == option.value">
                            <i class="fa-solid fa-check ml-auto size-3"></i>
                        </template>
                    </button>
                </template>
            </div>
        </div>
    </div>
</div>
