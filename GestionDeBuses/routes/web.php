<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\DriverDashboardController;
use App\Http\Controllers\MaintenanceDashboardController;
use App\Http\Controllers\PassengerDashboardController;
use App\Http\Controllers\BusController;
use App\Http\Controllers\AdminCoductoresController;
use App\Http\Controllers\AdminViajesController;
use App\Http\Controllers\ViajeController;
use App\Http\Controllers\ConductorViajesController;
use App\Http\Controllers\ConductorReorteController;
use App\Http\Controllers\MantenimientoPersonalController;
use App\Http\Controllers\PassengerBuscarController;





Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//roles especificos
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/driver/dasboard', [DriverDashboardController::class, 'index'])->name('driver.dasboard');
Route::get('/passenger/dashboard', [PassengerDashboardController::class, 'index'])->name('passenger.dashboard');
Route::get('/maintenance/dashboard', [MaintenanceDashboardController::class, 'index'])->name('maintenance.dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('Admin/Dasboard')->group(function(){
    Route::get('Admin',[BusController::class,'index'])->name('admin.bus');
    Route::get('Admin/FormularioBus',[BusController::class,'create'])->name('Admin.FormularioBus');
   Route::post('Admin',[BusController:: class, 'store'])->name('Admin.store');
});

Route::get('/admin/conductores', [AdminCoductoresController::class, 'index'])->name('admin.conductores');



Route::prefix('admin/dashboard')->name('admin.')->group(function () {
    Route::get('viajes', [ViajeController::class, 'index'])->name('viajes');
    Route::get('viajes/create', [ViajeController::class, 'create'])->name('formularioViaje');
    Route::post('viajes', [ViajeController::class, 'store'])->name('viajes.store');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/Driver/ConductorRutas', [ConductorViajesController::class, 'index'])->name('driver.conductorRutas');
});

Route::middleware('auth')->group(function() {
    Route::get('/driver/conductorRutas', [ConductorViajesController::class, 'index']);
    
    // Esta línea debería tener 'patch'
    Route::patch('/driver/conductorRutas/{id}', [ConductorViajesController::class, 'cambiarEstado'])->name('driver.cambiarEstado');

});
//------------------------------


// Ruta para reportar un problema técnico


Route::get('/reportar-problema/{viajeId}', function ($viajeId) {
    $viaje = App\Models\Viaje::findOrFail($viajeId);
    return Inertia::render('Driver/ReportarProblema', [
        'viaje' => $viaje,
    ]);
})->name('driver.reportarProblema');



Route::middleware(['auth'])->group(function () {
    // Ruta para mostrar el formulario de reporte
    Route::get('/conductor/reportar-problema', [ConductorReorteController::class, 'create'])->name('driver.reportarProblema.create');
    
    // Ruta para almacenar el reporte
    Route::post('/conductor/reportar-problema', [ConductorReorteController::class, 'store'])->name('driver.reportarProblema.store');
});


Route::get('/maintenance', [MantenimientoPersonalController::class, 'index'])->name('maintenance.mantenimiento');
Route::patch('/maintenance/{id}/estado', [MantenimientoPersonalController::class, 'updateEstado'])->name('maintenance.updateEstado');




// web.php


Route::post('/Passenger/BuscarRuta', [PassengerBuscarController::class, 'buscarRuta'])->name('passenger.buscarRuta');

require __DIR__.'/auth.php';
