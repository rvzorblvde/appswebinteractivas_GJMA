<?php

namespace App\Http\Requests;

use App\Models\Recipe;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RecipeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Las rutas ya están protegidas con el middleware "auth"
    }

    public function rules(): array
    {
        return [
            'title'         => ['required', 'string', 'max:150'],
            'category'      => ['required', Rule::in(array_keys(Recipe::CATEGORIES))],
            'minutes'       => ['nullable', 'integer', 'min:1', 'max:100000'],
            'difficulty'    => ['nullable', Rule::in(array_keys(Recipe::DIFFICULTIES))],
            'ingredients'   => ['nullable', 'string', 'max:5000'],
            'steps'         => ['nullable', 'string', 'max:10000'],
            'personal_note' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'    => 'El título es obligatorio.',
            'title.max'         => 'El título no puede superar los 150 caracteres.',
            'category.required' => 'Debes seleccionar una categoría.',
            'category.in'       => 'La categoría seleccionada no es válida.',
            'minutes.integer'   => 'El tiempo debe ser un número entero de minutos.',
            'minutes.min'       => 'El tiempo debe ser mayor a 0 minutos.',
            'minutes.max'       => 'El tiempo es demasiado grande.',
            'difficulty.in'     => 'La dificultad solo puede ser fácil, medio o difícil.',
            'ingredients.max'   => 'Los ingredientes no pueden superar los 5000 caracteres.',
            'steps.max'         => 'Los pasos no pueden superar los 10000 caracteres.',
            'personal_note.max' => 'La nota personal no puede superar los 1000 caracteres.',
        ];
    }
}
