<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Database\Seeders\AuthorizationSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $superadmin = \App\Models\User::where('email', 'superadmin@example.test')->first() ?? \App\Models\User::factory()->create([
            'name' => 'Superadmin User',
            'email' => 'superadmin@example.test',
        ]);

        \App\Models\User::factory(10)->create();

        // Seed roles and permissions
        $this->call(AuthorizationSeeder::class);


        // Assign roles to users
        $superadmin->syncRoles(Role::where('name', 'superadmin')->first());
    }
}
