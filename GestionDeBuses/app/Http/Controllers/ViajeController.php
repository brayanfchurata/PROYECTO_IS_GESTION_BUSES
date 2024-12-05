<?php

namespace App\Http\Controllers;

use App\Models\Viaje;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Bus;
use App\Models\User; 


class ViajeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $viajes = Viaje::with(['bus', 'user'])->get();

    return Inertia::render('Admin/Viajes', [
        'viajes' => $viajes, // Pasa los viajes a la vista de Inertia
    ]);

    
    }

    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $buses = Bus::all();

        // Obtener todos los usuarios con el rol de conductor
        $conductores = User::where('role', 'conductor')->get();

        


        return Inertia::render('Admin/FormularioViaje', [
            'buses' => $buses,
            'conductores' => $conductores,
        ]);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'bus_id' => 'required|exists:buses,id',
            'user_id' => 'required|exists:users,id',  // Corrige si la relación es con 'users'
            'motivo_viaje' => 'required|string',
            'origen_viaje' => 'required|string',
            'destinatario' => 'required|string',
            'fecha_hora_inicio' => 'required|date',
            'fecha_hora_llegada' => 'nullable|date',
        ]);
    
        // Si la validación pasa, guardamos el viaje
        try {
            Viaje::create($validated);
        } catch (\Exception $e) {
            // Manejo de excepciones, si algo falla
            return redirect()->back()->withErrors('Error al guardar el viaje.')->withInput();
        }
    
        // Redirigir al listado de viajes
        return redirect()->route('admin.viajes')->with('success', 'Viaje asignado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Viaje $viaje)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Viaje $viaje)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Viaje $viaje)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Viaje $viaje)
    {
        //
    }
}
