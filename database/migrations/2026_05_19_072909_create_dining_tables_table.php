<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Restoran masaları cədvəlini yaradır.
     */
    public function up(): void
    {
        Schema::create('dining_tables', function (Blueprint $table) {

            $table->id();

            $table->foreignId('restaurant_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('branch_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('name');

            $table->integer('capacity')
                ->default(4);

            $table->string('status')
                ->default('available');

            $table->string('qr_code')
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Restoran masaları cədvəlini silir.
     */
    public function down(): void
    {
        Schema::dropIfExists('dining_tables');
    }
};
