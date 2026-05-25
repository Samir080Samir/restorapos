<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_debts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('restaurant_id')
                ->constrained('restaurants')
                ->cascadeOnDelete();

            $table->foreignId('branch_id')
                ->nullable()
                ->constrained('branches')
                ->nullOnDelete();

            $table->foreignId('customer_id')
                ->constrained('customers')
                ->cascadeOnDelete();

            $table->foreignId('order_id')
                ->nullable()
                ->constrained('pos_orders')
                ->nullOnDelete();

            $table->foreignId('payment_id')
                ->nullable()
                ->constrained('pos_payments')
                ->nullOnDelete();

            $table->foreignId('staff_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->decimal('amount', 12, 2)->default(0);
            $table->decimal('paid_amount', 12, 2)->default(0);
            $table->decimal('remaining_amount', 12, 2)->default(0);

            $table->string('status', 50)->default('unpaid');
            $table->text('note')->nullable();
            $table->timestamp('paid_at')->nullable();

            $table->timestamps();

            $table->index(['restaurant_id', 'branch_id', 'status']);
            $table->index(['restaurant_id', 'customer_id']);
            $table->index(['customer_id', 'status']);
            $table->index(['order_id']);
            $table->index(['payment_id']);
            $table->index(['staff_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_debts');
    }
};
