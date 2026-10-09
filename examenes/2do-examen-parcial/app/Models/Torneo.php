<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Torneo extends Model
{
    protected $table = 'torneos';
    protected $fillable = ['nombre', 'juego', 'fecha', 'cupo', 'descripcion', 'abierto'];
    protected $casts = ['fecha' => 'datetime', 'abierto' => 'boolean'];

    public function inscripciones(): HasMany
    {
        return $this->hasMany(Inscripcion::class);
    }

    public function totalInscritos(): int
    {
        return $this->inscrpciones_count ?? $this->inscripciones()->count();
    }

    public function plazasLibres(): int
    {
        return max(0, $this->cupo - $this->totalInscritos());
    }

    public function estaLleno(): bool
    {
        return $this->plazasLibres() === 0;
    }

    /* Estados del torneo: Abierto, Cerrado, Lleno y Finalizado */
    public function estado(): string
    {
        if (! $this->abierto) return 'cerrado';
        if ($this->fecha->isPast()) return 'finalizado';
        if ($this->estaLleno()) return 'lleno';

        return 'abierto';
    }

    public function estaDisponible(): bool
    {
        return $this->estado() === 'abierto';
    }

    // Abiertos + fecha futura + cupo libre, ordenado por fecha más próxima
    public function scopeDisponibles(Builder $q): Builder
    {
        return $q->where('abierto', true)
            ->where('fecha', '>', now())
            ->whereRaw('cupo > (select count(*) from inscripciones where inscripciones.torneo_id = torneos.id)')
            ->orderBy('fecha');
    }
}
