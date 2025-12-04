<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quote_requests', function (Blueprint $table) {
            $table->id();

            // Step 1
            $table->string('service_type');
            $table->string('residence_type');
            $table->date('estimated_date');

            // Step 2 - Project Types
            $table->boolean('security_electronic');
            $table->boolean('smart_home');
            $table->boolean('solar_installation');
            $table->boolean('premium_finishes');
            $table->boolean('complete_project');

            // Installation Details
            $table->string('property_type');
            $table->string('address');
            $table->string('surface');
            $table->string('floors');
            $table->string('current_state');
            $table->text('project_needs')->nullable();
            $table->string('budget');
            $table->date('intervention_date')->nullable();

            // Step 3 - User Info
            $table->string('name');
            $table->string('phone');
            $table->string('email');

            // Files
            $table->json('files')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quote_requests');
    }
};
