<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PlanificationController;
use App\Http\Controllers\ParascolaireController;
use App\Http\Controllers\JoursFeriesController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\NotificationsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Redirection du dashboard vers planification
Route::get('/dashboard', function () {
    return redirect()->route('planification.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Routes Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes Planification
    Route::resource('planification', PlanificationController::class);
    Route::get('/planification/centre/{id}/options', [PlanificationController::class, 'getOptions'])->name('planification.options');

    // Routes Parascolaire
    Route::resource('parascolaire', ParascolaireController::class);

    // Routes Jours Fériés
    Route::resource('jours-feries', JoursFeriesController::class);

    // Routes Documents
    Route::resource('documents', DocumentsController::class);

    // Routes Notifications
    Route::resource('notifications', NotificationsController::class);
});

require __DIR__.'/auth.php';
