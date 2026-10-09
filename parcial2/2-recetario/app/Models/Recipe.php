<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recipe extends Model
{
    public const CATEGORIES = [
        'desayuno' => 'Desayuno',
        'almuerzo' => 'Almuerzo',
        'cena'     => 'Cena',
        'postre'   => 'Postre',
        'bebida'   => 'Bebida',
    ];

    public const DIFFICULTIES = [
        'facil'   => 'Fácil',
        'medio'   => 'Medio',
        'dificil' => 'Difícil',
    ];

    protected $fillable = [
        'title', 'category', 'minutes', 'difficulty',
        'ingredients', 'steps', 'personal_note',
    ];

    protected function casts(): array
    {
        return ['minutes' => 'integer'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /* ---------- Scopes ---------- */

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        return $term ? $query->where('title', 'like', '%' . $term . '%') : $query;
    }

    public function scopeOfCategory(Builder $query, ?string $category): Builder
    {
        return $category ? $query->where('category', $category) : $query;
    }

    /* ---------- Accesores ---------- */

    protected function categoryLabel(): Attribute
    {
        return Attribute::get(fn () => self::CATEGORIES[$this->category] ?? ucfirst((string) $this->category));
    }

    protected function difficultyLabel(): Attribute
    {
        return Attribute::get(fn () => self::DIFFICULTIES[$this->difficulty] ?? null);
    }

    protected function ingredientsList(): Attribute
    {
        return Attribute::get(fn () => self::toLines($this->ingredients));
    }

    protected function stepsList(): Attribute
    {
        return Attribute::get(fn () => self::toLines($this->steps));
    }

    private static function toLines(?string $text): array
    {
        $lines = preg_split('/\R/', (string) $text);

        return array_values(array_filter(array_map('trim', $lines), fn ($l) => $l !== ''));
    }
}
