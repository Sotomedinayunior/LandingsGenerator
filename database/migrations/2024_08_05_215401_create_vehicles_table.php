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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->unsignedBigInteger('id_landing');
            $table->double('price');
            $table->integer('luggage');
            $table->integer('people');
            $table->string('type_of_car');
            $table->boolean('bluetooth');
            $table->boolean('siriusxm');
            $table->boolean('manual');
            $table->boolean('automatic');
            $table->boolean('cvt');
            $table->json('dynamic_fields')->nullable(); // Campo para datos dinámicos
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraint
            $table->foreign('id_landing')->references('id')->on('landings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
