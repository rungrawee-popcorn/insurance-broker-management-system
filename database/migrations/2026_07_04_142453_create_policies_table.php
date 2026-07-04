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
        Schema::create('policies', function (Blueprint $table) {
            $table->id();

            // Unique policy number (insurance contract number)
            $table->string('policy_number')->unique();

            // Relationship: customer who owns this policy
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();

            // Relationship: insurance company issuing the policy
            $table->foreignId('insurance_company_id')->constrained()->cascadeOnDelete();

            // Relationship: type of policy (life, health, car, etc.)
            $table->foreignId('policy_type_id')->constrained()->cascadeOnDelete();

            // User who created this policy record
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Policy start date
            $table->date('start_date');

            // Policy end / expiration date
            $table->date('end_date');

            // Insurance premium amount
            $table->decimal('premium', 12, 2);

            // Policy status (active, expired, cancelled, pending)
            $table->enum('status', [
                'active',
                'expired',
                'cancelled',
                'pending'
            ])->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('policies');
    }
};