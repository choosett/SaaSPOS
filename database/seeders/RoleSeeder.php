<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check and create Admin & Cashier roles globally (for system-wide roles)
        Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web', 'business_id' => 0]);
        Role::firstOrCreate(['name' => 'Cashier', 'guard_name' => 'web', 'business_id' => 0]);
        
    }
}
