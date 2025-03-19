<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('pathao_locations', function (Blueprint $table) {
            $table->id();
            $table->string('business_id', 8)->unique(); // 8-digit unique business ID
            $table->string('city_name');
            $table->unsignedBigInteger('city_id');
            $table->string('zone_name')->nullable();
            $table->unsignedBigInteger('zone_id')->nullable();
            $table->string('area_name')->nullable();
            $table->unsignedBigInteger('area_id')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pathao_locations');
    }
};
