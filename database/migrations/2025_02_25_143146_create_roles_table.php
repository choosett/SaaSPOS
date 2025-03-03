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
                $table->string('business_id', 8)->nullable(); // ✅ Convert to STRING to match businesses.business_id
                $table->string('name');
                $table->string('guard_name')->default('web');
                $table->timestamps();

                $table->foreign('business_id')->references('business_id')->on('businesses')->onDelete('cascade'); 
                $table->unique(['name', 'business_id']); // Ensure unique roles per business
            });
        }

        // ✅ Assign Default Roles Only If a Business Exists
        $business = Business::first(); // Get the first business

        if ($business) {
            Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web', 'business_id' => $business->business_id]);
            Role::firstOrCreate(['name' => 'Cashier', 'guard_name' => 'web', 'business_id' => $business->business_id]);
        }
    }

    public function down(): void
    {
        // ✅ Drop the foreign key only if table exists
        if (Schema::hasTable('roles')) {
            Schema::table('roles', function (Blueprint $table) {
                $table->dropForeign(['business_id']);
            });

            Schema::dropIfExists('roles');
        }
    }
};
