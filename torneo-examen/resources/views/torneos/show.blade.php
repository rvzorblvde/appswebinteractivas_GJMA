@extends('layouts.app')
@section('title', $torneo->nombre)
@section('content')
    @php $estado = $torneo->estado(); $pct = round($torneo->inscripciones_count / $torneo->cupo * 100); @endphp

    <a href="{{ route('torneos.index') }}" class="text-sm text-slate-500 hover:text-orange-600">← Volver a torneos</a>

    <div class="mt-4 grid gap-6 lg:grid-cols-3">
        <section class="card lg:col-span-2" data-animate="fade-up">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-orange-600">{{ $torneo->juego }}</p>
                    <h1 class="font-display text-4xl font-bold">{{ $torneo->nombre }}</h1>
                </div>
                <x-badge-estado :torneo="$torneo" />
            </div>
            <p class="mt-3 text-slate-500">📅 {{ $torneo->fecha->translatedFormat('l d \d\e F \d\e Y, H:i') }}</p>
            <p class="mt-4 whitespace-pre-line text-slate-700">{{ $torneo->descripcion ?: 'Sin descripción.' }}</p>

            <div class="mt-6 grid grid-cols-3 gap-3 text-center">
                <div class="rounded-xl bg-slate-50 p-3"><p class="font-display text-3xl font-bold" data-count="{{ $torneo->cupo }}">0</p><p class="text-xs text-slate-500">Cupo</p></div>
                <div class="rounded-xl bg-slate-50 p-3"><p class="font-display text-3xl font-bold" data-count="{{ $torneo->inscripciones_count }}">0</p><p class="text-xs text-slate-500">Inscritos</p></div>
                <div class="rounded-xl bg-slate-50 p-3"><p class="font-display text-3xl font-bold" data-count="{{ $torneo->plazasLibres() }}">0</p><p class="text-xs text-slate-500">Libres</p></div>
            </div>
            <div class="mt-4 h-2 overflow-hidden rounded-full bg-slate-100">
                <div data-progress="{{ $pct }}" class="h-full rounded-full bg-orange-500"></div>
            </div>

            <div class="mt-6">
                @guest
                    <a href="{{ route('login') }}" class="btn-primary">Inicia sesión para inscribirte</a>
                @else
                    @if (auth()->user()->esAdmin())
                        <p class="rounded-xl bg-slate-100 p-3 text-sm text-slate-600">Eres administrador: gestiona este torneo desde el
                            <a class="font-semibold text-orange-600" href="{{ route('admin.torneos.show', $torneo) }}">panel</a>.</p>
                    @elseif ($inscrito)
                        <p class="mb-3 text-sm font-semibold text-emerald-600">✔ Ya estás inscrito en este torneo.</p>
                        @if ($torneo->fecha->isFuture())
                            <x-confirmar-form :action="route('inscripciones.destroy', $torneo)" title="¿Cancelar inscripción?"
                                              message="Perderás tu lugar y la plaza quedará libre." button="Sí, cancelar">
                                <x-slot:trigger>Cancelar inscripción</x-slot:trigger>
                            </x-confirmar-form>
                        @endif
                    @elseif ($estado === 'abierto')
                        <form method="POST" action="{{ route('inscripciones.store', $torneo) }}">
                            @csrf
                            <button class="btn-primary px-6 py-3 text-base">🏀 Inscribirme</button>
                        </form>
                    @else
                        <p class="rounded-xl bg-amber-50 p-3 text-sm text-amber-800 ring-1 ring-amber-200">
                            @switch($estado)
                                @case('lleno') Este torneo está lleno. @break
                                @case('cerrado') Este torneo está cerrado a inscripciones. @break
                                @default Este torneo ya finalizó.
                            @endswitch
                        </p>
                    @endif
                @endguest
            </div>
        </section>

        <aside class="card" data-animate="fade-up">
            <h2 class="font-display text-2xl font-bold">Participantes ({{ $torneo->inscripciones_count }})</h2>
            @forelse ($torneo->inscripciones->sortBy('created_at') as $ins)
                <div class="mt-3 flex items-center gap-3">
                    <span class="flex h-9 w-9 items-center justify-center rounded-full bg-orange-100 text-sm font-bold text-orange-700">{{ mb_strtoupper(mb_substr($ins->user->name, 0, 1)) }}</span>
                    <span class="text-sm">{{ $ins->user->name }}</span>
                </div>
            @empty
                <p class="mt-3 text-sm text-slate-500">Aún no hay inscritos. ¡Sé el primero!</p>
            @endforelse
        </aside>
    </div>
@endsection
