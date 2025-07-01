<?php

namespace Database\Factories;

use App\Enums\RoleEnum;
use App\Models\School;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create(['role' => RoleEnum::STUDENT])->id,
            'school_id' => School::inRandomOrder()->first()->id ?? School::factory()->create()->id,
            'grade' => Arr::random(['10', '11', '12']),
            'birth_date' => now()->subYears(rand(15, 18))->subMonths(rand(0, 11))->subDays(rand(0, 28)),
            'gender' => Arr::random(['male', 'female']),
            'avatar' => null,
        ];
    }
}
