<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RequestController;
use App\Events\DriverLocationUpdated;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//  default dashboard  Controller 
Route::get('/dashboard', [RequestController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile routes (Breeze default)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- Routes ---

    // 1. Resident Request Form
    Route::get('/submit-request', [RequestController::class, 'create'])->name('request.create');
    Route::post('/submit-request', [RequestController::class, 'store'])->name('request.store');

    // 2. Optimization Logic (Admin)
    Route::get('/optimize-route', [RequestController::class, 'optimizeRoute'])->name('route.optimize');

    // 3. Driver View (Map)
    Route::get('/driver/route/{id}', [RequestController::class, 'showRoute'])->name('route.show');

    // 4. Testing Real-time Tracking
    Route::get('/move-driver', function () {
        event(new DriverLocationUpdated(1, 6.9142, 79.8789));
        return "Driver moved to Borella!";
    });
});

require __DIR__.'/auth.php';