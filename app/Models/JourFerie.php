<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

class JourFerie extends Model
{
    protected $fillable = [
        'nom',
        'date',
        'description',
        'type',
        'recurrent',
        'annee',
        'couleur',
        'actif'
    ];

    protected $casts = [
        'date' => 'datetime',
        'recurrent' => 'boolean',
        'actif' => 'boolean'
    ];

    // Mutateur pour s'assurer que la couleur est au bon format
    protected function couleur(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => str_starts_with($value, '#') ? $value : '#' . $value,
        );
    }

    // Scope pour les jours fériés actifs
    public function scopeActif($query)
    {
        return $query->where('actif', true);
    }

    // Scope pour une année donnée
    public function scopePourAnnee($query, $annee)
    {
        return $query->where(function ($q) use ($annee) {
            $q->where('recurrent', true)
              ->orWhere('annee', $annee);
        });
    }

    // Méthode pour obtenir la date formatée
    public function getDateFormateeAttribute()
    {
        return $this->date->format('d/m/Y');
    }

    // Méthode pour vérifier si le jour férié tombe un week-end
    public function estWeekEnd()
    {
        return in_array($this->date->dayOfWeek, [Carbon::SATURDAY, Carbon::SUNDAY]);
    }

    // Méthode pour obtenir le nom du jour de la semaine
    public function getJourSemaineAttribute()
    {
        $jours = [
            'Sunday' => 'Dimanche',
            'Monday' => 'Lundi',
            'Tuesday' => 'Mardi',
            'Wednesday' => 'Mercredi',
            'Thursday' => 'Jeudi',
            'Friday' => 'Vendredi',
            'Saturday' => 'Samedi'
        ];
        
        return $jours[$this->date->format('l')] ?? $this->date->format('l');
    }

    // Méthode pour calculer le nombre de jours restants
    public function getJoursRestantsAttribute()
    {
        return now()->startOfDay()->diffInDays($this->date->startOfDay());
    }
}
