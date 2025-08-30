<?php

namespace Database\Seeders;

use App\Models\Centre;
use App\Models\Option;
use Illuminate\Database\Seeder;

class CentreOptionSeeder extends Seeder
{
    public function run()
    {
        // Créer des centres
        $centres = [
            [
                'nom' => 'Centre Rabat',
                'adresse' => 'Avenue Mohammed V, Rabat',
                'actif' => true
            ],
            [
                'nom' => 'Centre Casablanca',
                'adresse' => 'Boulevard Zerktouni, Casablanca',
                'actif' => true
            ],
            [
                'nom' => 'Centre Fès',
                'adresse' => 'Avenue Hassan II, Fès',
                'actif' => true
            ]
        ];

        foreach ($centres as $centreData) {
            $centre = Centre::create($centreData);
            
            // Créer des options pour chaque centre
            $options = [
                [
                    'nom' => 'Sciences',
                    'centre_id' => $centre->id,
                    'actif' => true
                ],
                [
                    'nom' => 'Lettres',
                    'centre_id' => $centre->id,
                    'actif' => true
                ]
            ];

            foreach ($options as $optionData) {
                Option::create($optionData);
            }
        }

        $this->command->info('Centres et options créés avec succès!');
    }
}
