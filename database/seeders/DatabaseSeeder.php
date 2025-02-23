<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Business;
use Illuminate\Support\Facades\Hash;

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

        // ✅ Create a test business if it doesn't exist
        $business = Business::firstOrCreate(
            ['business_id' => 'BIZ12345'], // Check by business_id
            [
                'business_name' => 'GoCreative',
                'start_date' => now(), // ✅ Change to match your schema
                'currency' => 'USD',
                'business_contact' => '0123456789',
                'district' => 'Dhaka',
                'business_address' => '123 Business Street',
                'zip_code' => '1000',
                'financial_year' => '2025', // ✅ Correct column name
                'stock_method' => 'FIFO', // ✅ Enum values match schema
            ]
        );

        // ✅ Create a test admin user if it doesn't exist
        $user = User::firstOrCreate(
            ['email' => 'admin@example.com'], // Check by email
            [
                'business_id' => $business->business_id, // ✅ Now linked correctly
                'first_name' => 'Admin',
                'last_name' => 'User',
                'username' => 'admin',
                'password' => Hash::make('password123'),
            ]
        );

        $user->assignRole('admin'); // Assign Admin role to the test user
    }
}
