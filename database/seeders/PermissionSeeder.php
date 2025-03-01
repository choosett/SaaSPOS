<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // ✅ Create Roles
        $admin = Role::create(['name' => 'admin', 'business_id' => 0]);
        $manager = Role::create(['name' => 'manager', 'business_id' => 0]);
        $cashier = Role::create(['name' => 'cashier', 'business_id' => 0]);
        

        // ✅ Create Permissions
        $permissions = [
            'view users',
            'edit users',
            'delete users',
            'view roles',
            'edit roles',
            'delete roles',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // ✅ Assign Permissions to Admin
        $admin->givePermissionTo($permissions);
    }
}
