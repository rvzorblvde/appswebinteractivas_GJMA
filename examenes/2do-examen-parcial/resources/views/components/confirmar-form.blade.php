@props([
    'action', 'method' => 'DELETE',
    'title' => '¿Estás seguro?',
    'message' => 'Esta acción no se puede deshacer.',
    'button' => 'Confirmar', 'trigger',
])
<div x-data="{ open: false }" class="inline">
    <button type="button" @click="open = true" {{ $attributes->merge(['class' => 'btn-danger']) }}>
        {{ $trigger }}
    </button>

    <template x-teleport="body">
        <div x-show="open" x-cloak x-transition.opacity @keydown.escape.window="open = false"
             class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 p-4">
            <div x-show="open" x-transition @click.outside="open = false"
                 class="w-full max-w-sm rounded-2xl bg-white p-6 shadow-xl">
                <h3 class="font-display text-2xl font-bold text-slate-900">{{ $title }}</h3>
                <p class="mt-2 text-sm text-slate-600">{{ $message }}</p>
                <form method="POST" action="{{ $action }}" class="mt-6 flex justify-end gap-2">
                    @csrf
                    @method($method)
                    <button type="button" @click="open = false" class="btn-ghost">Volver</button>
                    <button type="submit" class="btn-danger">{{ $button }}</button>
                </form>
            </div>
        </div>
    </template>
</div>
