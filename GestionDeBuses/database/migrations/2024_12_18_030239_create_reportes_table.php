<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('reportes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('viaje_id'); // Relación con el viaje
            $table->unsignedBigInteger('usuario_id'); // Relación con el conductor
            $table->text('descripcion'); // Descripción del problema
            $table->string('estado'); // Estado del reporte (leve, fatal, etc.)
            $table->string('lugar'); // Lugar donde ocurrió el problema
            $table->text('observaciones')->nullable(); // Observaciones adicionales (opcional)
            $table->timestamp('fecha_reportado')->useCurrent(); // Fecha del reporte, por defecto será la actual
            $table->timestamps();

            // Definición de las llaves foráneas
            $table->foreign('viaje_id')->references('id')->on('viajes')->onDelete('cascade');
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('reportes');
    }
};
