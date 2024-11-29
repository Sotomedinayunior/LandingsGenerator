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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('avatar_url')->nullable(); // Campo para almacenar el enlace del avatar

            $table->string('name');
            $table->string('last_name');
            $table->string('phone' , 25);
            $table->string('email')->unique();

            $table->text('description')->nullable();
            $table->unsignedBigInteger('id_vehicle');
            $table->string('place_of_departure');
            $table->string('arrival_place');
            $table->date('date_of_departure');
            $table->time('time_of_departure');
            $table->date('date_of_arrival');
            $table->time('time_of_arrival');
            $table->integer('total_price')->nullable();
            $table->string('name_landing');
            
            $table->string('url_landing');
            $table->string('url_vehicle');
            $table->string('number_person');
            $table->string('number_bag');

            $table->unsignedBigInteger('id_landing');
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('id_vehicle')->references('id')->on('vehicles')->onDelete('cascade');
            $table->foreign('id_landing')->references('id')->on('landings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
