<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\Business;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // ✅ Get the first business (make sure at least one exists)
        $business = Business::first();

        if (!$business) {
            $business = Business::create([
                'business_id' => strtoupper(substr(md5(uniqid()), 0, 8)), // Generate a random business ID
                'name' => 'Default Business',
            ]);
        }

        // ✅ Create roles under the first business
        Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
            'business_id' => $business->business_id,
        ]);

        Role::firstOrCreate([
            'name' => 'manager',
            'guard_name' => 'web',
            'business_id' => $business->business_id,
        ]);

        Role::firstOrCreate([
            'name' => 'cashier',
            'guard_name' => 'web',
            'business_id' => $business->business_id,
        ]);

        echo "✅ Roles seeded successfully!";
    }
}
