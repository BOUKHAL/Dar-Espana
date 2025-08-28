<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Matiere extends Model
{
    protected $fillable = [
        'nom',
        'description',
        'a_niveaux',
        'actif'
    ];

    protected $casts = [
        'a_niveaux' => 'boolean',
        'actif' => 'boolean'
    ];

    public function niveaux(): HasMany
    {
        return $this->hasMany(Niveau::class);
    }

    public function cours(): HasMany
    {
        return $this->hasMany(Cours::class);
    }
}
