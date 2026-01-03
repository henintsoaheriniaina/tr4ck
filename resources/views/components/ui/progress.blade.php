@props(['value' => 0, 'max' => 100, 'color' => 'bg-primary'])

<div class="space-y-1">
    <div class="progress-container">
        <div class="progress-bar {{ $color }}" style="width: {{ ($value / $max) * 100 }}%">
        </div>
    </div>
    <div class="text-text-muted flex justify-between text-[10px] font-bold uppercase tracking-wider">
        <span>{{ $value }}</span>
        <span>{{ $max }}</span>
    </div>
</div>
