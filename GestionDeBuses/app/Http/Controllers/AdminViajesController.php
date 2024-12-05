<?php
namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\User; // Asegúrate de importar el modelo User
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Viaje;

class AdminViajesController extends Controller
{
    public function index()
    {
        // Obtener todos los buses y conductores registrados
        $buses = Bus::all();  // Suponiendo que tienes una tabla llamada buses
        $conductores = User::where('role', 'conductor')->get();  // Ajusta esto según cómo manejas los conductores

        // Pasar los datos a la vista de Inertia
        return Inertia::render('Admin/Viajes', [
            'buses' => $buses,
            'conductores' => $conductores
        ]);
    }

    public function create()
    {
        // Obtener todos los buses y conductores registrados
        $buses = Bus::all();  // Suponiendo que tienes una tabla llamada buses
        $conductores = User::where('role', 'conductor')->get();  // Ajusta esto según cómo manejas los conductores

        // Regresar a la vista para crear un viaje, pasando los buses y conductores
        return Inertia::render('Admin/Viajes/Create', [
            'buses' => $buses,
            'conductores' => $conductores
        ]);
    }
    public function store(Request $request)
    {
        // Validar los datos recibidos
        $request->validate([
            'bus_id' => 'required|exists:buses,id',
            'user_id' => 'required|exists:users,id',
            'motivo_viaje' => 'required|string',
            'origen_viaje' => 'required|string',
            'destinatario' => 'required|string',
            'fecha_hora_inicio' => 'required|date',
            'fecha_hora_llegada' => 'nullable|date',
        ]);

        // Crear un nuevo registro de viaje
        Viaje::create([
            'bus_id' => $request->bus_id,
            'user_id' => $request->user_id,
            'motivo_viaje' => $request->motivo_viaje,
            'origen_viaje' => $request->origen_viaje,
            'destinatario' => $request->destinatario,
            'fecha_hora_inicio' => $request->fecha_hora_inicio,
            'fecha_hora_llegada' => $request->fecha_hora_llegada,
        ]);

        // Redirigir o devolver una respuesta después de crear el viaje
        return redirect()->route('admin.viajes')->with('success', 'Viaje creado con éxito');
    }
}
