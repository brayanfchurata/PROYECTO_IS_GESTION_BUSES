<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('viajes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('bus_id')->constrained('buses')->onDelete('cascade'); // Relación con autobuses
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relación con el usuario/conductor
            $table->string('motivo_viaje', 255); // Motivo del viaje
            $table->string('origen_viaje', 255); // Lugar de origen
            $table->string('destinatario', 255); // Destinatario (lugar o persona)
            $table->timestamp('fecha_hora_inicio')->nullable(); // Fecha y hora de inicio del viaje
            $table->timestamp('fecha_hora_llegada')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('viajes');
    }
};
