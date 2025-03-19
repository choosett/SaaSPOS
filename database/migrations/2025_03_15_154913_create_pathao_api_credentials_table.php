<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('pathao_api_credentials', function (Blueprint $table) {
            $table->string('courier_id', 10)->primary(); // ✅ Custom formatted ID (e.g., P-1001)
            $table->string('business_id', 8); // ✅ Matches `business_id` in businesses table
            $table->string('courier_name')->default('Pathao'); // ✅ Default value for clarity
            $table->json('credentials'); // ✅ Store API credentials as JSON
            $table->timestamps(); // ✅ Automatically handle created_at & updated_at

            // ✅ Set foreign key to ensure data integrity
            $table->foreign('business_id')
                  ->references('business_id')
                  ->on('businesses')
                  ->onDelete('cascade'); // ✅ Delete API credentials if business is removed
        });
    }

    public function down()
    {
        Schema::dropIfExists('pathao_api_credentials');
    }
};

