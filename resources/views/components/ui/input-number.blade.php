@props(['label', 'name', 'placeholder' => '0.00', 'step' => 1])

<div class="w-full space-y-2" x-data="{ value: {{ old($name, 0) }} }">
    @if ($label)
        <label class="text-text-muted ml-1 block text-sm font-medium">{{ $label }}</label>
    @endif

    <div class="relative flex items-center">
        <button type="button" @click="value = parseFloat(value - {{ $step }}).toFixed(2)"
            class="bg-surface-light text-text-main hover:bg-primary hover:text-background absolute left-2 flex h-8 w-8 items-center justify-center rounded-lg transition-all">
            <i data-feather="minus" class="h-4 w-4"></i>
        </button>

        <input type="number" name="{{ $name }}" x-model="value" step="{{ $step }}"
            placeholder="{{ $placeholder }}"
            {{ $attributes->merge(['class' => 'form-control text-center px-12 input-number-no-spinners']) }}>

        <button type="button" @click="value = parseFloat(value + {{ $step }}).toFixed(2)"
            class="bg-surface-light text-text-main hover:bg-primary hover:text-background absolute right-2 flex h-8 w-8 items-center justify-center rounded-lg transition-all">
            <i data-feather="plus" class="h-4 w-4"></i>
        </button>
    </div>
</div>
