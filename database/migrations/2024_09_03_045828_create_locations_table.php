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
        Schema::create('locations', function (Blueprint $table) {
            $table->id(); // id (auto increment)

            // Campos definidos para la tabla
            $table->string('place_of_departure')->nullable(); // Lugar de salida
            $table->string('arrival_place')->nullable(); // Lugar de llegada
            $table->integer('number_of_persons')->nullable(); // Número de personas
            $table->date('date_of_departure')->nullable(); // Fecha de salida
            $table->time('time_of_departure')->nullable(); // Hora de salida
            $table->date('date_of_arrival')->nullable(); // Fecha de llegada
            $table->time('time_of_arrival')->nullable(); // Hora de llegada

            // Relación con la tabla `landings`
            $table->unsignedBigInteger('id_landing'); // Relación con `landings`
            $table->foreign('id_landing')->references('id')->on('landings')->onDelete('cascade');

            // Campos automáticos
            $table->timestamps(); // created_at, updated_at
            $table->softDeletes(); // deleted_at (borrado suave)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
