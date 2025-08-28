<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Matiere;
use App\Models\Cours;
use Illuminate\Http\JsonResponse;

class DocumentController extends Controller
{
    /**
     * Get all matieres with their niveaux and cours
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            // Get matieres with niveaux
            $matieresAvecNiveaux = Matiere::where('a_niveaux', true)
                ->where('actif', true)
                ->with(['niveaux' => function($query) {
                    $query->where('actif', true)->orderBy('ordre');
                }])
                ->get();

            // Get matieres without niveaux
            $matieresSansNiveaux = Matiere::where('a_niveaux', false)
                ->where('actif', true)
                ->with(['cours' => function($query) {
                    $query->where('actif', true)->orderBy('ordre');
                }])
                ->get();

            // Get cours by niveau for matieres with niveaux
            $coursByNiveau = [];
            foreach ($matieresAvecNiveaux as $matiere) {
                foreach ($matiere->niveaux as $niveau) {
                    $coursByNiveau[$niveau->id] = Cours::where('niveau_id', $niveau->id)
                        ->where('actif', true)
                        ->orderBy('ordre')
                        ->get()
                        ->map(function ($cours) {
                            return [
                                'id' => $cours->id,
                                'titre' => $cours->titre,
                                'description' => $cours->description,
                                'fichier_path' => $cours->fichier_path,
                                'fichier_nom' => $cours->fichier_nom,
                                'type_fichier' => $cours->type_fichier,
                                'taille_fichier' => $cours->taille_fichier,
                                'ordre' => $cours->ordre,
                                'matiere_id' => $cours->matiere_id,
                                'niveau_id' => $cours->niveau_id,
                            ];
                        });
                }
            }

            // Transform matieres for better API response
            $transformedMatieresAvecNiveaux = $matieresAvecNiveaux->map(function ($matiere) {
                return [
                    'id' => $matiere->id,
                    'nom' => $matiere->nom,
                    'description' => $matiere->description,
                    'a_niveaux' => $matiere->a_niveaux,
                    'actif' => $matiere->actif,
                    'niveaux' => $matiere->niveaux->map(function ($niveau) {
                        return [
                            'id' => $niveau->id,
                            'nom' => $niveau->nom,
                            'ordre' => $niveau->ordre,
                            'actif' => $niveau->actif,
                        ];
                    })
                ];
            });

            $transformedMatieresSansNiveaux = $matieresSansNiveaux->map(function ($matiere) {
                return [
                    'id' => $matiere->id,
                    'nom' => $matiere->nom,
                    'description' => $matiere->description,
                    'a_niveaux' => $matiere->a_niveaux,
                    'actif' => $matiere->actif,
                    'cours' => $matiere->cours->map(function ($cours) {
                        return [
                            'id' => $cours->id,
                            'titre' => $cours->titre,
                            'description' => $cours->description,
                            'fichier_path' => $cours->fichier_path,
                            'fichier_nom' => $cours->fichier_nom,
                            'type_fichier' => $cours->type_fichier,
                            'taille_fichier' => $cours->taille_fichier,
                            'ordre' => $cours->ordre,
                            'matiere_id' => $cours->matiere_id,
                        ];
                    })
                ];
            });

            return response()->json([
                'success' => true,
                'data' => [
                    'matieres_avec_niveaux' => $transformedMatieresAvecNiveaux,
                    'matieres_sans_niveaux' => $transformedMatieresSansNiveaux,
                    'cours_par_niveau' => $coursByNiveau
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des documents.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get cours for a specific niveau
     *
     * @param int $niveauId
     * @return JsonResponse
     */
    public function getCoursByNiveau($niveauId): JsonResponse
    {
        try {
            $cours = Cours::where('niveau_id', $niveauId)
                ->where('actif', true)
                ->orderBy('ordre')
                ->get()
                ->map(function ($cours) {
                    return [
                        'id' => $cours->id,
                        'titre' => $cours->titre,
                        'description' => $cours->description,
                        'fichier_path' => $cours->fichier_path,
                        'fichier_nom' => $cours->fichier_nom,
                        'type_fichier' => $cours->type_fichier,
                        'taille_fichier' => $cours->taille_fichier,
                        'ordre' => $cours->ordre,
                        'matiere_id' => $cours->matiere_id,
                        'niveau_id' => $cours->niveau_id,
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $cours
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des cours.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get cours for a specific matiere (without niveaux)
     *
     * @param int $matiereId
     * @return JsonResponse
     */
    public function getCoursByMatiere($matiereId): JsonResponse
    {
        try {
            $cours = Cours::where('matiere_id', $matiereId)
                ->where('actif', true)
                ->orderBy('ordre')
                ->get()
                ->map(function ($cours) {
                    return [
                        'id' => $cours->id,
                        'titre' => $cours->titre,
                        'description' => $cours->description,
                        'fichier_path' => $cours->fichier_path,
                        'fichier_nom' => $cours->fichier_nom,
                        'type_fichier' => $cours->type_fichier,
                        'taille_fichier' => $cours->taille_fichier,
                        'ordre' => $cours->ordre,
                        'matiere_id' => $cours->matiere_id,
                        'niveau_id' => $cours->niveau_id,
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $cours
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des cours.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download a cours file
     *
     * @param int $coursId
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|JsonResponse
     */
    public function downloadCours($coursId)
    {
        try {
            $cours = Cours::findOrFail($coursId);

            if (!$cours->actif) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ce cours n\'est pas disponible.'
                ], 404);
            }

            $filePath = storage_path('app/' . $cours->fichier_path);

            if (!file_exists($filePath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Fichier non trouvé.'
                ], 404);
            }

            return response()->download($filePath, $cours->fichier_nom);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du téléchargement du fichier.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}