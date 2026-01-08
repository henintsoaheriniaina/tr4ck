@props([
    'icon' => 'database',
    'title' => 'Aucune donnée',
    'description' => null,
    'buttonLabel' => null,
    'buttonAction' => null,
    'isLink' => false,
])

<div
    {{ $attributes->merge(['class' => 'col-span-full flex flex-col items-center justify-center rounded-3xl border-2 border-dashed border-white/5 p-12 text-center']) }}>
    <div class="text-text-muted mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-white/5">
        <i class="fa-solid fa-{{ $icon }} text-2xl"></i>
    </div>

    <h3 class="text-text-main text-lg font-semibold">{{ $title }}</h3>

    @if ($description)
        <p class="text-text-muted mx-auto mb-6 max-w-xs text-sm">{{ $description }}</p>
    @endif

    @if ($buttonLabel)
        @if ($isLink)
            <x-ui.button href="{{ $buttonAction }}" variant="outline" size="sm">
                {{ $buttonLabel }}
            </x-ui.button>
        @else
            <x-ui.button @click="{{ $buttonAction }}" variant="outline" size="sm">
                {{ $buttonLabel }}
            </x-ui.button>
        @endif
    @endif
</div>
