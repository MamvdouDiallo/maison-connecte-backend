<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SupportTicket>
 */
class SupportTicketFactory extends Factory
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
            'subject' => fake()->sentence(),
            'message' => fake()->paragraph(),
            'status' => fake()->randomElement(['open', 'pending', 'closed']),
            'files' => [],
        ];
    }
}
