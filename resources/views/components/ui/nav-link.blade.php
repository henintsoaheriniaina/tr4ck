@props(['href', 'active' => false, 'icon' => 'circle'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => $active ? 'nav-link nav-link-active' : 'nav-link']) }}>
    <i class="{{ $icon }}" class="h-5 w-5"></i>
    <span class="font-medium">{{ $slot }}</span>
</a>
