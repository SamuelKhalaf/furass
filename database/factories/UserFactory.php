<?php

namespace Database\Factories;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'phone_number' => $this->faker->unique()->phoneNumber(),
            'remember_token' => Str::random(10),
            'role' => Arr::random([RoleEnum::ADMIN, RoleEnum::SCHOOL, RoleEnum::STUDENT, RoleEnum::SUB_ADMIN, RoleEnum::CONSULTANT]),
            'is_active' => Arr::random([true, false]),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (User $user) {
            match ($user->role) {
                RoleEnum::ADMIN => $user->assignRole(RoleEnum::ADMIN),
                RoleEnum::SCHOOL => $user->assignRole(RoleEnum::SCHOOL),
                RoleEnum::STUDENT => $user->assignRole(RoleEnum::STUDENT),
                RoleEnum::SUB_ADMIN => $user->assignRole(RoleEnum::SUB_ADMIN),
                RoleEnum::CONSULTANT => $user->assignRole(RoleEnum::CONSULTANT),
                default => null,
            };
        });
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
