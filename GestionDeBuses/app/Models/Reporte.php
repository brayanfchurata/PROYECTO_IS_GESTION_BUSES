<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    protected $table = 'reportes';  // Especifica la tabla si no sigue las convenciones de Laravel
    protected $fillable = [
        'viaje_id', 'usuario_id', 'descripcion', 'estado', 'lugar', 'observaciones', 'fecha_reportado'
    ];

    // Relación con el modelo Viaje
    public function viaje()
    {
        return $this->belongsTo(Viaje::class);
    }

    // Relación con el modelo User (conductor que reporta)
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
