<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cours extends Model
{
    protected $fillable = [
        'titre',
        'description',
        'fichier_path',
        'fichier_nom',
        'type_fichier',
        'taille_fichier',
        'matiere_id',
        'niveau_id',
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

    public function niveau(): BelongsTo
    {
        return $this->belongsTo(Niveau::class);
    }
}
