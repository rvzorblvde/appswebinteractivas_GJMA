@extends('layouts.app')
@section('title', 'Mis recetas')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold">Mis recetas</h1>
        <span class="text-sm text-stone-500">{{ $total }} {{ $total === 1 ? 'receta' : 'recetas' }} en total</span>
    </div>

    {{-- Buscador y filtro --}}
    <form method="GET" action="{{ route('recetas.index') }}"
          class="mb-6 flex flex-col gap-3 rounded-lg bg-white p-4 shadow-sm ring-1 ring-stone-200 sm:flex-row">
        <input type="text" name="q" value="{{ $search }}" placeholder="Buscar por título…"
               class="w-full rounded border border-stone-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400">

        <select name="category"
                class="rounded border border-stone-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400 sm:w-56">
            <option value="">Todas las categorías</option>
            @foreach (\App\Models\Recipe::CATEGORIES as $value => $label)
                <option value="{{ $value }}" @selected($category === $value)>{{ $label }}</option>
            @endforeach
        </select>

        <button type="submit" class="rounded bg-orange-600 px-4 py-2 font-medium text-white hover:bg-orange-700">Buscar</button>

        @if ($search !== '' || $category)
            <a href="{{ route('recetas.index') }}"
               class="rounded border border-stone-300 px-4 py-2 text-center hover:bg-stone-100">Limpiar</a>
        @endif
    </form>

    @if ($recipes->isEmpty())
        <div class="rounded-lg border border-dashed border-stone-300 bg-white p-10 text-center text-stone-600">
            @if ($search !== '' || $category)
                <p class="font-medium">No se encontraron recetas con los filtros aplicados.</p>
                <p class="mt-1 text-sm">Prueba con otro título o selecciona otra categoría.</p>
            @else
                <p class="font-medium">Aún no tienes recetas guardadas.</p>
                <a href="{{ route('recetas.create') }}" class="mt-3 inline-block text-orange-600 hover:underline">Crea tu primera receta</a>
            @endif
        </div>
    @else
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($recipes as $recipe)
                <article class="flex flex-col justify-between rounded-lg bg-white p-4 shadow-sm ring-1 ring-stone-200">
                    <div>
                    <span class="rounded-full bg-orange-100 px-2 py-0.5 text-xs font-medium text-orange-700">
                        {{ $recipe->category_label }}
                    </span>
                        <h2 class="mt-2 text-lg font-semibold">{{ $recipe->title }}</h2>
                        <p class="mt-1 text-sm text-stone-500">
                            @if ($recipe->minutes) ⏱ {{ $recipe->minutes }} min @endif
                            @if ($recipe->minutes && $recipe->difficulty_label) · @endif
                            @if ($recipe->difficulty_label) {{ $recipe->difficulty_label }} @endif
                        </p>
                    </div>

                    <div class="mt-4 flex flex-wrap items-center gap-2">
                        <a href="{{ route('recetas.show', $recipe) }}"
                           class="rounded bg-stone-800 px-3 py-1.5 text-sm text-white hover:bg-stone-700">Ver</a>
                        <a href="{{ route('recetas.edit', $recipe) }}"
                           class="rounded border border-stone-300 px-3 py-1.5 text-sm hover:bg-stone-100">Editar</a>
                        <x-delete-recipe :recipe="$recipe" />
                    </div>
                </article>
            @endforeach
        </div>
    @endif
@endsection
