<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matiere;
use App\Models\Niveau;
use App\Models\Cours;
use Illuminate\Support\Facades\Storage;

class DocumentsController extends Controller
{
    public function index()
    {
        $matieresAvecNiveaux = Matiere::where('a_niveaux', true)
            ->where('actif', true)
            ->with(['niveaux' => function($query) {
                $query->where('actif', true)->orderBy('ordre');
            }])
            ->get();

        $matieresSansNiveaux = Matiere::where('a_niveaux', false)
            ->where('actif', true)
            ->with('cours')
            ->get();

        // Récupérer tous les cours par niveau pour les matières avec niveaux
        $coursByNiveau = [];
        foreach ($matieresAvecNiveaux as $matiere) {
            foreach ($matiere->niveaux as $niveau) {
                $coursByNiveau[$niveau->id] = Cours::where('niveau_id', $niveau->id)
                    ->where('actif', true)
                    ->orderBy('ordre')
                    ->get();
            }
        }

        return view('documents.index', compact(
            'matieresAvecNiveaux', 
            'matieresSansNiveaux', 
            'coursByNiveau'
        ));
    }

    public function create()
    {
        $matieres = Matiere::where('actif', true)->get();
        return view('documents.create', compact('matieres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'matiere_id' => 'required|exists:matieres,id',
            'niveau_id' => 'nullable|exists:niveaux,id',
            'fichier' => 'required|file|mimes:pdf|max:10240', // 10MB max
        ]);

        // Vérifier si la matière a des niveaux et si niveau_id est requis
        $matiere = Matiere::find($request->matiere_id);
        if ($matiere->a_niveaux && !$request->niveau_id) {
            return back()->withErrors(['niveau_id' => 'Le niveau est requis pour cette matière.']);
        }

        $file = $request->file('fichier');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('cours', $filename, 'public');

        Cours::create([
            'titre' => $request->titre,
            'description' => $request->description,
            'fichier_path' => $path,
            'fichier_nom' => $filename,
            'type_fichier' => $file->getClientOriginalExtension(),
            'taille_fichier' => $file->getSize(),
            'matiere_id' => $request->matiere_id,
            'niveau_id' => $request->niveau_id,
            'ordre' => 0,
            'actif' => true
        ]);

        return redirect()->route('documents.index')->with('success', 'Cours ajouté avec succès!');
    }

    public function edit(string $id)
    {
        $cours = Cours::findOrFail($id);
        $matieres = Matiere::where('actif', true)->get();
        return view('documents.edit', compact('cours', 'matieres'));
    }

    public function update(Request $request, string $id)
    {
        $cours = Cours::findOrFail($id);
        
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'matiere_id' => 'required|exists:matieres,id',
            'niveau_id' => 'nullable|exists:niveaux,id',
            'fichier' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        // Vérifier si la matière a des niveaux et si niveau_id est requis
        $matiere = Matiere::find($request->matiere_id);
        if ($matiere->a_niveaux && !$request->niveau_id) {
            return back()->withErrors(['niveau_id' => 'Le niveau est requis pour cette matière.']);
        }

        $data = [
            'titre' => $request->titre,
            'description' => $request->description,
            'matiere_id' => $request->matiere_id,
            'niveau_id' => $request->niveau_id,
        ];

        // Si un nouveau fichier est uploadé
        if ($request->hasFile('fichier')) {
            // Supprimer l'ancien fichier
            Storage::disk('public')->delete($cours->fichier_path);
            
            $file = $request->file('fichier');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('cours', $filename, 'public');

            $data['fichier_path'] = $path;
            $data['fichier_nom'] = $filename;
            $data['type_fichier'] = $file->getClientOriginalExtension();
            $data['taille_fichier'] = $file->getSize();
        }

        $cours->update($data);

        return redirect()->route('documents.index')->with('success', 'Cours modifié avec succès!');
    }

    public function destroy(string $id)
    {
        $cours = Cours::findOrFail($id);
        
        // Supprimer le fichier du stockage
        Storage::disk('public')->delete($cours->fichier_path);
        
        $cours->delete();

        return redirect()->route('documents.index')->with('success', 'Cours supprimé avec succès!');
    }

    public function getNiveaux(Request $request)
    {
        $matiereId = $request->get('matiere_id');
        $niveaux = Niveau::where('matiere_id', $matiereId)
            ->where('actif', true)
            ->orderBy('ordre')
            ->get();
        
        return response()->json($niveaux);
    }

    public function download(string $id)
    {
        $cours = Cours::findOrFail($id);
        
        if (!Storage::disk('public')->exists($cours->fichier_path)) {
            abort(404, 'Fichier non trouvé');
        }

        return response()->download(storage_path('app/public/' . $cours->fichier_path), $cours->fichier_nom);
    }
}
