@extends('layouts.app')
@section('title', 'Torneos disponibles')
@section('content')
    <section class="mb-8 flex items-center justify-between overflow-hidden rounded-3xl bg-gradient-to-r from-orange-500 to-amber-400 p-8 text-white" data-animate="fade-up">
        <div>
            <h1 class="font-display text-5xl font-bold">Torneos de básquetbol</h1>
            <p class="mt-1 text-orange-50">Elige tu torneo, inscríbete y salta a la cancha.</p>
        </div>
        <span id="balon" class="hidden text-7xl sm:block">🏀</span>
    </section>

    <form method="GET" class="mb-6 flex gap-2" data-animate="fade-up">
        <input name="q" value="{{ $busqueda }}" placeholder="Buscar por nombre o modalidad..." class="input max-w-md">
        <button class="btn-primary">Buscar</button>
        @if ($busqueda) <a href="{{ route('torneos.index') }}" class="btn-ghost">Limpiar</a> @endif
    </form>

    @if ($torneos->isEmpty())
        <div class="card py-16 text-center" data-animate="fade-up">
            <p class="text-5xl">🏟️</p>
            <p class="mt-3 text-lg font-semibold">No hay torneos disponibles por el momento.</p>
            <p class="text-sm text-slate-500">Vuelve pronto, el administrador publicará nuevos torneos.</p>
        </div>
    @else
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($torneos as $t)
                @php $pct = round($t->inscripciones_count / $t->cupo * 100); @endphp
                <article data-animate="fade-up" class="card flex flex-col transition hover:-translate-y-1 hover:shadow-lg">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-orange-600">{{ $t->juego }}</p>
                            <h2 class="font-display text-2xl font-bold leading-tight">{{ $t->nombre }}</h2>
                        </div>
                        <x-badge-estado :torneo="$t" />
                    </div>
                    <p class="mt-3 text-sm text-slate-500">📅 {{ $t->fecha->translatedFormat('l d \d\e F, H:i') }}</p>

                    <div class="mt-4">
                        <div class="mb-1 flex justify-between text-xs text-slate-500">
                            <span>{{ $t->inscripciones_count }}/{{ $t->cupo }} inscritos</span>
                            <span>{{ $t->plazasLibres() }} plazas libres</span>
                        </div>
                        <div class="h-2 overflow-hidden rounded-full bg-slate-100">
                            <div data-progress="{{ $pct }}" class="h-full rounded-full bg-orange-500"></div>
                        </div>
                    </div>

                    <div class="mt-auto flex items-center justify-between pt-5">
                        @if (in_array($t->id, $inscritos))
                            <span class="text-sm font-semibold text-emerald-600">✔ Inscrito</span>
                        @else <span></span> @endif
                        <a href="{{ route('torneos.show', $t) }}" class="btn-primary">Ver detalle</a>
                    </div>
                </article>
            @endforeach
        </div>
        <div class="mt-8">{{ $torneos->links() }}</div>
    @endif
@endsection
