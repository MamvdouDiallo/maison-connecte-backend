<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;

class SubCategorySeeder extends Seeder
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
        $map = [
            'solaire' => ['panneaux', 'batteries', 'onduleurs', 'accessoires'],
            'domotique' => ['capteurs', 'actionneurs', 'automatisation'],
            'securite' => ['cameras', 'detecteurs', 'alarmes'],
        ];

        foreach ($map as $categorySlug => $subcats) {
            $category = Category::where('slug', $categorySlug)->first();

            foreach ($subcats as $sub) {
                SubCategory::create([
                    'category_id' => $category->id,
                    'name' => ucfirst($sub),
                    'slug' => Str::slug($sub),
                ]);
            }
        }
    }
}
