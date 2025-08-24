<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Option extends Model
{
    protected $fillable = [
        'nom',
        'centre_id',
        'actif'
    ];

    protected $casts = [
        'actif' => 'boolean'
    ];

    public function centre(): BelongsTo
    {
        return $this->belongsTo(Centre::class);
    }

    public function planifications(): HasMany
    {
        return $this->hasMany(Planification::class);
    }
}
