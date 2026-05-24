<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Kateqoriyalar cədvəlini yaradır.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {

            $table->id();

            $table->foreignId('restaurant_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('name');

            $table->string('slug')->unique();

            $table->string('image')->nullable();

            $table->string('status')
                ->default('active');

            $table->timestamps();
        });
    }

    /**
     * Kateqoriyalar cədvəlini silir.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
