<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inscripcion extends Model
{
    protected $table = 'inscripciones';
    protected $fillable = ['user_id', 'torneo_id'];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function torneo(): BelongsTo {
        return $this->belongsTo(Torneo::class);
    }
}
