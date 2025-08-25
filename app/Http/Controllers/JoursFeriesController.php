<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JourFerie;
use Carbon\Carbon;

class JoursFeriesController extends Controller
{
    public function index()
    {
        $joursFeries = JourFerie::orderBy('date', 'asc')->paginate(15);
        $prochainJourFerie = JourFerie::actif()
            ->where('date', '>=', now())
            ->orderBy('date', 'asc')
            ->first();
        
        $stats = [
            'total' => JourFerie::count(),
            'actifs' => JourFerie::actif()->count(),
            'cette_annee' => JourFerie::actif()->pourAnnee(date('Y'))->count(),
            'prochains' => JourFerie::actif()->where('date', '>=', now())->count()
        ];
        
        return view('jours-feries.index', compact('joursFeries', 'prochainJourFerie', 'stats'));
    }

    public function create()
    {
        return view('jours-feries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'type' => 'required|in:fixe,mobile',
            'recurrent' => 'boolean',
            'annee' => 'nullable|integer|min:2024|max:2050',
            'couleur' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'actif' => 'boolean',
        ], [
            'nom.required' => 'Le nom du jour férié est obligatoire.',
            'date.required' => 'La date est obligatoire.',
            'date.date' => 'La date doit être valide.',
            'couleur.regex' => 'La couleur doit être au format hexadécimal (#RRGGBB).',
        ]);

        // Vérifier les doublons
        $exists = JourFerie::where('nom', $request->nom)
            ->where('date', $request->date)
            ->first();

        if ($exists) {
            return back()->withErrors([
                'nom' => 'Un jour férié avec ce nom existe déjà à cette date.'
            ])->withInput();
        }

        JourFerie::create([
            'nom' => $request->nom,
            'date' => $request->date,
            'description' => $request->description,
            'type' => $request->type,
            'recurrent' => $request->has('recurrent'),
            'annee' => $request->type === 'fixe' && !$request->has('recurrent') ? Carbon::parse($request->date)->year : $request->annee,
            'couleur' => $request->couleur,
            'actif' => $request->has('actif'),
        ]);

        return redirect()->route('jours-feries.index')
            ->with('success', 'Jour férié créé avec succès!');
    }

    public function show(JourFerie $joursFerie)
    {
        return view('jours-feries.show', compact('joursFerie'));
    }

    public function edit(JourFerie $joursFerie)
    {
        return view('jours-feries.edit', compact('joursFerie'));
    }

    public function update(Request $request, JourFerie $joursFerie)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'type' => 'required|in:fixe,mobile',
            'recurrent' => 'boolean',
            'annee' => 'nullable|integer|min:2024|max:2050',
            'couleur' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'actif' => 'boolean',
        ]);

        // Vérifier les doublons (exclure l'enregistrement actuel)
        $exists = JourFerie::where('nom', $request->nom)
            ->where('date', $request->date)
            ->where('id', '!=', $joursFerie->id)
            ->first();

        if ($exists) {
            return back()->withErrors([
                'nom' => 'Un jour férié avec ce nom existe déjà à cette date.'
            ])->withInput();
        }

        $joursFerie->update([
            'nom' => $request->nom,
            'date' => $request->date,
            'description' => $request->description,
            'type' => $request->type,
            'recurrent' => $request->has('recurrent'),
            'annee' => $request->type === 'fixe' && !$request->has('recurrent') ? Carbon::parse($request->date)->year : $request->annee,
            'couleur' => $request->couleur,
            'actif' => $request->has('actif'),
        ]);

        return redirect()->route('jours-feries.index')
            ->with('success', 'Jour férié modifié avec succès!');
    }

    public function destroy(JourFerie $joursFerie)
    {
        $joursFerie->delete();

        return redirect()->route('jours-feries.index')
            ->with('success', 'Jour férié supprimé avec succès!');
    }

    public function toggleStatus(JourFerie $jourFerie)
    {
        $jourFerie->update([
            'actif' => !$jourFerie->actif
        ]);

        $status = $jourFerie->actif ? 'activé' : 'désactivé';
        return response()->json([
            'success' => true,
            'message' => "Jour férié {$status} avec succès!",
            'actif' => $jourFerie->actif
        ]);
    }

    public function getCalendar($annee = null)
    {
        $annee = $annee ?? date('Y');
        $joursFeries = JourFerie::actif()
            ->pourAnnee($annee)
            ->get()
            ->map(function ($jourFerie) {
                return [
                    'title' => $jourFerie->nom,
                    'date' => $jourFerie->date->format('Y-m-d'),
                    'color' => $jourFerie->couleur,
                    'description' => $jourFerie->description
                ];
            });

        return response()->json($joursFeries);
    }
}
