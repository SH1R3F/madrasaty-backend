<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AuthorizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * Seed Roles
         */
        $superadmin = Role::updateOrCreate(['guard_name' => 'sanctum', 'name' => 'superadmin']);

        /**
         * Seed Permissions
         */
        $permissions = [
            // Real permissions
            Permission::updateOrCreate(['guard_name' => 'sanctum', 'name' => 'Create role']),
            Permission::updateOrCreate(['guard_name' => 'sanctum', 'name' => 'Read role']),
            Permission::updateOrCreate(['guard_name' => 'sanctum', 'name' => 'Update role']),
            Permission::updateOrCreate(['guard_name' => 'sanctum', 'name' => 'Delete role']),

            Permission::updateOrCreate(['guard_name' => 'sanctum', 'name' => 'Create user']),
            Permission::updateOrCreate(['guard_name' => 'sanctum', 'name' => 'Read user']),
            Permission::updateOrCreate(['guard_name' => 'sanctum', 'name' => 'Update user']),
            Permission::updateOrCreate(['guard_name' => 'sanctum', 'name' => 'Delete user']),
        ];


        // Assign permissions to roles
        $superadmin->syncPermissions($permissions);
    }
}
