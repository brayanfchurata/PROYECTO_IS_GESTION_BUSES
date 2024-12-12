<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Viaje; // Asegúrate de incluir esto


class ConductorViajesController extends Controller
{
    public function index(Request $request)
    {
        // Obtener al usuario autenticado
        $user = auth()->user();

        // Verificar que el usuario sea conductor
        if ($user->role !== 'conductor') {
            return redirect()->back()->with('error', 'Acceso no autorizado');
        }

        // Obtener los viajes con los buses relacionados
        $viajes = $user->viajes()->with('bus')->get();  // Relacionar con los buses

        // Obtener los buses relacionados con el conductor
        $buses = $user->buses;

        // Enviar los datos a la vista Inertia
        return Inertia::render('Driver/ConductorRutas', [
            'viajes' => $viajes,
            'buses' => $buses,
            'conductor' => $user, // Datos del conductor si es necesario
        ]);
    }

    public function cambiarEstado(Request $request, $id)
    {
        // Validar el estado
        $request->validate([
            'estado' => 'required|string|in:terminado,en_proceso',
        ]);

        // Buscar el viaje por ID
        $viaje = Viaje::findOrFail($id);

        // Opcional: Verificar si el usuario autenticado es el conductor del viaje
        if ($viaje->user_id !== auth()->id()) {
            return response()->json(['error' => 'No tienes permiso para actualizar este viaje.'], 403);
        }

        // Actualizar el estado del viaje
        $viaje->estado = $request->estado;
        $viaje->save();

        // Devolver una respuesta de Inertia para actualizar la vista sin recargar
        return Inertia::render('driver/ConductorViajes', [
            'viajes' => Viaje::where('user_id', auth()->id())->get(),  // Puedes actualizar los datos aquí si es necesario
            'success' => 'Estado del viaje actualizado correctamente.',
        ]);
    }

}
