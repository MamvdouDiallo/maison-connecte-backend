<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quote>
 */
class QuoteFactory extends Factory
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
            'service_id' => Service::factory(),
            'customer_name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'custom_request' => fake()->paragraph(),
            'status' => fake()->randomElement(['pending', 'in_progress', 'done']),
        ];
    }
}
