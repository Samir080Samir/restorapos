<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('qr_menu_views')) {
            Schema::create('qr_menu_views', function (Blueprint $table) {
                $table->id();
                $table->foreignId('restaurant_id')->constrained()->cascadeOnDelete();
                $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();
                $table->foreignId('table_id')->nullable()->constrained('restaurant_tables')->nullOnDelete();
                $table->string('type')->default('menu'); // menu, table
                $table->string('ip_address', 64)->nullable();
                $table->text('user_agent')->nullable();
                $table->timestamps();

                $table->index(['restaurant_id', 'created_at']);
                $table->index(['restaurant_id', 'table_id']);
                $table->index(['restaurant_id', 'type']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('qr_menu_views');
    }
};
