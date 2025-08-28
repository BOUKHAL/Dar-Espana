<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Niveau extends Model
{
    protected $fillable = [
        'nom',
        'matiere_id',
        'ordre',
        'actif'
    ];

    protected $casts = [
        'actif' => 'boolean'
    ];

    public function matiere(): BelongsTo
    {
        return $this->belongsTo(Matiere::class);
    }

    public function cours(): HasMany
    {
        return $this->hasMany(Cours::class);
    }
}
