<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Viaje;
use App\Models\Reporte;
use Inertia\Inertia;

class ConductorReorteController extends Controller
{
    // Método para mostrar el formulario
    public function create()
    {
        $user = auth()->user();

    // Recupera el viaje asignado al conductor
    $viaje = Viaje::where('user_id', $user->id)->first();

    if (!$viaje) {
        return redirect()->route('driver.conductorRutas')->with('error', 'No tienes un viaje asignado.');
    }

    // Pasa el viaje al componente Inertia
    return Inertia::render('Driver/ReportarProblema', [
        'viaje' => $viaje, // Aquí pasamos el viaje a Vue
    ]);
    }

    // Método para almacenar el reporte en la base de datos
    public function store(Request $request)
{
    // Validar los datos
    $validated = $request->validate([
        'descripcion' => 'required|string|max:255',
        'estado' => 'required|string',
        'lugar' => 'required|string|max:255',
        'observaciones' => 'nullable|string|max:255',
        'viaje_id' => 'required|exists:viajes,id',  // Validar que el 'viaje_id' exista en la tabla 'viajes'
    ]);

    // Guardar el reporte
    Reporte::create([
        'viaje_id' => $validated['viaje_id'],
        'usuario_id' => auth()->user()->id,  // Asegúrate de que el usuario esté autenticado
        'descripcion' => $validated['descripcion'],
        'estado' => $validated['estado'],
        'lugar' => $validated['lugar'],
        'observaciones' => $validated['observaciones'],
        'fecha_reportado' => now(),
    ]);

    // Redirigir a una página después de guardar el reporte
    return redirect()->route('driver.conductorRutas');
}


}
