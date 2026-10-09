<?php

namespace App\Http\Controllers;

use App\Models\Torneo;
use Illuminate\Http\Request;
use Illuminate\Database\Query\Builder;

class TorneoController extends Controller
{
    public function index(Request $request)
    {
        $busqueda = $request->query('q');

        $torneos = Torneo::disponibles()
            ->withCount('inscripciones')
            ->when($busqueda, fn ($q) => $q->where(fn ($w) => $w
                ->where('nombre', 'like', "%{$busqueda}%")
                ->orWhere('juego', 'like', "%{$busqueda}%")))
            ->paginate(9)
            ->withQueryString();

        $inscritos = auth()->check()
            ? auth()->user()->inscripciones()->pluck('torneo_id')->all()
            : [];

        return view('torneos.index', compact('torneos', 'inscritos', 'busqueda'));
    }

    public function show(Torneo $torneo)
    {
        $torneo->loadCount('inscripciones')->load('inscripciones.user');
        $inscrito = auth()->check() && $torneo->inscripciones->contains('user_id', auth()->id());

        return view('torneos.show', compact('torneo', 'inscrito'));
    }
}
