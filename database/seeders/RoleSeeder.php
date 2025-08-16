<?php

namespace Database\Seeders;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks to avoid constraint errors
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate tables (delete all data)
        Role::truncate();
        Permission::truncate();
        DB::table('role_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate();

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create Permissions
        foreach (PermissionEnum::all() as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Admin Roles
        $adminRole = Role::firstOrCreate(['name' => RoleEnum::ADMIN->value]);
        $adminRole->givePermissionTo(PermissionEnum::all());

        // Manager Roles
        $managerRole = Role::firstOrCreate(['name' => RoleEnum::MANAGER->value]);
        $managerRole->givePermissionTo([
            PermissionEnum::VIEW_DASHBOARD->value,
            PermissionEnum::LIST_USERS->value,
            PermissionEnum::UPDATE_USERS->value,
            PermissionEnum::CREATE_USERS->value,
        ]);

        // Default User Roles
        $defaultUserRole = Role::firstOrCreate(['name' => RoleEnum::DEFAULT_USER->value]);
        $defaultUserRole->givePermissionTo([
            PermissionEnum::VIEW_DASHBOARD->value,
            PermissionEnum::LIST_USERS->value,
        ]);
    }
}
