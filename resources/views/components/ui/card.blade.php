@props(['title' => null, 'subtitle' => null])

<div {{ $attributes->merge(['class' => 'card']) }}>
    @if ($title || $subtitle)
        <div class="mb-5">
            @if ($title)
                <h3 class="text-text-main m-0 text-lg font-semibold">{{ $title }}</h3>
            @endif
            @if ($subtitle)
                <p class="text-text-muted mt-1 text-xs">{{ $subtitle }}</p>
            @endif
        </div>
    @endif

    <div>
        {{ $slot }}
    </div>
</div>
