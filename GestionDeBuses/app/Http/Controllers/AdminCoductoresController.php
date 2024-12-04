<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;

class AdminCoductoresController extends Controller
{
    public function index()
    {
        // Obtener la lista de conductores
        $conductores = User::where('role', 'conductor')->get();

        // Enviar los datos al componente Vue
        return Inertia::render('Admin/Conductores', [
            'conductores' => $conductores,
        ]);
    }
}
