<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Lisenziyalar cədvəlini yaradır.
     */
    public function up(): void
    {
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Əlaqələr
            |--------------------------------------------------------------------------
            */
            $table->foreignId('restaurant_id')
                ->constrained('restaurants')
                ->cascadeOnDelete();

            $table->foreignId('plan_id')
                ->constrained('plans')
                ->restrictOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Lisenziya dövrü
            |--------------------------------------------------------------------------
            */
            $table->enum('billing_cycle', [
                'monthly',
                'yearly',
            ])->default('monthly');

            $table->date('start_date');
            $table->date('end_date');

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            | active    - aktiv işləyir
            | expired   - müddəti bitib
            | suspended - admin tərəfindən dayandırılıb
            | cancelled - ləğv edilib
            |--------------------------------------------------------------------------
            */
            $table->enum('status', [
                'active',
                'expired',
                'suspended',
                'cancelled',
            ])->default('active');

            /*
            |--------------------------------------------------------------------------
            | Ödəniş məlumatları
            |--------------------------------------------------------------------------
            */
            $table->decimal('amount', 10, 2)->default(0);

            $table->date('last_payment_date')->nullable();
            $table->date('next_payment_date')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Avtomatik bloklama
            |--------------------------------------------------------------------------
            */
            $table->boolean('auto_suspend')->default(true);

            $table->timestamp('suspended_at')->nullable();
            $table->text('suspend_reason')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Qeyd
            |--------------------------------------------------------------------------
            */
            $table->text('note')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Lisenziyalar cədvəlini silir.
     */
    public function down(): void
    {
        Schema::dropIfExists('licenses');
    }
};
