<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Centre;
use App\Models\Option;

class CentreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $centres = [
            ['nom' => 'Zenith', 'adresse' => 'Casablanca Zenith'],
            ['nom' => 'Ain Sebaa', 'adresse' => 'Casablanca Ain Sebaa'],
            ['nom' => 'Mly Youssef', 'adresse' => 'Casablanca Moulay Youssef']
        ];

        foreach ($centres as $centreData) {
            $centre = Centre::create($centreData);
            
            // Ajouter les deux options pour chaque centre
            Option::create([
                'nom' => 'Selectividad',
                'centre_id' => $centre->id
            ]);
            
            Option::create([
                'nom' => 'Selectividad Parallèle',
                'centre_id' => $centre->id
            ]);
        }
    }
}
