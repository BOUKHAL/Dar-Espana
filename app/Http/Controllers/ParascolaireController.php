<?php

namespace App\Http\Controllers;

use App\Models\Parascolaire;
use App\Http\Requests\StoreParascolaireRequest;
use App\Http\Requests\UpdateParascolaireRequest;
use Illuminate\Http\Request;

class ParascolaireController extends Controller
{
    public function index(Request $request)
    {
        $query = Parascolaire::query();

        // Recherche par nom
        if ($request->filled('search')) {
            $query->where('nom_evenement', 'like', '%' . $request->search . '%')
                  ->orWhere('lieu', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Filtrage par statut (futur/passé)
        if ($request->filled('status')) {
            if ($request->status === 'futur') {
                $query->where('jour_evenement', '>', now());
            } elseif ($request->status === 'passe') {
                $query->where('jour_evenement', '<=', now());
            }
        }

        // Filtrage par mois
        if ($request->filled('month')) {
            $query->whereMonth('jour_evenement', $request->month);
        }

        // Tri
        $sortBy = $request->get('sort', 'jour_evenement');
        $sortOrder = $request->get('order', 'desc');
        
        if (in_array($sortBy, ['nom_evenement', 'jour_evenement', 'lieu', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('jour_evenement', 'desc');
        }

        $parascolaires = $query->paginate(9)->withQueryString();
        
        return view('parascolaire.index', compact('parascolaires'));
    }

    public function create()
    {
        return view('parascolaire.create');
    }

    public function store(StoreParascolaireRequest $request)
    {
        Parascolaire::create($request->validated());

        return redirect()->route('parascolaire.index')
            ->with('success', 'Événement parascolaire créé avec succès.');
    }

    public function show(Parascolaire $parascolaire)
    {
        return view('parascolaire.show', compact('parascolaire'));
    }

    public function edit(Parascolaire $parascolaire)
    {
        return view('parascolaire.edit', compact('parascolaire'));
    }

    public function update(UpdateParascolaireRequest $request, Parascolaire $parascolaire)
    {
        $parascolaire->update($request->validated());

        return redirect()->route('parascolaire.index')
            ->with('success', 'Événement parascolaire mis à jour avec succès.');
    }

    public function destroy(Parascolaire $parascolaire)
    {
        $parascolaire->delete();

        return redirect()->route('parascolaire.index')
            ->with('success', 'Événement parascolaire supprimé avec succès.');
    }
}
