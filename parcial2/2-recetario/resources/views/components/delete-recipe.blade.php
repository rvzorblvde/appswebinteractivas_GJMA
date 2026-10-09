@props(['recipe'])

<div x-data="{ open: false }" class="inline">
    <button type="button" @click="open = true"
            class="rounded border border-red-300 px-3 py-1.5 text-sm text-red-600 hover:bg-red-50">
        Eliminar
    </button>

    <div x-cloak x-show="open" x-transition.opacity
         @keydown.escape.window="open = false"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
        <div @click.outside="open = false" class="w-full max-w-sm rounded-lg bg-white p-6 shadow-xl">
            <h3 class="text-lg font-semibold">¿Eliminar receta?</h3>
            <p class="mt-2 text-sm text-stone-600">
                Vas a eliminar «{{ $recipe->title }}». Esta acción no se puede deshacer.
            </p>

            <form method="POST" action="{{ route('recetas.destroy', $recipe) }}" class="mt-5 flex justify-end gap-2">
                @csrf
                @method('DELETE')
                <button type="button" @click="open = false"
                        class="rounded border border-stone-300 px-3 py-1.5 text-sm hover:bg-stone-100">Cancelar</button>
                <button type="submit"
                        class="rounded bg-red-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-red-700">Sí, eliminar</button>
            </form>
        </div>
    </div>
</div>
