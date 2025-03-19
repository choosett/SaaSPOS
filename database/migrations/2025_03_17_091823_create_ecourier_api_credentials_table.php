<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ecourier_api_credentials', function (Blueprint $table) {
            $table->string('courier_id', 10)->primary(); // Format: E-1001, E-1002, etc.
            $table->string('business_id', 8);
            $table->string('courier_name')->default('E-Courier');
            $table->json('credentials'); // Stores API Key & Secret in JSON format
            $table->timestamps();

            $table->foreign('business_id')->references('business_id')->on('businesses')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ecourier_api_credentials');
    }
};
