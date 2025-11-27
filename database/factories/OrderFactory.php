<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
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
            'user_id' => User::factory(),
            'total_amount' => fake()->randomFloat(2, 20000, 800000),
            'status' => fake()->randomElement(['pending', 'paid', 'shipped', 'canceled']),
        ];
    }
}
