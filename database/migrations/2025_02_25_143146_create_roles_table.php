<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use App\Models\Business;

return new class extends Migration {
    public function up(): void
    {
        // ✅ Ensure table doesn't already exist before creating
        if (!Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {
                $table->id();
                $table->string('business_id', 8)->nullable(); // ✅ String-based business_id
                $table->string('name');
                $table->string('guard_name')->default('web');
                $table->timestamps();

                // ✅ Foreign key constraint linking roles to businesses
                $table->foreign('business_id')->references('business_id')->on('businesses')->onDelete('cascade'); 
                
                // ✅ Ensure unique role names per business
                $table->unique(['name', 'business_id']);
            });
        }

        // ✅ Assign Default Roles Only If a Business Exists
        $business = Business::first(); // Get the first business

        if ($business) {
            Role::firstOrCreate([
                'name' => 'Admin',
                'guard_name' => 'web',
                'business_id' => $business->business_id
            ]);

            Role::firstOrCreate([
                'name' => 'Cashier',
                'guard_name' => 'web',
                'business_id' => $business->business_id
            ]);
        }
    }

    public function down(): void
    {
        // ✅ Drop foreign key only if table exists
        if (Schema::hasTable('roles')) {
            Schema::table('roles', function (Blueprint $table) {
                if (Schema::hasColumn('roles', 'business_id')) {
                    $table->dropForeign(['business_id']);
                }
            });

            Schema::dropIfExists('roles');
        }
    }
};
