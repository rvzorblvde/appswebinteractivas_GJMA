@php
    $base = 'mt-1 w-full rounded border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400';
    $ok   = 'border-stone-300';
    $bad  = 'border-red-500';
@endphp

<form method="POST" action="{{ $action }}" novalidate
      class="space-y-5 rounded-lg bg-white p-6 shadow-sm ring-1 ring-stone-200">
    @csrf
    @if ($method !== 'POST') @method($method) @endif

    {{-- Título --}}
    <div>
        <label for="title" class="block text-sm font-medium">Título <span class="text-red-600">*</span></label>
        <input id="title" type="text" name="title" value="{{ old('title', $recipe->title) }}"
               class="{{ $base }} {{ $errors->has('title') ? $bad : $ok }}">
        @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="grid gap-5 sm:grid-cols-3">
        {{-- Categoría --}}
        <div>
            <label for="category" class="block text-sm font-medium">Categoría <span class="text-red-600">*</span></label>
            <select id="category" name="category" class="{{ $base }} {{ $errors->has('category') ? $bad : $ok }}">
                <option value="">Selecciona…</option>
                @foreach (\App\Models\Recipe::CATEGORIES as $value => $label)
                    <option value="{{ $value }}" @selected(old('category', $recipe->category) === $value)>{{ $label }}</option>
                @endforeach
            </select>
            @error('category') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Tiempo --}}
        <div>
            <label for="minutes" class="block text-sm font-medium">Tiempo (minutos)</label>
            <input id="minutes" type="number" name="minutes" min="1" value="{{ old('minutes', $recipe->minutes) }}"
                   class="{{ $base }} {{ $errors->has('minutes') ? $bad : $ok }}">
            @error('minutes') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Dificultad --}}
        <div>
            <label for="difficulty" class="block text-sm font-medium">Dificultad</label>
            <select id="difficulty" name="difficulty" class="{{ $base }} {{ $errors->has('difficulty') ? $bad : $ok }}">
                <option value="">Sin especificar</option>
                @foreach (\App\Models\Recipe::DIFFICULTIES as $value => $label)
                    <option value="{{ $value }}" @selected(old('difficulty', $recipe->difficulty) === $value)>{{ $label }}</option>
                @endforeach
            </select>
            @error('difficulty') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Ingredientes (contador con Alpine) --}}
    <div x-data="{ texto: @js(old('ingredients', $recipe->ingredients) ?? '') }">
        <label for="ingredients" class="block text-sm font-medium">
            Ingredientes <span class="text-stone-400">(uno por línea)</span>
        </label>
        <textarea id="ingredients" name="ingredients" rows="6" x-model="texto"
                  class="{{ $base }} {{ $errors->has('ingredients') ? $bad : $ok }}">{{ old('ingredients', $recipe->ingredients) }}</textarea>
        <p class="mt-1 text-xs text-stone-500"
           x-text="texto.split('\n').filter(l => l.trim() !== '').length + ' ingrediente(s)'"></p>
        @error('ingredients') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    {{-- Pasos --}}
    <div x-data="{ texto: @js(old('steps', $recipe->steps) ?? '') }">
        <label for="steps" class="block text-sm font-medium">
            Pasos de preparación <span class="text-stone-400">(uno por línea)</span>
        </label>
        <textarea id="steps" name="steps" rows="8" x-model="texto"
                  class="{{ $base }} {{ $errors->has('steps') ? $bad : $ok }}">{{ old('steps', $recipe->steps) }}</textarea>
        <p class="mt-1 text-xs text-stone-500"
           x-text="texto.split('\n').filter(l => l.trim() !== '').length + ' paso(s)'"></p>
        @error('steps') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    {{-- Nota personal --}}
    <div>
        <label for="personal_note" class="block text-sm font-medium">
            Nota personal <span class="text-stone-400">(opcional)</span>
        </label>
        <textarea id="personal_note" name="personal_note" rows="3"
                  class="{{ $base }} {{ $errors->has('personal_note') ? $bad : $ok }}">{{ old('personal_note', $recipe->personal_note) }}</textarea>
        @error('personal_note') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="flex justify-end gap-2">
        <a href="{{ route('recetas.index') }}" class="rounded border border-stone-300 px-4 py-2 hover:bg-stone-100">Cancelar</a>
        <button type="submit" class="rounded bg-orange-600 px-4 py-2 font-medium text-white hover:bg-orange-700">
            {{ $submit }}
        </button>
    </div>
</form>
