<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * SaaS paketləri cədvəlini yaradır.
     */
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {

            $table->id();

            $table->string('name');

            $table->string('slug')
                ->unique();

            $table->decimal('monthly_price', 10, 2)
                ->default(0);

            $table->decimal('yearly_price', 10, 2)
                ->default(0);

            $table->integer('max_branches')
                ->default(1);

            $table->integer('max_users')
                ->default(3);

            $table->integer('max_tables')
                ->default(10);

            $table->boolean('qr_menu')
                ->default(false);

            $table->boolean('waiter_app')
                ->default(false);

            $table->boolean('kitchen_display')
                ->default(false);

            $table->boolean('kiosk')
                ->default(false);

            $table->boolean('inventory')
                ->default(false);

            $table->boolean('reports')
                ->default(false);

            $table->boolean('multi_branch')
                ->default(false);

            $table->string('status')
                ->default('active');

            $table->timestamps();
        });
    }

    /**
     * SaaS paketləri cədvəlini silir.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
