<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use App\Models\EventParticipant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EventParticipant>
 */
class EventParticipantFactory extends Factory
{
    protected $model = EventParticipant::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'event_id' => Event::factory(),
            'arrival_date' => null,
        ];
    }

    /**
     * Indicate that the participant has arrived.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function arrived()
    {
        return $this->state(function (array $attributes) {
            return [
                'arrival_date' => now(),
            ];
        });
    }
}
