<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Endirim və kampaniyalar cədvəli.
     */
    public function up(): void
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('slug')->unique();

            $table->enum('type', [
                'discount',
                'promo_code',
                'referral',
                'trial',
                'plan_upgrade',
                'seasonal',
            ])->default('discount');

            $table->enum('discount_type', [
                'percentage',
                'fixed',
                'free_month',
            ])->default('percentage');

            $table->decimal('discount_value', 10, 2)->default(0);

            $table->string('promo_code')->nullable()->unique();

            $table->foreignId('plan_id')
                ->nullable()
                ->constrained('plans')
                ->nullOnDelete();

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->integer('usage_limit')->nullable();
            $table->integer('used_count')->default(0);

            $table->boolean('applies_to_monthly')->default(true);
            $table->boolean('applies_to_yearly')->default(true);

            $table->boolean('is_active')->default(true);

            $table->text('description')->nullable();
            $table->text('terms')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Cədvəli silir.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
