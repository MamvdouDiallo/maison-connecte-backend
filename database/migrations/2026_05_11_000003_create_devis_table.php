<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('devis', function (Blueprint $table) {
            $table->id();
            $table->boolean('security_electronic')->default(false);
            $table->boolean('smart_home')->default(false);
            $table->boolean('solar_installation')->default(false);
            $table->boolean('premium_finishes')->default(false);
            $table->boolean('complete_project')->default(false);
            $table->string('property_type')->nullable();
            $table->string('address')->nullable();
            $table->string('surface')->nullable();
            $table->string('floors')->nullable();
            $table->string('current_state')->nullable();
            $table->text('project_needs')->nullable();
            $table->string('budget')->nullable();
            $table->date('intervention_date')->nullable();
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('devis');
    }
};
