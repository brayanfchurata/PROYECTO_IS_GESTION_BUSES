<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;


class AdminDashboardController extends Controller
{
    //
    public function index()
    {
        // Retorna una vista para el panel de administrador
        return Inertia::render('Admin/Dashboard', [
            
        ]);
    }
}
