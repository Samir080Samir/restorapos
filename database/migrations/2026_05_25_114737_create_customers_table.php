<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('restaurant_id')
                ->constrained('restaurants')
                ->cascadeOnDelete();

            $table->foreignId('branch_id')
                ->nullable()
                ->constrained('branches')
                ->nullOnDelete();

            $table->string('full_name');
            $table->string('phone', 50)->nullable();
            $table->text('note')->nullable();

            $table->decimal('bonus_balance', 12, 2)->default(0);
            $table->decimal('total_debt', 12, 2)->default(0);

            $table->string('status', 50)->default('active');

            $table->timestamps();

            $table->index(['restaurant_id', 'branch_id']);
            $table->index(['restaurant_id', 'phone']);
            $table->index(['restaurant_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
