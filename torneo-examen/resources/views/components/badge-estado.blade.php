@props(['torneo'])
@php
    $mapa = [
        'abierto'    => ['Abierto', 'bg-emerald-100 text-emerald-700'],
        'lleno'      => ['Lleno', 'bg-amber-100 text-amber-700'],
        'cerrado'    => ['Cerrado', 'bg-slate-200 text-slate-700'],
        'finalizado' => ['Finalizado', 'bg-rose-100 text-rose-700'],
    ];
    [$texto, $clases] = $mapa[$torneo->estado()];
@endphp
<span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $clases }}">{{ $texto }}</span>
