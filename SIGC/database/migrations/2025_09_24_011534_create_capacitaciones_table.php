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
        Schema::create('capacitaciones', function (Blueprint $table) {
            $table->id();
            $table->string('tematica'); // Campo para el tema de la capacitación
            $table->string('nombre'); // Nombre o título de la capacitación
            $table->text('descripcion')->nullable(); // Descripción detallada
            $table->enum('modalidad', ['presencial', 'virtual', 'hibrida']); // Modalidad de la capacitación
            $table->date('fecha_inicio'); // Fecha de inicio
            $table->date('fecha_fin'); // Fecha de finalización
            $table->time('hora_inicio')->nullable(); // Hora de inicio (opcional)
            $table->time('hora_fin')->nullable(); // Hora de finalización (opcional)
            $table->unsignedInteger('cupos'); // Número total de cupos disponibles
            $table->unsignedInteger('cupos_disponibles')->default(0); // Número de cupos que quedan
            $table->string('imagen_destacada')->nullable(); // Una imagen para la capacitación
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('capacitaciones');
    }
};
