<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'uuid' => (string) Str::uuid(),
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(2),
            'subscription_deadline' => now()->addDays(rand(1, 10)),
            'payment_deadline' => now()->addDays(rand(11, 20)),
            'banner_url' => $this->faker->imageUrl(600, 400, 'event'),
            'estimated_value' => $this->faker->randomFloat(2, 50, 500),
            'cancellation_date' => null,
            'cancellation_description' => null,
        ];
    }
}
