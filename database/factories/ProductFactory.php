<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    // public function definition(): array
    // {
    //     return [
    //         //
    //     ];
    // }
      public function definition()
    {
        return [
            'category_id'    => Category::factory(),
            'subcategory_id' => SubCategory::factory(),
            'title'         => fake()->sentence(3),
            'description'   => fake()->paragraph(),
            'price'         => fake()->randomFloat(2, 15000, 500000),
            'image'         => 'https://picsum.photos/600/400',
            'link'          => fake()->url(),
            'highlights'    => [fake()->sentence(), fake()->sentence()],
            'specs'         => [
                "puissance" => fake()->numberBetween(100, 500) . "W",
                "tension"   => fake()->randomElement(["12V", "24V"]),
            ],
        ];
    }
}
