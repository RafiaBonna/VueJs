<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
        ]);

        // Create default admin user
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@scm.com',
            'password' => Hash::make('password'),
        ]);

        // Assign admin role
        $adminRole = Role::where('slug', 'admin')->first();

        if ($adminRole) {
            $admin->roles()->attach($adminRole);
        }
    }
}
