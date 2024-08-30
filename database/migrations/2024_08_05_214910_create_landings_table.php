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
        Schema::create('landings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_users_landing');
            $table->string('name');
            $table->string('logo')->nullable();
            $table->string('color_primary', 7);
            $table->string('color_secondary', 7);
            $table->string('place_of_departure')->nullable();
            $table->string('arrival_place')->nullable();
            $table->integer('seats')->nullable();
            $table->date('date_of_departure')->nullable();
            $table->time('time_of_departure')->nullable();
            $table->date('date_of_arrival')->nullable();
            $table->time('time_of_arrival')->nullable(); 
            $table->json('dynamic_fields')->nullable(); // Campo para datos dinámicos
            $table->boolean('published')->default(false);
          
            $table->timestamps();
            $table->softDeletes();//borrado suave

            // Foreign key constraint
            $table->foreign('id_users_landing')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landings');
    }
};
