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
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('business_id', 8)->unique(); // 8-digit unique ID
            $table->string('business_name');
            $table->date('start_date');
            $table->string('currency', 10);
            $table->string('logo')->nullable();
            $table->string('website')->nullable();
            $table->string('business_contact');
            $table->string('alternate_contact')->nullable();
            $table->string('district');
            $table->text('business_address');
            $table->string('zip_code', 10);
            $table->string('bin_number')->nullable();
            $table->string('dbid_number')->nullable();
            $table->string('financial_year', 20);
            $table->enum('stock_method', ['FIFO', 'LIFO']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
