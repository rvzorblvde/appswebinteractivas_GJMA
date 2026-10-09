<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TorneoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool { return true; }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */

    public function rules(): array
    {
        $minCupo = 2;
        if ($torneo = $this->route('torneo')) {
            // No se puede bajar el cupo por debajo de los ya inscritos
            $minCupo = max(2, $torneo->inscripciones()->count());
        }

        return [
            'nombre' => ['required', 'string', 'max:100'],
            'juego' => ['required', 'string', 'max:100'],
            'fecha' => ['required', 'date', 'after:now'],
            'cupo' => ['required', 'integer', 'min:' . $minCupo, 'max:100'],
            'descripcion' => ['nullable', 'string', 'max:1000'],
            'abierto' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del torneo es obligatorio.',
            'nombre.max' => 'El nombre no puede pasar de 100 caracteres.',
            'juego.required' => 'Indica el juego o deporte.',
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'La fecha no es válida.',
            'fecha.after' => 'La fecha debe ser futura.',
            'cupo.required' => 'El cupo es obligatorio.',
            'cupo.integer' => 'El cupo debe ser un número entero.',
            'cupo.min' => 'El cupo mínimo es :min (no puede ser menor a 2 ni a los jugadores ya inscritos).',
            'cupo.max' => 'El cupo máximo es 100.',
            'descripcion.max' => 'La descripción no puede pasar de 1000 caracteres.',
        ];
    }
}
