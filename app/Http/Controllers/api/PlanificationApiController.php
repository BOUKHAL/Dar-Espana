<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Planification;

class PlanificationApiController extends Controller
{
    /**
     * Get all planifications with centre & option
     */
    public function index()
    {
        $planifications = Planification::with(['centre', 'option'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $planifications
        ]);
    }

}
