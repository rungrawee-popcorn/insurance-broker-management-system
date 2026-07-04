<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();

            // Customer first name
            $table->string('first_name');

            // Customer last name
            $table->string('last_name');

            // Customer phone number
            $table->string('phone')->nullable();

            // Customer email address
            $table->string('email')->nullable();

            // National identification number
            $table->string('national_id')->nullable();

            // Customer address
            $table->text('address')->nullable();

            $table->timestamps();

            // Soft delete support
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};