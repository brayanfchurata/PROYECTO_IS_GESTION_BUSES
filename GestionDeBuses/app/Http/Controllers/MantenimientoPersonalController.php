<?php
namespace App\Http\Controllers;

use App\Models\Reporte;
use Inertia\Inertia;
use Illuminate\Http\Request;

class MantenimientoPersonalController extends Controller
{
    public function index()
    {
        $reportes = Reporte::with(['viaje.conductor', 'viaje.bus'])->get(); return Inertia::render('Maintenance/Mantenimiento', [ 'reportes' => $reportes ]);
    }
    public function updateEstado(Request $request, $id) { $reporte = Reporte::findOrFail($id); $reporte->estado = $request->input('estado'); $reporte->save(); return redirect()->route('maintenance.mantenimiento'); }
}
