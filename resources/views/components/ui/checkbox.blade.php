@props([
    'label' => null,
    'name' => '',
    'checked' => false,
    'id' => null,
])

@php
    $id = $id ?? $name;
@endphp

<div class="group flex cursor-pointer items-center gap-3">
    <div class="relative flex items-center">
        <input type="checkbox" name="{{ $name }}" id="{{ $id }}" {{ $checked ? 'checked' : '' }}
            {{ $attributes->merge(['class' => 'checkbox-custom']) }}>
    </div>

    @if ($label)
        <label for="{{ $id }}"
            class="text-text-muted group-hover:text-text-main cursor-pointer text-sm font-medium transition-colors">
            {{ $label }}
        </label>
    @endif

    @error($name)
        <span class="ml-2 text-xs text-red-400">{{ $message }}</span>
    @enderror
</div>
