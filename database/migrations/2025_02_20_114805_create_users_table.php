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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('business_id', 8)->nullable(); // Business ID reference
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('username')->unique(); // Unique username
            $table->string('email')->unique(); // Unique email
            $table->string('password');
            $table->timestamps();

            // Foreign Key Constraint (Business)
            $table->foreign('business_id')->references('business_id')->on('businesses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
