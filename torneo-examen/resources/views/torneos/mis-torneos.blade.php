@extends('layouts.app')
@section('title', 'Mis torneos')
@section('content')
    <h1 class="font-display text-4xl font-bold" data-animate="fade-up">Mis torneos</h1>

    @if ($proximos->isEmpty() && $pasados->isEmpty())
        <div class="card mt-6 py-14 text-center" data-animate="fade-up">
            <p class="text-5xl">🏀</p>
            <p class="mt-3 font-semibold">Aún no te has inscrito a ningún torneo.</p>
            <a href="{{ route('torneos.index') }}" class="btn-primary mt-4">Ver torneos disponibles</a>
        </div>
    @endif

    @if ($proximos->isNotEmpty())
        <h2 class="mb-3 mt-8 font-display text-2xl font-bold" data-animate="fade-up">Próximos</h2>
        <div class="grid gap-5 md:grid-cols-2">
            @foreach ($proximos as $ins)
                @php $t = $ins->torneo; @endphp
                <article class="card" data-animate="fade-up">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase text-orange-600">{{ $t->juego }}</p>
                            <h3 class="font-display text-2xl font-bold">{{ $t->nombre }}</h3>
                        </div>
                        <x-badge-estado :torneo="$t" />
                    </div>
                    <p class="mt-2 text-sm text-slate-500">📅 {{ $t->fecha->translatedFormat('l d \d\e F, H:i') }}</p>
                    <p class="text-xs text-slate-400">Inscrito el {{ $ins->created_at->translatedFormat('d/m/Y') }}</p>
                    <div class="mt-4 flex gap-2">
                        <a href="{{ route('torneos.show', $t) }}" class="btn-ghost">Ver detalle</a>
                        <x-confirmar-form :action="route('inscripciones.destroy', $t)" title="¿Cancelar inscripción?"
                                          message="Liberarás tu plaza en «{{ $t->nombre }}»." button="Sí, cancelar">
                            <x-slot:trigger>Cancelar</x-slot:trigger>
                        </x-confirmar-form>
                    </div>
                </article>
            @endforeach
        </div>
    @endif

    @if ($pasados->isNotEmpty())
        <h2 class="mb-3 mt-10 font-display text-2xl font-bold text-slate-500" data-animate="fade-up">Historial</h2>
        <div class="grid gap-5 md:grid-cols-2">
            @foreach ($pasados as $ins)
                <article class="card opacity-70" data-animate="fade-up">
                    <h3 class="font-display text-xl font-bold">{{ $ins->torneo->nombre }}</h3>
                    <p class="text-sm text-slate-500">{{ $ins->torneo->fecha->translatedFormat('d \d\e F \d\e Y') }} · Finalizado</p>
                </article>
            @endforeach
        </div>
    @endif
@endsection
