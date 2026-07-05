<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('policies', function (Blueprint $table) {
            $table->id();

            $table->string('policy_number')->unique();

            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('insurance_company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('policy_type_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->date('start_date');
            $table->date('end_date');

            $table->decimal('premium', 12, 2);

            $table->enum('status', [
                'active',
                'expired',
                'cancelled',
                'pending',
                'expiring'
            ])->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('policies');
    }
};