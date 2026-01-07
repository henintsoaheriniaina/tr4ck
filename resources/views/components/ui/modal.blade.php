@props(['name', 'title' => null])
<div x-data="{ show: false }" x-show="show" x-cloak
    x-on:open-modal.window="if ($event.detail === '{{ $name }}') show = true"
    x-on:close-modal.window="show = false" x-on:keydown.escape.window="show = false" style="display: none;"
    class="relative z-50">
    <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="show = false"
        class="modal-backdrop"></div>

    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
            class="modal-content" @click.away="show = false">
            <div class="flex items-center justify-between">
                @if ($title)
                    <h2 class="text-text-main text-xl font-bold tracking-tight">{{ $title }}</h2>
                @endif
                <button @click="show = false" class="text-text-muted hover:text-text-main transition-colors">
                    <i data-feather="x" class="h-5 w-5"></i>
                </button>
            </div>

            <div class="mt-2">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
