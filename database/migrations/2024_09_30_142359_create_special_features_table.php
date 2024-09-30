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
            $table->unsignedBigInteger('vehicle_id'); // Relación con la tabla vehicles
            $table->json('features'); // Campo JSON para almacenar los campos dinámicos
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
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

