<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Viaje extends Model
{
     // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'bus_id',
        'user_id',
        'motivo_viaje',
        'origen_viaje',
        'destinatario',
        'fecha_hora_inicio',
        'fecha_hora_llegada',
    ];

    // Relación con el modelo Bus (Autobús)
    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    // Relación con el modelo User (Conductor)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
