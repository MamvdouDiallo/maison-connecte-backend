<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('project_services')) {
            return;
        }

        Schema::create('project_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->enum('service', ['security', 'automation', 'solar', 'finishing']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_services');
    }
};
