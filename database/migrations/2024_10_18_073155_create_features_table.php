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
        Schema::create('features', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nombre del feature, por ejemplo 'Bluetooth'
            $table->string('description')->nullable(); // Descripción del feature
            $table->timestamps();

            // Índice en el nombre para mejorar el rendimiento en búsquedas
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('features');
    }
};
