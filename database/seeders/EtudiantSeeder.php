<?php

namespace Database\Seeders;

use App\Models\Etudiant;
use App\Models\Centre;
use App\Models\Option;
use App\Models\Filiere;
use Illuminate\Database\Seeder;

class EtudiantSeeder extends Seeder
{
    public function run()
    {
        // Vérifier que nous avons des centres, options et filières
        $centres = Centre::all();
        $options = Option::all();
        $filieres = Filiere::all();

        if ($centres->isEmpty() || $options->isEmpty() || $filieres->isEmpty()) {
            $this->command->error('Veuillez d\'abord créer des centres, options et filières.');
            return;
        }

        $typesBac = ['bac_marocain', 'bac_francais'];

        // Créer des étudiants de test
        $etudiants = [
            [
                'nom' => 'Bennani',
                'prenom' => 'Youssef',
                'telephone_etudiant' => '0612345678',
                'telephone_parents' => '0612345679',
                'email' => 'youssef.bennani@capstone.ma',
                'filiere_nom' => 'INGÉNIERIE'
            ],
            [
                'nom' => 'Alami',
                'prenom' => 'Fatima',
                'telephone_etudiant' => '0623456789',
                'telephone_parents' => '0623456790',
                'email' => 'fatima.alami@capstone.ma',
                'filiere_nom' => 'SANTÉ'
            ],
            [
                'nom' => 'Idrissi',
                'prenom' => 'Ahmed',
                'telephone_etudiant' => '0634567890',
                'telephone_parents' => '0634567891',
                'email' => 'ahmed.idrissi@capstone.ma',
                'filiere_nom' => 'DROIT'
            ],
            [
                'nom' => 'Benali',
                'prenom' => 'Meryem',
                'telephone_etudiant' => '0645678901',
                'telephone_parents' => '0645678902',
                'email' => 'meryem.benali@capstone.ma',
                'filiere_nom' => 'ARCHITECTURE'
            ],
            [
                'nom' => 'Tazi',
                'prenom' => 'Omar',
                'telephone_etudiant' => '0656789012',
                'telephone_parents' => '0656789013',
                'email' => 'omar.tazi@capstone.ma',
                'filiere_nom' => 'ÉCONOMIE'
            ],
            [
                'nom' => 'Chraibi',
                'prenom' => 'Salma',
                'telephone_etudiant' => '0667890123',
                'telephone_parents' => '0667890124',
                'email' => 'salma.chraibi@capstone.ma',
                'filiere_nom' => 'SPORT ÉTUDES'
            ]
        ];

        foreach ($etudiants as $etudiantData) {
            $filiere = $filieres->where('nom', $etudiantData['filiere_nom'])->first();
            
            Etudiant::create([
                'nom' => $etudiantData['nom'],
                'prenom' => $etudiantData['prenom'],
                'telephone_etudiant' => $etudiantData['telephone_etudiant'],
                'telephone_parents' => $etudiantData['telephone_parents'],
                'email' => $etudiantData['email'],
                'type_baccalaureat' => $typesBac[array_rand($typesBac)],
                'centre_id' => $centres->random()->id,
                'option_id' => $options->random()->id,
                'filiere_id' => $filiere ? $filiere->id : $filieres->random()->id
            ]);
        }

        // Créer quelques étudiants aléatoires supplémentaires
        for ($i = 1; $i <= 10; $i++) {
            Etudiant::create([
                'nom' => 'Étudiant' . $i,
                'prenom' => 'Test' . $i,
                'telephone_etudiant' => '06' . str_pad($i, 8, '0', STR_PAD_LEFT),
                'telephone_parents' => '06' . str_pad($i + 100, 8, '0', STR_PAD_LEFT),
                'email' => 'etudiant' . $i . '@capstone.ma',
                'type_baccalaureat' => $typesBac[array_rand($typesBac)],
                'centre_id' => $centres->random()->id,
                'option_id' => $options->random()->id,
                'filiere_id' => $filieres->random()->id
            ]);
        }

        $this->command->info('Étudiants créés avec succès!');
    }
}
