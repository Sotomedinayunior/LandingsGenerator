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
            $table->string('color_primary', 15);
            $table->string('color_secondary', 15);
            $table->string('color_tertiary', 15);
            $table->boolean('published')->default(false);
            $table->timestamps();
            $table->softDeletes();

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
