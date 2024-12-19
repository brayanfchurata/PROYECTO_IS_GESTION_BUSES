<?php
// PassengerBuscarController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Viaje;
use Inertia\Inertia;

class PassengerBuscarController extends Controller
{
    public function buscarRuta(Request $request)
    {
        // Validar la entrada
        $request->validate([
            'codigo' => 'required|string',
        ]);

        // Buscar el viaje por el código
        $codigo = $request->input('codigo'); // Obtener el parámetro de la solicitud POST
        $viaje = Viaje::where('codigo', $codigo)->with(['bus', 'conductor'])->firstOrFail();

        // Retornar la vista con los detalles del viaje
        return Inertia::render('ViajeShow', ['viaje' => $viaje]);
    }
}

