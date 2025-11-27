<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pack;
use App\Models\Product;

class PackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // public function run(): void
    // {
    //     //
    // }
    public function run()
    {
        $packs = Pack::factory(6)->create();

        foreach ($packs as $pack) {
            $products = Product::inRandomOrder()->take(rand(3, 8))->get();
            $pack->products()->attach($products->pluck('id'));
        }
    }
}
