<?php

namespace Database\Factories;

use App\Enums\RoleEnum;
use App\Models\Notification;
use App\Models\NotificationStatus;
use App\Models\NotificationTarget;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NotificationFactory extends Factory
{
    protected $model = Notification::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->words(3,true),
            'body' => $this->faker->sentence(6),
            'meta' => [
                'type' => $this->faker->randomElement(['warning', 'success', 'info']),
                'attachments' => collect(range(1, rand(1, 5)))->map(function () {
                    $filename = Str::random(10) . '.jpg';
                    $path = 'uploads/fake/' . $filename;

                    return [
                        'path' => $path,
                        'url' => Storage::url($path),
                    ];
                })->toArray(),
                'link' => $this->faker->url,
            ],
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Notification $notification) {
            // Create users if not exist
            $users = User::whereIn('role',[RoleEnum::ADMIN,RoleEnum::SUB_ADMIN])->inRandomOrder()->take(3)->get();

//            if ($users->count() < 3) {
//                $users = User::factory()->count(3)->create();
//            }

            // Add a polymorphic target (just using user for now)
            NotificationTarget::create([
                'notification_id' => $notification->id,
                'target_id' => $users[0]->id,
                'target_type' => get_class($users[0]), // typically App\Models\User
            ]);

            // Add statuses for each user
            foreach ($users as $user) {
                NotificationStatus::create([
                    'notification_id' => $notification->id,
                    'user_id' => $user->id,
                    'is_read' => fake()->boolean(20),
                ]);
            }
        });
    }
}
