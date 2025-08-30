<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Etudiant extends Model
{
    protected $table = 'etudiants';
    
    protected $fillable = [
        'nom',
        'prenom',
        'telephone_etudiant',
        'telephone_parents',
        'email',
        'type_baccalaureat',
        'centre_id',
        'option_id',
        'filiere_id'
    ];

    protected $casts = [
        'type_baccalaureat' => 'string'
    ];

    public function centre(): BelongsTo
    {
        return $this->belongsTo(Centre::class);
    }

    public function option(): BelongsTo
    {
        return $this->belongsTo(Option::class);
    }

    public function filiere(): BelongsTo
    {
        return $this->belongsTo(Filiere::class);
    }

    // Constantes pour les types de baccalauréat
    const TYPE_BAC_MAROCAIN = 'bac_marocain';
    const TYPE_BAC_FRANCAIS = 'bac_francais';

    public static function getTypesBaccalaureat()
    {
        return [
            self::TYPE_BAC_MAROCAIN => 'Baccalauréat Marocain',
            self::TYPE_BAC_FRANCAIS => 'Baccalauréat Français'
        ];
    }

    public function getFullNameAttribute()
    {
        return $this->prenom . ' ' . $this->nom;
    }
}
