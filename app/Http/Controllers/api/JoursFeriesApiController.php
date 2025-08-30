<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JourFerie;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class JoursFeriesApiController extends Controller
{
    /**
     * Get dashboard statistics and overview data
     */
    public function dashboard(): JsonResponse
    {
        $currentYear = date('Y');
        $now = now();
        
        // Get next holiday
        $prochainJourFerie = JourFerie::actif()
            ->where('date', '>=', $now)
            ->orderBy('date', 'asc')
            ->first();
        
        // Statistics
        $stats = [
            'total' => JourFerie::count(),
            'actifs' => JourFerie::actif()->count(),
            'cette_annee' => JourFerie::actif()->pourAnnee($currentYear)->count(),
            'prochains' => JourFerie::actif()->where('date', '>=', $now)->count(),
            'passes' => JourFerie::actif()->where('date', '<', $now)->count(),
        ];
        
        // Recent holidays (last 5 passed)
        $joursFeriesRecents = JourFerie::actif()
            ->where('date', '<', $now)
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($jourFerie) {
                return $this->formatJourFerie($jourFerie);
            });
        
        // Upcoming holidays (next 5)
        $joursFeriesAVenir = JourFerie::actif()
            ->where('date', '>=', $now)
            ->orderBy('date', 'asc')
            ->limit(5)
            ->get()
            ->map(function ($jourFerie) {
                return $this->formatJourFerie($jourFerie);
            });
        
        return response()->json([
            'success' => true,
            'data' => [
                'stats' => $stats,
                'prochain_jour_ferie' => $prochainJourFerie ? $this->formatJourFerie($prochainJourFerie) : null,
                'jours_feries_recents' => $joursFeriesRecents,
                'jours_feries_a_venir' => $joursFeriesAVenir,
                'current_year' => $currentYear,
            ]
        ]);
    }
    
    /**
     * Get paginated list of holidays
     */
    public function index(Request $request): JsonResponse
    {
        $query = JourFerie::query();
        
        // Filters
        if ($request->filled('annee')) {
            $query->pourAnnee($request->annee);
        }
        
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        if ($request->filled('actif')) {
            $query->where('actif', $request->boolean('actif'));
        }
        
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nom', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }
        
        // Only active holidays by default unless specified
        if ($request->filled('include_inactif') && $request->boolean('include_inactif')) {
            // Include all holidays
        } else {
            $query->actif();
        }
        
        // Sorting
        $sortBy = $request->get('sort_by', 'date');
        $sortOrder = $request->get('sort_order', 'asc');
        
        if (in_array($sortBy, ['nom', 'date', 'type', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('date', 'asc');
        }
        
        $perPage = min($request->get('per_page', 15), 100); // Max 100 per page
        $joursFeries = $query->paginate($perPage);
        
        return response()->json([
            'success' => true,
            'data' => $joursFeries->getCollection()->map(function ($jourFerie) {
                return $this->formatJourFerie($jourFerie);
            }),
            'pagination' => [
                'current_page' => $joursFeries->currentPage(),
                'last_page' => $joursFeries->lastPage(),
                'per_page' => $joursFeries->perPage(),
                'total' => $joursFeries->total(),
                'from' => $joursFeries->firstItem(),
                'to' => $joursFeries->lastItem(),
            ]
        ]);
    }
    
    /**
     * Get calendar data for a specific year
     */
    public function calendar(Request $request, $annee = null): JsonResponse
    {
        $annee = $annee ?? date('Y');
        
        // Validate year
        if (!is_numeric($annee) || $annee < 2020 || $annee > 2050) {
            return response()->json([
                'success' => false,
                'message' => 'Année invalide'
            ], 400);
        }
        
        $joursFeries = JourFerie::actif()
            ->pourAnnee($annee)
            ->orderBy('date')
            ->get()
            ->map(function ($jourFerie) {
                return [
                    'id' => $jourFerie->id,
                    'title' => $jourFerie->nom,
                    'date' => $jourFerie->date->format('Y-m-d'),
                    'start' => $jourFerie->date->format('Y-m-d'),
                    'color' => $jourFerie->couleur,
                    'backgroundColor' => $jourFerie->couleur,
                    'borderColor' => $jourFerie->couleur,
                    'description' => $jourFerie->description,
                    'type' => $jourFerie->type,
                    'recurrent' => $jourFerie->recurrent,
                    'est_weekend' => $jourFerie->estWeekEnd(),
                    'jour_semaine' => $jourFerie->jour_semaine
                ];
            });
        
        return response()->json([
            'success' => true,
            'data' => $joursFeries,
            'annee' => (int) $annee,
            'total' => $joursFeries->count()
        ]);
    }
    
    /**
     * Get holidays by month
     */
    public function byMonth(Request $request, $annee = null, $mois = null): JsonResponse
    {
        $annee = $annee ?? date('Y');
        $mois = $mois ?? date('m');
        
        // Validate inputs
        if (!is_numeric($annee) || $annee < 2020 || $annee > 2050) {
            return response()->json(['success' => false, 'message' => 'Année invalide'], 400);
        }
        
        if (!is_numeric($mois) || $mois < 1 || $mois > 12) {
            return response()->json(['success' => false, 'message' => 'Mois invalide'], 400);
        }
        
        $startOfMonth = Carbon::create($annee, $mois, 1)->startOfMonth();
        $endOfMonth = Carbon::create($annee, $mois, 1)->endOfMonth();
        
        $joursFeries = JourFerie::actif()
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->orderBy('date')
            ->get()
            ->map(function ($jourFerie) {
                return $this->formatJourFerie($jourFerie);
            });
        
        return response()->json([
            'success' => true,
            'data' => $joursFeries,
            'annee' => (int) $annee,
            'mois' => (int) $mois,
            'mois_nom' => $startOfMonth->translatedFormat('F'),
            'total' => $joursFeries->count()
        ]);
    }
    
    /**
     * Get upcoming holidays (next N holidays)
     */
    public function upcoming(Request $request): JsonResponse
    {
        $limit = min($request->get('limit', 5), 20); // Max 20
        
        $joursFeries = JourFerie::actif()
            ->where('date', '>=', now())
            ->orderBy('date', 'asc')
            ->limit($limit)
            ->get()
            ->map(function ($jourFerie) {
                return $this->formatJourFerie($jourFerie);
            });
        
        return response()->json([
            'success' => true,
            'data' => $joursFeries,
            'total' => $joursFeries->count()
        ]);
    }
    
    /**
     * Get statistics
     */
    public function statistics(): JsonResponse
    {
        $currentYear = date('Y');
        $now = now();
        
        $stats = [
            'total' => JourFerie::count(),
            'actifs' => JourFerie::actif()->count(),
            'inactifs' => JourFerie::where('actif', false)->count(),
            'cette_annee' => JourFerie::actif()->pourAnnee($currentYear)->count(),
            'annee_prochaine' => JourFerie::actif()->pourAnnee($currentYear + 1)->count(),
            'passes_cette_annee' => JourFerie::actif()
                ->pourAnnee($currentYear)
                ->where('date', '<', $now)
                ->count(),
            'restants_cette_annee' => JourFerie::actif()
                ->pourAnnee($currentYear)
                ->where('date', '>=', $now)
                ->count(),
            'types' => [
                'fixe' => JourFerie::actif()->where('type', 'fixe')->count(),
                'mobile' => JourFerie::actif()->where('type', 'mobile')->count(),
            ],
            'recurrents' => JourFerie::actif()->where('recurrent', true)->count(),
            'non_recurrents' => JourFerie::actif()->where('recurrent', false)->count(),
        ];
        
        // Monthly distribution for current year
        $distributionMensuelle = [];
        for ($mois = 1; $mois <= 12; $mois++) {
            $startOfMonth = Carbon::create($currentYear, $mois, 1)->startOfMonth();
            $endOfMonth = Carbon::create($currentYear, $mois, 1)->endOfMonth();
            
            $count = JourFerie::actif()
                ->whereBetween('date', [$startOfMonth, $endOfMonth])
                ->count();
                
            $distributionMensuelle[] = [
                'mois' => $mois,
                'mois_nom' => $startOfMonth->translatedFormat('F'),
                'count' => $count
            ];
        }
        
        return response()->json([
            'success' => true,
            'data' => [
                'stats' => $stats,
                'distribution_mensuelle' => $distributionMensuelle,
                'annee' => $currentYear
            ]
        ]);
    }
    
    /**
     * Check if a specific date is a holiday
     */
    public function checkDate(Request $request): JsonResponse
    {
        $request->validate([
            'date' => 'required|date'
        ]);
        
        $date = Carbon::parse($request->date);
        $annee = $date->year;
        
        $jourFerie = JourFerie::actif()
            ->pourAnnee($annee)
            ->whereDate('date', $date->format('Y-m-d'))
            ->first();
        
        return response()->json([
            'success' => true,
            'data' => [
                'est_jour_ferie' => $jourFerie ? true : false,
                'jour_ferie' => $jourFerie ? $this->formatJourFerie($jourFerie) : null,
                'date_verifiee' => $date->format('Y-m-d'),
                'est_weekend' => in_array($date->dayOfWeek, [Carbon::SATURDAY, Carbon::SUNDAY])
            ]
        ]);
    }
    
    /**
     * Format a JourFerie model for API response
     */
    private function formatJourFerie($jourFerie): array
    {
        return [
            'id' => $jourFerie->id,
            'nom' => $jourFerie->nom,
            'description' => $jourFerie->description,
            'date' => $jourFerie->date->format('Y-m-d'),
            'date_formatee' => $jourFerie->date_formatee,
            'jour_semaine' => $jourFerie->jour_semaine,
            'type' => $jourFerie->type,
            'recurrent' => $jourFerie->recurrent,
            'annee' => $jourFerie->annee,
            'couleur' => $jourFerie->couleur,
            'actif' => $jourFerie->actif,
            'est_weekend' => $jourFerie->estWeekEnd(),
            'jours_restants' => $jourFerie->jours_restants,
            'est_passe' => $jourFerie->date->isPast(),
            'created_at' => $jourFerie->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $jourFerie->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}