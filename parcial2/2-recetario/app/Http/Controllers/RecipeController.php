<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecipeRequest;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));

        $category = $request->query('category');
        if (! is_string($category) || ! isset(Recipe::CATEGORIES[$category])) {
            $category = null;
        }

        $recipes = $request->user()->recipes()
            ->search($search)
            ->ofCategory($category)
            ->orderByDesc('id')
            ->get();

        $total = $request->user()->recipes()->count();

        return view('recipes.index', compact('recipes', 'search', 'category', 'total'));
    }

    public function create()
    {
        return view('recipes.create', ['recipe' => new Recipe()]);
    }

    public function store(RecipeRequest $request)
    {
        $recipe = $request->user()->recipes()->create($request->validated());

        return redirect()->route('recetas.show', $recipe)
            ->with('success', 'Receta creada correctamente.');
    }

    public function show(Request $request, string $id)
    {
        return view('recipes.show', ['recipe' => $this->findOwn($request, $id)]);
    }

    public function edit(Request $request, string $id)
    {
        return view('recipes.edit', ['recipe' => $this->findOwn($request, $id)]);
    }

    public function update(RecipeRequest $request, string $id)
    {
        $recipe = $this->findOwn($request, $id);
        $recipe->update($request->validated());

        return redirect()->route('recetas.show', $recipe)
            ->with('success', 'Receta actualizada correctamente.');
    }

    public function destroy(Request $request, string $id)
    {
        $this->findOwn($request, $id)->delete();

        return redirect()->route('recetas.index')
            ->with('success', 'Receta eliminada correctamente.');
    }

    /** Busca la receta SOLO entre las del usuario autenticado (404 si no es suya). */
    private function findOwn(Request $request, string $id): Recipe
    {
        return $request->user()->recipes()->findOrFail($id);
    }
}
