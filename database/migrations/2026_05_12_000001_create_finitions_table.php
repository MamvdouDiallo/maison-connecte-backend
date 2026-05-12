<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('finitions', function (Blueprint $table) {
            $table->id();
            $table->json('titre');
            $table->json('description');
            $table->string('photo');
            $table->json('galerie')->nullable();
            $table->enum('categorie', ['peinture', 'carrelage', 'menuiserie', 'design', 'plafonds']);
            $table->integer('ordre')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('finitions');
    }
};
