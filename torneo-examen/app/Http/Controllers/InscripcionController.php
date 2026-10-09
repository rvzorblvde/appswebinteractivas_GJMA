<?php

namespace App\Http\Controllers;

use App\Models\Inscripcion;
use App\Models\Torneo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InscripcionController extends Controller
{
    public function index()
    {
        $inscripciones = auth()->user()->inscripciones()
            ->with(['torneo' => fn ($q) => $q->withCount('inscripciones')])
            ->get()
            ->sortBy('torneo.fecha');

        [$proximos, $pasados] = $inscripciones->partition(fn ($i) => $i->torneo->fecha->isFuture());

        return view('torneos.mis-torneos', compact('proximos', 'pasados'));
    }

    public function store(Torneo $torneo)
    {
        $userId = auth()->id();

        return DB::transaction(function () use ($torneo, $userId) {
            $torneo->loadCount('inscripciones');

            if (! $torneo->abierto) {
                return back()->with('error', 'Este torneo está cerrado a inscripciones.');
            }
            if ($torneo->fecha->isPast()) {
                return back()->with('error', 'Este torneo ya se realizó.');
            }
            if ($torneo->estaLleno()) {
                return back()->with('error', 'El torneo está lleno, no hay plazas disponibles.');
            }
            if ($torneo->inscripciones()->where('user_id', $userId)->exists()) {
                return back()->with('error', 'Ya estás inscrito en este torneo.');
            }

            Inscripcion::create(['user_id' => $userId, 'torneo_id' => $torneo->id]);

            return back()->with('success', '¡Listo! Quedaste inscrito en "' . $torneo->nombre . '".');
        });
    }

    public function destroy(Torneo $torneo)
    {
        if ($torneo->fecha->isPast()) {
            return back()->with('error', 'El torneo ya se realizó, no puedes cancelar tu inscripción.');
        }

        $borrado = Inscripcion::where('user_id', auth()->id())
            ->where('torneo_id', $torneo->id)->delete();

        return $borrado
            ? back()->with('success', 'Inscripción cancelada. La plaza quedó libre.')
            : back()->with('error', 'No estabas inscrito en este torneo.');
    }
}
