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
            $table->string('name')->unique();
            $table->string('logo')->nullable();
            $table->string('color_primary', 7);
            $table->string('color_secondary', 7);
            $table->json('dynamic_fields')->nullable(); // Campo para datos dinámicos
            $table->boolean('published')->default(false);

            // Campos de etiquetas meta para SEO
            $table->string('meta_title', 255)->nullable(); // Título SEO
            $table->string('meta_description', 255)->nullable(); // Descripción SEO
            $table->string('meta_keywords', 255)->nullable(); // Palabras clave SEO
            $table->string('og_title', 255)->nullable(); // Título Open Graph
            $table->string('og_description', 255)->nullable(); // Descripción Open Graph
            $table->string('og_image', 255)->nullable(); // Imagen Open Graph
            $table->string('canonical_url', 255)->nullable(); // URL canónica
            $table->string('robots', 50)->default('index, follow')->nullable(); // Control de indexación y seguimiento

            // Campos adicionales sugeridos
            $table->string('favicon', 255)->nullable(); // URL del Favicon
            $table->string('default_language', 10)->nullable(); // Idioma predeterminado
            $table->text('hreflang_urls')->nullable(); // URLs alternas para otros idiomas
            $table->string('meta_image', 255)->nullable(); // Imagen predeterminada para SEO

            $table->timestamps();
            $table->softDeletes(); // Borrado suave

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
