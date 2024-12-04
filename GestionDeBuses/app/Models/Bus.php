<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    protected $fillable=[
        'placa',
        'Marca',
        'Modelo',
        'Capacidad',
        'user_id',
        
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');  // Relación inversa
    }
}
