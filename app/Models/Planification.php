<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Planification extends Model
{
    protected $fillable = [
        'centre_id',
        'option_id',
        'titre',
        'fichier_path',
        'type_fichier',
        'semaine_debut',
        'semaine_fin',
        'description',
        'actif'
    ];

    protected $casts = [
        'semaine_debut' => 'date',
        'semaine_fin' => 'date',
        'actif' => 'boolean'
    ];

    public function centre(): BelongsTo
    {
        return $this->belongsTo(Centre::class);
    }

    public function option(): BelongsTo
    {
        return $this->belongsTo(Option::class);
    }
}
