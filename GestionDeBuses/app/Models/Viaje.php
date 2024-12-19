<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
        'estado',
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
    
    public function reportes()
    {
        return $this->hasMany(Reporte::class, 'viaje_id');
    }
    
    public function conductor() { return $this->belongsTo(User::class, 'user_id');
    }
       
    protected static function boot() { parent::boot(); static::creating(function ($model) { $model->codigo = Str::random(4);});} // Generar código único de 4 caracteres alfanuméricos }); }
    


}
