<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DriverDashboardController extends Controller
{
    public function index()
    {
        // Retorna una vista para el panel de administrador
        return Inertia::render('Driver/Dashboard', [
           
        ]);
    }
}
