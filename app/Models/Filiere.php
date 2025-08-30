<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Filiere extends Model
{
    protected $table = 'filieres';
    
    protected $fillable = [
        'nom',
        'description',
        'actif'
    ];

    protected $casts = [
        'actif' => 'boolean'
    ];

    public function etudiants(): HasMany
    {
        return $this->hasMany(Etudiant::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }
}
