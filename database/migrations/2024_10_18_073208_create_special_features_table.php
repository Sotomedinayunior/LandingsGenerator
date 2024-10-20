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
        Schema::create('special_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained('vehicles')->onDelete('cascade'); // Relación con vehículos
            $table->foreignId('feature_id')->constrained('features')->onDelete('cascade'); // Relación con features
            $table->boolean('value_override')->nullable(); // Valor personalizado para este vehículo
            $table->timestamps();

            // Opcional: Índices para mejorar el rendimiento
            $table->index('vehicle_id');
            $table->index('feature_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('special_features');
    }
};
