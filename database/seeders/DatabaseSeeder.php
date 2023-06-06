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
        // Seed roles and permissions
        $this->call(AuthorizationSeeder::class);

        $superadmin = \App\Models\User::where('email', 'superadmin@example.test')->first() ?? \App\Models\User::factory()->create([
            'name' => 'مدير الموقع',
            'email' => 'superadmin@example.test',
        ]);

        $student = \App\Models\User::where('email', 'student@example.test')->first() ?? \App\Models\User::factory()->create([
            'name' => 'طالب',
            'email' => 'student@example.test'
        ]);

        \App\Models\User::factory(10)->create();


        // Assign roles to users
        $superadmin->syncRoles(Role::where('name', 'مدير الموقع')->first());
        $student->syncRoles(Role::where('name', 'طالب')->first());
    }
}
