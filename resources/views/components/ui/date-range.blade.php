<div x-data="{
    open: false,
    from: '{{ request('from') }}',
    to: '{{ request('to') }}',
    get label() {
        if (!this.from && !this.to) return 'Toutes les dates';
        return (this.from || '...') + ' au ' + (this.to || '...');
    }
}" class="relative">
    <button type="button" @click="open = !open"
        class="text-text-muted flex items-center gap-2 rounded-full bg-white/5 px-4 py-1.5 text-xs font-medium transition-all hover:bg-white/10">
        <i class="fa-solid fa-calendar"></i>
        <span x-text="label"></span>
    </button>

    <div x-show="open" @click.away="open = false" x-cloak
        class="bg-surface absolute left-0 z-30 mt-2 w-64 rounded-2xl border border-white/5 p-4 shadow-2xl backdrop-blur-xl">
        <div class="space-y-4">
            <div class="space-y-1">
                <label class="text-text-muted font-bold tracking-widest">Du</label>
                <input type="date" name="from" x-model="from" class="form-control text-xs">
            </div>
            <div class="space-y-1">
                <label class="text-text-muted font-bold tracking-widest">Au</label>
                <input type="date" name="to" x-model="to" class="form-control text-xs">
            </div>
            <div class="flex gap-2">
                <button type="submit"
                    class="bg-primary text-background w-full rounded-lg py-2 text-xs font-bold">Filtrer</button>
                <button type="button" @click="from = ''; to = ''; $el.closest('form').submit()"
                    class="text-text-main rounded-lg bg-white/5 px-3 py-2 text-xs font-bold">Reset</button>
            </div>
        </div>
    </div>
</div>
