<?php

use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\Api\JoursFeriesApiController;
use App\Http\Controllers\Api\ParascolaireApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PlanificationApiController;
use App\Http\Controllers\Api\StudentController;
use Illuminate\Support\Facades\File;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/planifications', [PlanificationApiController::class, 'index']);
Route::get('/parascolaires', [ParascolaireApiController::class, 'index']);
Route::get('/parascolaires/{id}', [ParascolaireApiController::class, 'show']);
Route::get('/parascolaires-stats', [ParascolaireApiController::class, 'stats']);
// routes/api.php
Route::get('/planifications/download/{file}', function ($file) {
    $path = storage_path('app/public/planifications/' . $file);

    if (!File::exists($path)) {
        return response()->json(['error' => 'File not found'], 404);
    }

    return response()->download($path, null, [
        'Content-Type' => 'application/pdf',
    ]);
})->name('api.planifications.download');



Route::prefix('jours-feries')->group(function () {
    // Dashboard data (overview)
    Route::get('dashboard', [JoursFeriesApiController::class, 'dashboard']);

    // Main list with filters and pagination
    Route::get('/', [JoursFeriesApiController::class, 'index']);

    // Calendar data for specific year
    Route::get('calendar/{annee?}', [JoursFeriesApiController::class, 'calendar']);

    // Holidays by month
    Route::get('by-month/{annee?}/{mois?}', [JoursFeriesApiController::class, 'byMonth']);

    // Upcoming holidays
    Route::get('upcoming', [JoursFeriesApiController::class, 'upcoming']);

    // Statistics
    Route::get('statistics', [JoursFeriesApiController::class, 'statistics']);

    // Check if specific date is a holiday
    Route::post('check-date', [JoursFeriesApiController::class, 'checkDate']);
    Route::get('check-date', [JoursFeriesApiController::class, 'checkDate']);
});

// Route::post('/students/generate', [StudentController::class, 'generate']);

Route::post('/login', [StudentController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [StudentController::class, 'logout']);
});


// routes/api.php
Route::prefix('documents')->group(function () {
    Route::get('/', [DocumentController::class, 'index']);
    Route::get('/niveau/{niveauId}', [DocumentController::class, 'getCoursByNiveau']);
    Route::get('/matiere/{matiereId}', [DocumentController::class, 'getCoursByMatiere']);

    // Route de téléchargement
    Route::get('/download/{file}', function ($file) {
        // Files are stored in 'cours' directory, not 'documents'
        $filename = basename($file);
        $path = storage_path('app/public/cours/' . $filename);

        if (!File::exists($path)) {
            return response()->json([
                'error' => 'File not found',
                'requested' => $file,
                'looked_for' => $filename,
                'path' => $path
            ], 404);
        }

        return response()->download($path, null, [
            'Content-Type' => 'application/pdf',
        ]);
    })->name('api.documents.download');
});
