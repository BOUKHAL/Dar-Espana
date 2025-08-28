<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Matiere;
use App\Models\Niveau;

class MatieresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer les matières avec niveaux (langues)
        $espagnol = Matiere::create([
            'nom' => 'Espagnol',
            'description' => 'Cours de langue espagnole',
            'a_niveaux' => true,
            'actif' => true
        ]);

        $francais = Matiere::create([
            'nom' => 'Français',
            'description' => 'Cours de langue française',
            'a_niveaux' => true,
            'actif' => true
        ]);

        $anglais = Matiere::create([
            'nom' => 'Anglais',
            'description' => 'Cours de langue anglaise',
            'a_niveaux' => true,
            'actif' => true
        ]);

        // Créer les matières sans niveaux
        Matiere::create([
            'nom' => 'Histoire et Littérature',
            'description' => 'Cours d\'histoire et de littérature',
            'a_niveaux' => false,
            'actif' => true
        ]);

        // Créer les niveaux pour chaque langue
        $niveaux = ['A1', 'A2', 'B1', 'B2'];
        
        foreach ([$espagnol, $francais, $anglais] as $matiere) {
            foreach ($niveaux as $index => $niveau) {
                Niveau::create([
                    'nom' => $niveau,
                    'matiere_id' => $matiere->id,
                    'ordre' => $index + 1,
                    'actif' => true
                ]);
            }
        }
    }
}
