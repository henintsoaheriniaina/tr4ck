@props([
    'label' => null,
    'name' => '',
    'placeholder' => '0.00',
    'step' => 1,
    'value' => 0,
])

<div class="w-full space-y-2" x-data="{
    value: {{ old($name, $value ?? 0) }},
    increment() { this.value = (parseFloat(this.value) + {{ $step }}).toFixed(2) },
    decrement() { this.value = (parseFloat(this.value) - {{ $step }}).toFixed(2) }
}">

    @if ($label)
        <label for="{{ $name }}" class="text-text-muted ml-1 block text-sm font-medium">
            {{ $label }}
        </label>
    @endif

    @php
        $errorClasses = $errors->has($name) ? 'form-control-error shake' : '';
    @endphp

    <div class="relative flex items-center">
        {{-- Bouton Moins --}}
        <button type="button" @click="decrement()"
            class="bg-surface-light text-text-main hover:bg-primary hover:text-background absolute left-2 z-10 flex h-8 w-8 items-center justify-center rounded-lg transition-all">
            <i data-feather="minus" class="h-4 w-4"></i>
        </button>

        {{-- Input --}}
        <input type="number" name="{{ $name }}" id="{{ $name }}" x-model="value"
            step="{{ $step }}" placeholder="{{ $placeholder }}"
            {{ $attributes->merge(['class' => "form-control text-center px-12 input-number-no-spinners $errorClasses"]) }}>

        {{-- Bouton Plus --}}
        <button type="button" @click="increment()"
            class="bg-surface-light text-text-main hover:bg-primary hover:text-background absolute right-2 z-10 flex h-8 w-8 items-center justify-center rounded-lg transition-all">
            <i data-feather="plus" class="h-4 w-4"></i>
        </button>
    </div>

    {{-- Gestion des erreurs --}}
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
