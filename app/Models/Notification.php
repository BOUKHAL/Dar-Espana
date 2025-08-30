<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $table = 'notifications';
    
    protected $fillable = [
        'titre',
        'message',
        'type_destinataire',
        'destinataire_specifique',
        'centre_id',
        'option_id',
        'filiere_id',
        'nombre_destinataires',
        'statut',
        'envoye_par',
        'envoye_le'
    ];

    protected $casts = [
        'envoye_le' => 'datetime',
        'nombre_destinataires' => 'integer'
    ];

    // Types de destinataires
    const TYPE_TOUS = 'tous';
    const TYPE_ETUDIANT_SPECIFIQUE = 'etudiant_specifique';
    const TYPE_CENTRE = 'centre';
    const TYPE_OPTION = 'option';
    const TYPE_FILIERE = 'filiere';

    // Statuts
    const STATUT_BROUILLON = 'brouillon';
    const STATUT_ENVOYE = 'envoye';
    const STATUT_ECHEC = 'echec';

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

    public function expediteur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'envoye_par');
    }

    public static function getTypesDestinataire()
    {
        return [
            self::TYPE_TOUS => 'Tous les étudiants',
            self::TYPE_ETUDIANT_SPECIFIQUE => 'Étudiant spécifique',
            self::TYPE_CENTRE => 'Étudiants d\'un centre',
            self::TYPE_OPTION => 'Étudiants d\'une option',
            self::TYPE_FILIERE => 'Étudiants d\'une filière'
        ];
    }

    public static function getStatuts()
    {
        return [
            self::STATUT_BROUILLON => 'Brouillon',
            self::STATUT_ENVOYE => 'Envoyé',
            self::STATUT_ECHEC => 'Échec'
        ];
    }
}
