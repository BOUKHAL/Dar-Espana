<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Parascolaire;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ParascolaireApiController extends Controller
{
    /**
     * Get paginated list of parascolaire events with filters
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Parascolaire::query();
            
            // Search functionality
            if ($request->filled('search')) {
                $searchTerm = $request->search;
                $query->where(function($q) use ($searchTerm) {
                    $q->where('nom_evenement', 'like', '%' . $searchTerm . '%')
                      ->orWhere('lieu', 'like', '%' . $searchTerm . '%')
                      ->orWhere('description', 'like', '%' . $searchTerm . '%');
                });
            }
            
            // Status filter (future/past events)
            if ($request->filled('status')) {
                if ($request->status === 'futur') {
                    $query->where('jour_evenement', '>', now());
                } elseif ($request->status === 'passe') {
                    $query->where('jour_evenement', '<=', now());
                }
            }
            
            // Month filter
            if ($request->filled('month')) {
                $query->whereMonth('jour_evenement', $request->month);
            }
            
            // Year filter (additional useful filter for API)
            if ($request->filled('year')) {
                $query->whereYear('jour_evenement', $request->year);
            }
            
            // Sorting
            $sortBy = $request->get('sort', 'jour_evenement');
            $sortOrder = $request->get('order', 'desc');
            
            $allowedSortFields = ['nom_evenement', 'jour_evenement', 'lieu', 'created_at'];
            
            if (in_array($sortBy, $allowedSortFields)) {
                $query->orderBy($sortBy, $sortOrder);
            } else {
                $query->orderBy('jour_evenement', 'desc');
            }
            
            // Pagination
            $perPage = $request->get('per_page', 9);
            $perPage = min(max($perPage, 1), 50); // Limit between 1 and 50
            
            $parascolaires = $query->paginate($perPage);
            
            // Transform the data for better API response
            $transformedData = $parascolaires->getCollection()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nom_evenement' => $item->nom_evenement,
                    'jour_evenement' => $item->jour_evenement,
                    'lieu' => $item->lieu,
                    'description' => $item->description,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                    // Add computed fields that might be useful for React
                    'is_future' => $item->jour_evenement > now(),
                    'formatted_date' => $item->jour_evenement ? $item->jour_evenement->format('Y-m-d') : null,
                    'formatted_datetime' => $item->jour_evenement ? $item->jour_evenement->format('Y-m-d H:i:s') : null,
                ];
            });
            
            return response()->json([
                'success' => true,
                'data' => $transformedData,
                'pagination' => [
                    'current_page' => $parascolaires->currentPage(),
                    'last_page' => $parascolaires->lastPage(),
                    'per_page' => $parascolaires->perPage(),
                    'total' => $parascolaires->total(),
                    'from' => $parascolaires->firstItem(),
                    'to' => $parascolaires->lastItem(),
                    'has_more_pages' => $parascolaires->hasMorePages(),
                ],
                'filters' => [
                    'search' => $request->search,
                    'status' => $request->status,
                    'month' => $request->month,
                    'year' => $request->year,
                    'sort' => $sortBy,
                    'order' => $sortOrder,
                ]
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving parascolaire events',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }
    
    /**
     * Get a single parascolaire event
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $parascolaire = Parascolaire::findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $parascolaire->id,
                    'nom_evenement' => $parascolaire->nom_evenement,
                    'jour_evenement' => $parascolaire->jour_evenement,
                    'lieu' => $parascolaire->lieu,
                    'description' => $parascolaire->description,
                    'created_at' => $parascolaire->created_at,
                    'updated_at' => $parascolaire->updated_at,
                    'is_future' => $parascolaire->jour_evenement > now(),
                    'formatted_date' => $parascolaire->jour_evenement ? $parascolaire->jour_evenement->format('Y-m-d') : null,
                    'formatted_datetime' => $parascolaire->jour_evenement ? $parascolaire->jour_evenement->format('Y-m-d H:i:s') : null,
                ]
            ], 200);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Parascolaire event not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving parascolaire event',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }
    
    /**
     * Get statistics for dashboard
     *
     * @return JsonResponse
     */
    public function stats(): JsonResponse
    {
        try {
            $total = Parascolaire::count();
            $future = Parascolaire::where('jour_evenement', '>', now())->count();
            $past = Parascolaire::where('jour_evenement', '<=', now())->count();
            $thisMonth = Parascolaire::whereMonth('jour_evenement', now()->month)
                                   ->whereYear('jour_evenement', now()->year)
                                   ->count();
            
            return response()->json([
                'success' => true,
                'data' => [
                    'total_events' => $total,
                    'future_events' => $future,
                    'past_events' => $past,
                    'this_month_events' => $thisMonth,
                    'completion_rate' => $total > 0 ? round(($past / $total) * 100, 2) : 0,
                ]
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving statistics',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }
}