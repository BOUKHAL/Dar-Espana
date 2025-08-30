<?php

namespace Database\Seeders;

use App\Models\Filiere;
use Illuminate\Database\Seeder;

class FiliereSeeder extends Seeder
{
    public function run()
    {
        $filieres = [
            [
                'nom' => 'SANTÉ',
                'description' => 'Filière dédiée aux études de médecine, pharmacie, et sciences de la santé',
                'actif' => true
            ],
            [
                'nom' => 'INGÉNIERIE',
                'description' => 'Filière pour les études d\'ingénierie et sciences techniques',
                'actif' => true
            ],
            [
                'nom' => 'ARCHITECTURE',
                'description' => 'Filière pour les études d\'architecture et urbanisme',
                'actif' => true
            ],
            [
                'nom' => 'ÉCONOMIE',
                'description' => 'Filière pour les études économiques et de gestion',
                'actif' => true
            ],
            [
                'nom' => 'DROIT',
                'description' => 'Filière pour les études juridiques et sciences politiques',
                'actif' => true
            ],
            [
                'nom' => 'SPORT ÉTUDES',
                'description' => 'Filière combinant études et pratique sportive de haut niveau',
                'actif' => true
            ]
        ];

        foreach ($filieres as $filiereData) {
            Filiere::create($filiereData);
        }

        $this->command->info('Filières créées avec succès!');
    }
}
