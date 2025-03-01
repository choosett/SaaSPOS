<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            // ✅ Drop the existing foreign key first if it exists
            $table->dropForeign(['business_id']);
        });

        // ✅ Ensure `business_id` has the correct data type
        \DB::statement('ALTER TABLE roles MODIFY business_id VARCHAR(8) NOT NULL');

        Schema::table('roles', function (Blueprint $table) {
            // ✅ Re-add the correct foreign key constraint
            $table->foreign('business_id')->references('business_id')->on('businesses')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            // ✅ Drop the foreign key constraint before rolling back
            $table->dropForeign(['business_id']);
        });

        // ✅ Revert business_id back to BIGINT UNSIGNED (if needed)
        \DB::statement('ALTER TABLE roles MODIFY business_id BIGINT UNSIGNED NOT NULL');
    }
};
