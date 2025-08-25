<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JourFerie;

class JoursFeriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $joursFeries = [
            // Jours fériés fixes
            [
                'nom' => 'Jour de l\'An',
                'date' => '2025-01-01',
                'description' => 'Premier jour de l\'année civile',
                'type' => 'fixe',
                'recurrent' => true,
                'couleur' => '#2563eb'
            ],
            [
                'nom' => 'Fête du Manifeste de l\'Indépendance',
                'date' => '2025-01-11',
                'description' => 'Commémoration du manifeste de l\'indépendance',
                'type' => 'fixe',
                'recurrent' => true,
                'couleur' => '#dc2626'
            ],
            [
                'nom' => 'Fête du Travail',
                'date' => '2025-05-01',
                'description' => 'Journée internationale des travailleurs',
                'type' => 'fixe',
                'recurrent' => true,
                'couleur' => '#16a34a'
            ],
            [
                'nom' => 'Fête du Trône',
                'date' => '2025-07-30',
                'description' => 'Fête nationale du Royaume du Maroc',
                'type' => 'fixe',
                'recurrent' => true,
                'couleur' => '#dc2626'
            ],
            [
                'nom' => 'Révolution du Roi et du Peuple',
                'date' => '2025-08-20',
                'description' => 'Commémoration de la révolution',
                'type' => 'fixe',
                'recurrent' => true,
                'couleur' => '#dc2626'
            ],
            [
                'nom' => 'Fête de la Jeunesse',
                'date' => '2025-08-21',
                'description' => 'Anniversaire du Roi Mohammed VI',
                'type' => 'fixe',
                'recurrent' => true,
                'couleur' => '#ca8a04'
            ],
            [
                'nom' => 'Marche Verte',
                'date' => '2025-11-06',
                'description' => 'Commémoration de la Marche Verte',
                'type' => 'fixe',
                'recurrent' => true,
                'couleur' => '#16a34a'
            ],
            [
                'nom' => 'Fête de l\'Indépendance',
                'date' => '2025-11-18',
                'description' => 'Indépendance du Maroc',
                'type' => 'fixe',
                'recurrent' => true,
                'couleur' => '#dc2626'
            ],
            
            // Jours fériés mobiles (dates approximatives pour 2025)
            [
                'nom' => 'Aïd al-Fitr',
                'date' => '2025-03-31',
                'description' => 'Fête de la rupture du jeûne (fin du Ramadan)',
                'type' => 'mobile',
                'recurrent' => false,
                'annee' => 2025,
                'couleur' => '#9333ea'
            ],
            [
                'nom' => 'Aïd al-Adha',
                'date' => '2025-06-07',
                'description' => 'Fête du sacrifice',
                'type' => 'mobile',
                'recurrent' => false,
                'annee' => 2025,
                'couleur' => '#9333ea'
            ],
            [
                'nom' => 'Nouvel An Hégire',
                'date' => '2025-06-27',
                'description' => 'Premier jour de l\'année islamique',
                'type' => 'mobile',
                'recurrent' => false,
                'annee' => 2025,
                'couleur' => '#9333ea'
            ],
            [
                'nom' => 'Mawlid (Naissance du Prophète)',
                'date' => '2025-09-05',
                'description' => 'Anniversaire de la naissance du Prophète Mohammed',
                'type' => 'mobile',
                'recurrent' => false,
                'annee' => 2025,
                'couleur' => '#9333ea'
            ]
        ];

        foreach ($joursFeries as $jourFerie) {
            JourFerie::create($jourFerie);
        }
    }
}
