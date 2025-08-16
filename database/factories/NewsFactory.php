<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(4);
        $user = User::whereIN('role', ['Admin', 'Sub Admin'])->inRandomOrder()->first() ?? User::factory()->create();

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => $this->faker->paragraphs(3, true),
            'media' => null,
            'status' => $this->faker->randomElement([0, 1]),
            'published_at' => function (array $attributes) {
                return $attributes['status'] === 1
                    ? $this->faker->dateTimeBetween('-1 year', 'now')
                    : null;
            },
            'user_id' => $user->id,
        ];
    }

    // State for published news
    public function published()
    {
        return $this->state([
            'status' => 1,
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ]);
    }

    // State for draft news
    public function draft()
    {
        return $this->state([
            'status' => 0,
            'published_at' => null,
        ]);
    }
}
