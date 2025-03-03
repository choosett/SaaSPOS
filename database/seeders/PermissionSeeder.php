<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Business;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // ✅ Define Permissions
        $permissions = [
            'dashboard.view',
            'roles.view', 'roles.create', 'roles.edit', 'roles.delete',
            'users.view', 'users.create', 'users.edit', 'users.delete',
            'admin.access'
        ];

        // ✅ Ensure All Permissions Exist
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // ✅ Fetch All Valid Businesses (Prevents Foreign Key Issues)
        $businesses = Business::pluck('business_id')->toArray(); 

        if (empty($businesses)) {
            echo "❌ No businesses found! Skipping role assignment.\n";
            return;
        }

        // ✅ Assign Roles & Permissions for Each Existing Business
        foreach ($businesses as $businessId) {
            // ✅ Check if Business Exists Before Assigning Roles
            if (!Business::where('business_id', $businessId)->exists()) {
                continue;
            }

            // ✅ Create Business-Specific Roles
            $admin = Role::firstOrCreate([
                'name' => 'admin',
                'business_id' => $businessId,
                'guard_name' => 'web'
            ]);

            $cashier = Role::firstOrCreate([
                'name' => 'cashier',
                'business_id' => $businessId,
                'guard_name' => 'web'
            ]);

            // ✅ Assign All Permissions to Business-Specific Admin
            $admin->syncPermissions($permissions);

            // ✅ Assign Limited Permissions to Cashier
            $cashier->syncPermissions(['users.view']);
        }

        echo "✅ Roles and Permissions assigned successfully!\n";
    }
}
