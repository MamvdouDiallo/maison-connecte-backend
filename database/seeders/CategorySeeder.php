<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Category;

class CategorySeeder extends Seeder
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
        $categories = [
            ['name' => 'Solaire', 'slug' => 'solaire'],
            ['name' => 'Domotique', 'slug' => 'domotique'],
            ['name' => 'Sécurité', 'slug' => 'securite'],
        ];

        foreach ($categories as $item) {
            Category::create($item);
        }
    }
}
