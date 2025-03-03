<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\Business;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // ✅ সমস্ত বিদ্যমান ব্যবসা লোড করুন
        $businesses = Business::pluck('business_id');

        if ($businesses->isEmpty()) {
            echo "❌ কোনো ব্যবসা নেই! রোল তৈরি করা যাবে না।\n";
            return;
        }

        foreach ($businesses as $businessId) {
            Role::firstOrCreate([
                'name' => 'Admin',
                'guard_name' => 'web',
                'business_id' => $businessId
            ]);

            Role::firstOrCreate([
                'name' => 'Cashier',
                'guard_name' => 'web',
                'business_id' => $businessId
            ]);

            echo "✅ Roles assigned successfully to Business ID: $businessId\n";
        }
    }
}
