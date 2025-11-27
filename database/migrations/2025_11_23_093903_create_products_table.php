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

//     Schema::create('products', function (Blueprint $table) {
//           $table->id();
//     $table->unsignedBigInteger('category_id');
//     $table->unsignedBigInteger('subcategory_id');
//     $table->string('title');
//     $table->text('description')->nullable();
//     $table->float('price');
//     $table->string('image');
//     $table->string('link')->nullable();
//     $table->json('highlights')->nullable();
//     $table->json('specs')->nullable();
//     $table->timestamps();

//     $table->foreign('category_id')->references('id')->on('categories');
//     $table->foreign('subcategory_id')->references('id')->on('sub_categories');
// });
Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
    $table->foreignId('subcategory_id')->constrained('sub_categories')->cascadeOnDelete();
    
    $table->string('title');
    $table->text('description')->nullable();
    $table->float('price');
    $table->string('image');
    $table->string('link')->nullable();
    $table->json('highlights')->nullable();
    $table->json('specs')->nullable();
    $table->timestamps();
});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
