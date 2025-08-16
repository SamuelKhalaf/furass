<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks to avoid constraint issues
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate tables
        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('users')->truncate();

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create Roles
        $adminRole = Role::firstOrCreate(['name' => RoleEnum::ADMIN->value]);
        $managerRole = Role::firstOrCreate(['name' => RoleEnum::MANAGER->value]);
        $defaultUserRole = Role::firstOrCreate(['name' => RoleEnum::DEFAULT_USER->value]);

        $admin = User::firstOrCreate([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'phone_number' => '1234567890',
            'password' => Hash::make('adminadmin'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole($adminRole->name);

        $manager = User::firstOrCreate([
            'name' => 'Manager',
            'email' => 'manager@gmail.com',
            'phone_number' => '01122334455',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $manager->assignRole($managerRole->name);

        User::factory()->count(40)->create()->each(function ($user) use ($defaultUserRole) {
            $user->assignRole($defaultUserRole->name);
        });
    }
}
