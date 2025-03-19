<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        Schema::create('steadfast_api_credentials', function (Blueprint $table) {
            $table->string('courier_id', 10)->primary(); // Format: S-1001, S-1002, etc.
            $table->string('business_id', 8);
            $table->string('courier_name')->default('Steadfast');
            $table->json('credentials'); // API Key and Secret stored in JSON format
            $table->timestamps();

            // Foreign Key Constraint for Business ID
            $table->foreign('business_id')
                  ->references('business_id')
                  ->on('businesses')
                  ->onDelete('cascade');
        });

        // ✅ Set the initial auto-increment value
        DB::statement("ALTER TABLE steadfast_api_credentials AUTO_INCREMENT = 1001;");
    }

    public function down()
    {
        Schema::dropIfExists('steadfast_api_credentials');
    }
};
