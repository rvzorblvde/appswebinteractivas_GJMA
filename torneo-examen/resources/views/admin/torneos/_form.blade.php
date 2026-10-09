@php $t = $torneo ?? null; @endphp
<form method="POST" action="{{ $action }}" class="space-y-5" novalidate>
    @csrf
    @if ($t) @method('PUT') @endif

    <div class="grid gap-5 md:grid-cols-2">
        <x-campo name="nombre" label="Nombre del torneo *" :value="$t->nombre ?? null" />
        <x-campo name="juego" label="Juego o deporte *" :value="$t->juego ?? 'Básquetbol'" list="juegos" />
        <x-campo name="fecha" label="Fecha y hora *" type="datetime-local" :value="$t?->fecha?->format('Y-m-d\TH:i')" />
        <x-campo name="cupo" label="Cupo (2 a 100) *" type="number" min="2" max="100" :value="$t->cupo ?? 16" />
    </div>
    <datalist id="juegos">
        <option value="Básquetbol 5x5"><option value="Básquetbol 3x3">
        <option value="Concurso de triples"><option value="Concurso de clavadas">
    </datalist>
    @if ($t)
        <p class="text-xs text-slate-500">Inscritos actualmente: {{ $t->inscripciones_count }}. El cupo no puede ser menor a esa cifra.</p>
    @endif

    <div>
        <label for="descripcion" class="label">Descripción (opcional)</label>
        <textarea id="descripcion" name="descripcion" rows="4" class="input">{{ old('descripcion', $t->descripcion ?? '') }}</textarea>
        @error('descripcion') <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
    </div>

    <label class="flex items-center gap-2 text-sm">
        <input type="hidden" name="abierto" value="0">
        <input type="checkbox" name="abierto" value="1" class="rounded" @checked(old('abierto', $t->abierto ?? true))>
        Torneo abierto a inscripciones
    </label>

    <div class="flex gap-2">
        <button class="btn-primary">{{ $t ? 'Guardar cambios' : 'Crear torneo' }}</button>
        <a href="{{ route('admin.torneos.index') }}" class="btn-ghost">Cancelar</a>
    </div>
</form>
