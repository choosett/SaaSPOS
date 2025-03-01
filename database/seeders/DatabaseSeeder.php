<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \DB::beginTransaction();

        try {
            // ✅ Ensure Roles Exist (WITHOUT DEFAULT BUSINESS)
            $roles = ['admin', 'manager', 'cashier'];
            foreach ($roles as $roleName) {
                Role::firstOrCreate(
                    ['name' => $roleName, 'guard_name' => 'web']
                );
            }

            \Log::info("Roles seeded successfully.");

            // ✅ Ensure Permissions Exist
            $permissions = ['view dashboard', 'manage users', 'process sales', 'view reports'];
            foreach ($permissions as $permission) {
                Permission::firstOrCreate(['name' => $permission]);
            }

            \Log::info("Permissions seeded successfully.");

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error("Seeding failed: " . $e->getMessage());
        }
    }
}
