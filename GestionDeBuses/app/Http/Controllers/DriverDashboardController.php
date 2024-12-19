<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Viaje;

class DriverDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Obtener los viajes asignados al conductor logueado
        $viajes = Viaje::where('user_id', $user->id)->with('bus')->get();

        // Contar los viajes asignados
        $viajesCount = $viajes->count();

        // Retorna una vista para el panel del conductor
        return Inertia::render('Driver/Dasboard', [
            'viajes' => $viajes,
            'viajesCount' => $viajesCount,
        ]);
    }
}

