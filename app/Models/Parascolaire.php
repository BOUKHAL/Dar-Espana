<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parascolaire extends Model
{
    protected $fillable = [
        'nom_evenement',
        'jour_evenement',
        'lieu',
        'description'
    ];

    protected $casts = [
        'jour_evenement' => 'date'
    ];
}
