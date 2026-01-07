@props(['align' => 'right'])

{{-- On lie le x-model ou on utilise simplement la variable parente --}}
<div class="relative inline-block text-left" @click.away="dropdownOpen = false">
    {{-- Trigger --}}
    <div @click="dropdownOpen = !dropdownOpen">
        {{ $trigger }}
    </div>

    {{-- Menu --}}
    <div x-show="dropdownOpen" x-transition:enter="transition ease-out duration-100" x-cloak
        x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95" @class([
            'absolute mt-2 w-48 rounded-2xl border border-white/10 bg-surface/95 p-1 shadow-2xl backdrop-blur-xl ring-1 ring-black ring-opacity-5 focus:outline-none z-[100] ',
            'right-0 origin-top-right' => $align === 'right',
            'left-0 origin-top-left' => $align === 'left',
        ]) style="display: none;">
        <div class="py-1">
            {{ $content }}
        </div>
    </div>
</div>
