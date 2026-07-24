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
        Schema::create('site_visits', function (Blueprint $table) {
            $table->id();
            $table->string('visitor_id', 64);
            $table->string('path', 255)->nullable();
            $table->timestamps();

            $table->index(['visitor_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_visits');
    }
};
