<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ✅ Create roles only if they don't exist
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $manager = Role::firstOrCreate(['name' => 'manager']);
        $cashier = Role::firstOrCreate(['name' => 'cashier']);

        // ✅ Create permissions only if they don't exist
        $permissions = [
            'view dashboard',
            'manage users',
            'process sales',
            'view reports'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // ✅ Assign permissions to roles
        $admin->syncPermissions(['view dashboard', 'manage users', 'view reports']);
        $manager->syncPermissions(['view dashboard', 'process sales']);
        $cashier->syncPermissions(['process sales']);

        // ✅ Create a test admin user if it doesn't exist
        $user = User::firstOrCreate(
            ['email' => 'admin@example.com'], // Check by email
            [
                'name' => 'Admin User',
                'password' => bcrypt('password123'), // Change to a secure password
            ]
        );

        $user->assignRole('admin'); // Assign Admin role to the test user
    }
}
