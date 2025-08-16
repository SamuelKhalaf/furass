<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure we have at least one user
        if (User::count() === 0) {
            User::factory()->create();
        }

        // Create 5 published news
        News::factory()->count(5)->published()->create();

        // Create 3 draft news
        News::factory()->count(3)->draft()->create();

        // Create 10 random news (mixed status)
        News::factory()->count(10)->create();
    }
}
