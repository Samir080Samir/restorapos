<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('restaurant_id')
                ->constrained('restaurants')
                ->cascadeOnDelete();

            $table->foreignId('license_id')
                ->nullable()
                ->constrained('licenses')
                ->nullOnDelete();

            $table->foreignId('plan_id')
                ->nullable()
                ->constrained('plans')
                ->nullOnDelete();

            $table->decimal('amount', 10, 2);

            $table->enum('billing_cycle', [
                'monthly',
                'yearly',
            ])->default('monthly');

            $table->enum('payment_method', [
                'cash',
                'bank_transfer',
                'card',
                'online',
                'manual',
            ])->default('manual');

            $table->enum('status', [
                'paid',
                'pending',
                'failed',
                'refunded',
                'cancelled',
            ])->default('paid');

            $table->date('payment_date')->nullable();

            $table->string('transaction_id')->nullable();
            $table->text('note')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
