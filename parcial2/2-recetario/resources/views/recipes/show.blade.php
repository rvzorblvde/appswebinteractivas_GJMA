@extends('layouts.app')
@section('title', $recipe->title)

@section('content')
    <a href="{{ route('recetas.index') }}" class="text-sm text-stone-500 hover:underline">← Volver al listado</a>

    <article class="mt-3 rounded-lg bg-white p-6 shadow-sm ring-1 ring-stone-200">
        <div class="flex flex-wrap items-start justify-between gap-3">
            <div>
            <span class="rounded-full bg-orange-100 px-2 py-0.5 text-xs font-medium text-orange-700">
                {{ $recipe->category_label }}
            </span>
                <h1 class="mt-2 text-3xl font-bold">{{ $recipe->title }}</h1>
                <p class="mt-1 text-sm text-stone-500">
                    @if ($recipe->minutes) ⏱ {{ $recipe->minutes }} minutos @endif
                    @if ($recipe->minutes && $recipe->difficulty_label) · @endif
                    @if ($recipe->difficulty_label) Dificultad: {{ $recipe->difficulty_label }} @endif
                </p>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('recetas.edit', $recipe) }}"
                   class="rounded border border-stone-300 px-3 py-1.5 text-sm hover:bg-stone-100">Editar</a>
                <x-delete-recipe :recipe="$recipe" />
            </div>
        </div>

        <div class="mt-6 grid gap-8 md:grid-cols-2">
            <section>
                <h2 class="mb-2 text-lg font-semibold">Ingredientes</h2>
                @if (count($recipe->ingredients_list))
                    <ul class="list-disc space-y-1 pl-5">
                        @foreach ($recipe->ingredients_list as $item) <li>{{ $item }}</li> @endforeach
                    </ul>
                @else
                    <p class="text-sm text-stone-500">Sin ingredientes registrados.</p>
                @endif
            </section>

            <section>
                <h2 class="mb-2 text-lg font-semibold">Preparación</h2>
                @if (count($recipe->steps_list))
                    <ol class="list-decimal space-y-2 pl-5">
                        @foreach ($recipe->steps_list as $step) <li>{{ $step }}</li> @endforeach
                    </ol>
                @else
                    <p class="text-sm text-stone-500">Sin pasos registrados.</p>
                @endif
            </section>
        </div>

        @if ($recipe->personal_note)
            <div class="mt-6 rounded border border-yellow-200 bg-yellow-50 p-4 text-sm text-yellow-900">
                <strong>Nota personal:</strong> {{ $recipe->personal_note }}
            </div>
        @endif

        <p class="mt-6 text-xs text-stone-400">Creada el {{ $recipe->created_at->format('d/m/Y') }}</p>
    </article>
@endsection
