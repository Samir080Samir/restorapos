<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('restaurant_tables', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Relations
            |--------------------------------------------------------------------------
            */

            $table->foreignId('restaurant_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('branch_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('dining_area_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Table info
            |--------------------------------------------------------------------------
            */

            $table->string('name');

            $table->string('code')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Shape
            |--------------------------------------------------------------------------
            */

            $table->enum('shape', [
                'square',
                'circle',
                'rectangle',
            ])->default('square');

            /*
            |--------------------------------------------------------------------------
            | Seats
            |--------------------------------------------------------------------------
            */

            $table->unsignedSmallInteger('seats')
                ->default(4);

            /*
            |--------------------------------------------------------------------------
            | Layout position
            |--------------------------------------------------------------------------
            */

            $table->integer('position_x')
                ->default(0);

            $table->integer('position_y')
                ->default(0);

            $table->integer('width')
                ->default(90);

            $table->integer('height')
                ->default(90);

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'empty',
                'busy',
                'reserved',
                'waiting_payment',
            ])->default('empty');

            /*
            |--------------------------------------------------------------------------
            | Sorting & status
            |--------------------------------------------------------------------------
            */

            $table->unsignedInteger('sort_order')
                ->default(0);

            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('restaurant_tables');
    }
};
