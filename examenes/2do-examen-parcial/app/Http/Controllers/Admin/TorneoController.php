<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TorneoRequest;
use App\Models\Torneo;
use Illuminate\Http\Request;

class TorneoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $busqueda = $request->query('q');

        $torneos = Torneo::withCount('inscripciones')
            ->when($busqueda, fn ($q) => $q->where(fn ($w) => $w
                ->where('nombre', 'like', "%{$busqueda}%")
                ->orWhere('juego', 'like', "%{$busqueda}%")))
            ->orderByDesc('fecha')
            ->paginate(10)->withQueryString();

        return view('admin.torneos.index', compact('torneos', 'busqueda'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create() { return view('admin.torneos.create'); }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TorneoRequest $request)
    {
        Torneo::create($request->validated());
        return redirect()->route('admin.torneos.index')->with('success', 'Torneo creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Torneo $torneo)
    {
        $torneo->loadCount('inscripciones')->load('inscripciones.user');
        return view('admin.torneos.show', compact('torneo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Torneo $torneo)
    {
        $torneo->loadCount('inscripciones');
        return view('admin.torneos.edit', compact('torneo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TorneoRequest $request, Torneo $torneo)
    {
        $torneo->update($request->validated());
        return redirect()->route('admin.torneos.index')->with('success', 'Torneo actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Torneo $torneo)
    {
        $torneo->delete(); // las inscripciones se borran en cascada
        return redirect()->route('admin.torneos.index')->with('success', 'Torneo eliminado junto con sus inscripciones.');
    }
}
