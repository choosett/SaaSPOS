<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('redx_api_credentials', function (Blueprint $table) {
            $table->string('courier_id', 10)->primary(); // Format: R-1001, R-1002, etc.
            $table->string('business_id', 8); // ✅ Changed from BigInt to String (VARCHAR 8)
            $table->string('courier_name')->default('RedX');
            $table->json('credentials'); // Stores Access Token in JSON format
            $table->timestamps();

            // ✅ Fix: Business ID should reference `business_id` field in `businesses` table
            $table->foreign('business_id')->references('business_id')->on('businesses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('redx_api_credentials');
    }
};
