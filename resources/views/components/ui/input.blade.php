@props([
    'label' => null,
    'name' => '',
    'type' => 'text',
    'placeholder' => '',
    'rows' => 4,
    'value' => null,
])

<div class="w-full space-y-2">
    @if ($label)
        <label for="{{ $name }}" class="text-text-muted ml-1 block text-sm font-medium">
            {{ $label }}
        </label>
    @endif

    @php
        $errorClasses = $errors->has($name) ? 'form-control-error shake' : '';
        $inputValue = old($name, $value);
    @endphp

    @if ($type === 'textarea')
        <textarea name="{{ $name }}" id="{{ $name }}" rows="{{ $rows }}" placeholder="{{ $placeholder }}"
            {{ $attributes->merge(['class' => "form-control resize-none $errorClasses"]) }}>{{ $inputValue ?? $slot }}</textarea>
    @else
        <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}"
            placeholder="{{ $placeholder }}" value="{{ $type !== 'password' ? $inputValue : '' }}"
            {{ $attributes->merge(['class' => "form-control $errorClasses"]) }}>
    @endif

    @error($name)
        <div class="text-error ml-1 mt-1 flex items-center gap-1.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                    clip-rule="evenodd" />
            </svg>
            <span class="text-xs font-medium">{{ $message }}</span>
        </div>
    @enderror
</div>
