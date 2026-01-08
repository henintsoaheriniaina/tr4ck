@props(['title', 'id'])

<x-ui.card {{ $attributes }}>
    <div class="mb-4">
        <h2 class="text-text-main font-bold">{{ $title }}</h2>
    </div>
    <div class="h-62.5 relative w-full">
        <canvas id="{{ $id }}"></canvas>
    </div>
</x-ui.card>
