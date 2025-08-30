<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Centre extends Model
{
    protected $fillable = [
        'nom',
        'adresse',
        'actif'
    ];

    protected $casts = [
        'actif' => 'boolean'
    ];

    public function options(): HasMany
    {
        return $this->hasMany(Option::class);
    }

    public function planifications(): HasMany
    {
        return $this->hasMany(Planification::class);
    }

    public function etudiants(): HasMany
    {
        return $this->hasMany(Etudiant::class);
    }
}
