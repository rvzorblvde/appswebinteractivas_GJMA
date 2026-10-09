@extends('layouts.app')
@section('title', 'Panel de torneos')
@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3" data-animate="fade-up">
        <h1 class="font-display text-4xl font-bold">Panel de torneos</h1>
        <a href="{{ route('admin.torneos.create') }}" class="btn-primary">+ Nuevo torneo</a>
    </div>

    <form method="GET" class="my-5 flex gap-2" data-animate="fade-up">
        <input name="q" value="{{ $busqueda }}" placeholder="Buscar torneo..." class="input max-w-sm">
        <button class="btn-ghost">Buscar</button>
    </form>

    <div class="card overflow-x-auto p-0" data-animate="fade-up">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs uppercase text-slate-500">
            <tr><th class="p-3">Torneo</th><th class="p-3">Fecha</th><th class="p-3">Inscritos</th><th class="p-3">Estado</th><th class="p-3 text-right">Acciones</th></tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            @forelse ($torneos as $t)
                <tr>
                    <td class="p-3"><p class="font-semibold">{{ $t->nombre }}</p><p class="text-xs text-slate-500">{{ $t->juego }}</p></td>
                    <td class="p-3 whitespace-nowrap">{{ $t->fecha->format('d/m/Y H:i') }}</td>
                    <td class="p-3">{{ $t->inscripciones_count }}/{{ $t->cupo }}</td>
                    <td class="p-3"><x-badge-estado :torneo="$t" /></td>
                    <td class="p-3">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.torneos.show', $t) }}" class="btn-ghost">Inscritos</a>
                            <a href="{{ route('admin.torneos.edit', $t) }}" class="btn-ghost">Editar</a>
                            <x-confirmar-form :action="route('admin.torneos.destroy', $t)" title="¿Eliminar torneo?"
                                              message="Se eliminará «{{ $t->nombre }}» y todas sus inscripciones." button="Eliminar">
                                <x-slot:trigger>Eliminar</x-slot:trigger>
                            </x-confirmar-form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="p-8 text-center text-slate-500">No hay torneos registrados.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $torneos->links() }}</div>
@endsection
