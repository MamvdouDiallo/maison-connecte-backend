<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->unsignedSmallInteger('order')->default(0)->after('slug');
        });

        // Initialise l'ordre des 4 catégories existantes
        DB::table('categories')->where('slug', 'securite')->update(['order' => 1]);
        DB::table('categories')->where('slug', 'smart-home')->update(['order' => 2]);
        DB::table('categories')->where('slug', 'energie')->update(['order' => 3]);
        DB::table('categories')->where('slug', 'finitions')->update(['order' => 4]);
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('order');
        });
    }
};
