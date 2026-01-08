<div x-data="{
    notifications: [],
    add(message, type = 'success') {
        const id = Date.now();
        this.notifications.push({ id, message, type });
        setTimeout(() => this.remove(id), 5000);
    },
    remove(id) {
        this.notifications = this.notifications.filter(n => n.id !== id);
    }
}" x-init="@if(session('success'))
add('{{ session('success') }}', 'success');
@endif
@if(session('error'))
add('{{ session('error') }}', 'error');
@endif" class="toast-container">

    <template x-for="n in notifications" :key="n.id">
        <div class="toast-card" @click="remove(n.id)">
            <div
                :class="{
                    'text-primary': n.type === 'success',
                    'text-red-400': n.type === 'error'
                }">
                <template x-if="n.type === 'success'"><i class="fa-solid fa-circle-check" class="h-5 w-5"></i></template>
                <template x-if="n.type === 'error'"><i class="fa-solid fa-circle-exclamation"
                        class="h-5 w-5"></i></template>
            </div>

            <div class="flex-1">
                <p class="text-text-main text-sm font-medium" x-text="n.message"></p>
            </div>

            <button class="text-text-muted hover:text-white">
                <i class="fa-solid fa-x size-4"></i>
            </button>
        </div>
    </template>
</div>
