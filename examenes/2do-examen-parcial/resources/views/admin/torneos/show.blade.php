@extends('layouts.app')
@section('title', 'Inscritos')
@section('content')
    <a href="{{ route('admin.torneos.index') }}" class="text-sm text-slate-500 hover:text-orange-600">← Volver al panel</a>
    <div class="mt-3 flex flex-wrap items-center justify-between gap-3" data-animate="fade-up">
        <div>
            <h1 class="font-display text-4xl font-bold">{{ $torneo->nombre }}</h1>
            <p class="text-sm text-slate-500">{{ $torneo->fecha->translatedFormat('d \d\e F \d\e Y, H:i') }} · {{ $torneo->inscripciones_count }}/{{ $torneo->cupo }} inscritos</p>
        </div>
        <x-badge-estado :torneo="$torneo" />
    </div>

    <div class="card mt-6 overflow-x-auto p-0" data-animate="fade-up">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs uppercase text-slate-500">
            <tr><th class="p-3">Jugador</th><th class="p-3">Correo</th><th class="p-3">Inscrito el</th><th class="p-3 text-right">Acción</th></tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            @forelse ($torneo->inscripciones as $ins)
                <tr>
                    <td class="p-3 font-semibold">{{ $ins->user->name }}</td>
                    <td class="p-3">{{ $ins->user->email }}</td>
                    <td class="p-3">{{ $ins->created_at->format('d/m/Y H:i') }}</td>
                    <td class="p-3 text-right">
                        <x-confirmar-form :action="route('admin.inscripciones.destroy', [$torneo, $ins])" title="¿Dar de baja?"
                                          message="{{ $ins->user->name }} perderá su lugar en el torneo." button="Dar de baja">
                            <x-slot:trigger>Dar de baja</x-slot:trigger>
                        </x-confirmar-form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="p-8 text-center text-slate-500">Este torneo todavía no tiene inscritos.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
