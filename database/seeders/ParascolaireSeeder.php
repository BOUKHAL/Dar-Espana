<?php

namespace Database\Seeders;

use App\Models\Parascolaire;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParascolaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'nom_evenement' => 'Tournoi de Football Inter-Classes',
                'jour_evenement' => '2025-09-15',
                'lieu' => 'Terrain de Sport Principal',
                'description' => 'Compétition de football entre toutes les classes de l\'école. Les équipes seront formées par niveau. Finale prévue en fin de journée avec remise des prix.'
            ],
            [
                'nom_evenement' => 'Spectacle de Fin d\'Année',
                'jour_evenement' => '2025-06-20',
                'lieu' => 'Auditorium de l\'École',
                'description' => 'Spectacle présenté par les élèves avec danses, chants, théâtre et musique. Participation de tous les niveaux scolaires.'
            ],
            [
                'nom_evenement' => 'Concours de Sciences',
                'jour_evenement' => '2025-10-10',
                'lieu' => 'Laboratoire de Sciences',
                'description' => 'Concours de projets scientifiques où les élèves présentent leurs expériences et découvertes. Jury composé de professeurs et d\'experts.'
            ],
            [
                'nom_evenement' => 'Journée Porte Ouverte',
                'jour_evenement' => '2025-03-25',
                'lieu' => 'Ensemble de l\'École',
                'description' => 'Présentation de l\'école aux futurs élèves et à leurs parents. Visite des classes, démonstrations d\'activités et rencontres avec les enseignants.'
            ],
            [
                'nom_evenement' => 'Marathon de Lecture',
                'jour_evenement' => '2025-04-15',
                'lieu' => 'Bibliothèque',
                'description' => 'Événement de promotion de la lecture où les élèves participent à des activités autour des livres, contes et storytelling.'
            ],
            [
                'nom_evenement' => 'Exposition d\'Art',
                'jour_evenement' => '2025-05-08',
                'lieu' => 'Hall Principal',
                'description' => 'Exposition des œuvres créées par les élèves en cours d\'arts plastiques. Vernissage avec présence des familles.'
            ],
            [
                'nom_evenement' => 'Sortie Éducative au Musée',
                'jour_evenement' => '2025-11-12',
                'lieu' => 'Musée National',
                'description' => 'Visite éducative au musée national pour découvrir l\'histoire et la culture locale. Transport en bus organisé.'
            ],
            [
                'nom_evenement' => 'Atelier Cuisine Internationale',
                'jour_evenement' => '2025-12-05',
                'lieu' => 'Cuisine Pédagogique',
                'description' => 'Découverte de plats traditionnels de différents pays. Les élèves cuisinent et dégustent ensemble.'
            ]
        ];

        foreach ($events as $event) {
            Parascolaire::create($event);
        }
    }
}
