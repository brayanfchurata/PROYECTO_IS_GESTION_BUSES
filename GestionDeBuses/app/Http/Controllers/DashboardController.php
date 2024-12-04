<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Dashboard'); // Renderiza la vista del dashboard
    }
}
