<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-60 days', 'now');
        $endDate = (clone $startDate)->modify('+' . rand(1, 5) . ' hours');


        return [
            'event_name'     => $this->faker->sentence(3),
            'company_name'   => $this->faker->company,
            'location'       => $this->faker->city,
            'start_date'     => $startDate,
            'end_date'       => $endDate,
            'description'    => $this->faker->paragraph,
            'event_type'     => $this->faker->randomElement(['trip', 'workshop']),
        ];
    }
}
