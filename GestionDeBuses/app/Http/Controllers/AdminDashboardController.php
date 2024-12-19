<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Bus;
use App\Models\Viaje;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Obtenemos los datos reales de la base de datos
        $registeredDrivers = User::where('role', 'conductor')->count();
        $trips = Viaje::count();
        $registeredBuses = Bus::count();

        // Retorna una vista para el panel de administrador
        return Inertia::render('Admin/Dashboard', [
            'registeredDrivers' => $registeredDrivers,
            'trips' => $trips,
            'registeredBuses' => $registeredBuses,
        ]);
    }
}

