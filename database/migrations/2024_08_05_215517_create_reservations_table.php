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
            $table->string('name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('id_vehicle');
            $table->string('place_of_departure');
            $table->string('arrival_place');
            $table->integer('number_of_persons');
            $table->date('date_of_departure');
            $table->time('time_of_departure');
            $table->date('date_of_arrival');
            $table->time('time_of_arrival');
            $table->integer('total_price');
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
