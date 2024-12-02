<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\DriverDashboardController;
use App\Http\Controllers\MaintenanceDashboardController;
use App\Http\Controllers\PassengerDashboardController;



Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    // Verifica el rol del usuario autenticado
    $user = auth()->user();
    
    // Redirige al dashboard correspondiente según el rol
    if ($user->role == 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role == 'driver') {
        return redirect()->route('driver.dashboard');
    } elseif ($user->role == 'passenger') {
        return redirect()->route('passenger.dashboard');
    } elseif ($user->role == 'maintenance') {
        return redirect()->route('maintenance.dashboard');
    }

    // Si no se encuentra un rol válido, puedes redirigir a la página de inicio o mostrar un error
    return redirect('/'); // Redirige a la página principal si no tiene un rol válido
})->middleware(['auth', 'verified'])->name('dashboard');


//roles especificos
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/driver/dashboard', [DriverDashboardController::class, 'index'])->name('driver.dashboard');
Route::get('/passenger/dashboard', [PassengerDashboardController::class, 'index'])->name('passenger.dashboard');
Route::get('/maintenance/dashboard', [MaintenanceDashboardController::class, 'index'])->name('maintenance.dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
