<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inscripcion;
use App\Models\Torneo;

class InscripcionController extends Controller
{
    public function destroy(Torneo $torneo, Inscripcion $inscripcion)
    {
        abort_if($inscripcion->torneo_id !== $torneo->id, 404);

        $inscripcion->delete();

        return back()->with('success', 'El jugador fue dado de baja del torneo.');
    }
}
