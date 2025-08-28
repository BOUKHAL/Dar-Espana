<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Centre;
use App\Models\Option;
use App\Models\Planification;
use Illuminate\Support\Facades\Storage;

class PlanificationController extends Controller
{
    public function index()
    {
        $centres = Centre::with('options')->where('actif', true)->get();
        $planifications = Planification::with(['centre', 'option'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('planification.index', compact('centres', 'planifications'));
    }

    public function create()
    {
        $centres = Centre::with('options')->where('actif', true)->get();
        return view('planification.create', compact('centres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'centre_id' => 'required|exists:centres,id',
            'option_id' => 'required|exists:options,id',
            'titre' => 'required|string|max:255',
            'fichier' => 'required|file|mimes:pdf,xlsx,xls|max:10240', // 10MB max
            'semaine_debut' => 'required|date|after_or_equal:today',
            'semaine_fin' => 'required|date|after_or_equal:semaine_debut',
            'description' => 'nullable|string'
        ], [
            'semaine_debut.after_or_equal' => 'La date de début ne peut pas être dans le passé.',
            'semaine_fin.after_or_equal' => 'La date de fin doit être postérieure ou égale à la date de début.',
        ]);

        // Vérifier s'il existe déjà une planification pour ce centre/option dans cette période
        $existingPlanification = Planification::where('centre_id', $request->centre_id)
            ->where('option_id', $request->option_id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('semaine_debut', [$request->semaine_debut, $request->semaine_fin])
                    ->orWhereBetween('semaine_fin', [$request->semaine_debut, $request->semaine_fin])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('semaine_debut', '<=', $request->semaine_debut)
                            ->where('semaine_fin', '>=', $request->semaine_fin);
                    });
            })
            ->first();

        if ($existingPlanification) {
            return back()->withErrors([
                'periode' => 'Une planification existe déjà pour ce centre et cette option dans cette période.'
            ])->withInput();
        }

        $file = $request->file('fichier');
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '_' . $request->centre_id . '_' . $request->option_id . '.' . $extension;
        $path = $file->storeAs('planifications', $filename, 'public');

        Planification::create([
            'centre_id' => $request->centre_id,
            'option_id' => $request->option_id,
            'titre' => $request->titre,
            'fichier_path' => $path,
            'type_fichier' => $extension,
            'semaine_debut' => $request->semaine_debut,
            'semaine_fin' => $request->semaine_fin,
            'description' => $request->description,
        ]);

        return redirect()->route('planification.index')
            ->with('success', 'Planification uploadée avec succès!');
    }

    public function getOptions($centreId)
    {
        $options = Option::where('centre_id', $centreId)->where('actif', true)->get();
        return response()->json($options);
    }

    public function edit(string $id)
    {
        $planification = Planification::findOrFail($id);
        $centres = Centre::with('options')->where('actif', true)->get();
        return view('planification.edit', compact('planification', 'centres'));
    }

    public function destroy(string $id)
    {
        $planification = Planification::findOrFail($id);

        // Supprimer le fichier du stockage
        if (Storage::disk('public')->exists($planification->fichier_path)) {
            Storage::disk('public')->delete($planification->fichier_path);
        }

        $planification->delete();

        return redirect()->route('planification.index')
            ->with('success', 'Planification supprimée avec succès!');
    }
}
