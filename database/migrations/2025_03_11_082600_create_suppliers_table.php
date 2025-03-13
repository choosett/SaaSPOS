<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->string('business_id', 8); // Ensure business_id is a string (VARCHAR 8)
            $table->string('contact_id', 10); // Ensure contact_id is a string (e.g., SUP001)
            $table->string('supplier_name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->unsignedBigInteger('assigned_to'); // Assigned user ID
            $table->decimal('opening_balance', 10, 2)->default(0);
            $table->decimal('advance_balance', 10, 2)->default(0);
            $table->text('address')->nullable();
            $table->timestamps();

            // ✅ Composite Unique Key to Ensure Unique Contact ID Per Business
            $table->unique(['business_id', 'contact_id']);

            // Foreign key constraints
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('suppliers');
    }
};
