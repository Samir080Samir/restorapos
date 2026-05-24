<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Filiallar cədvəlini yaradır.
     */
    public function up(): void
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();

            $table->foreignId('restaurant_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('status')->default('active');

            $table->timestamps();
        });
    }

    /**
     * Filiallar cədvəlini silir.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
