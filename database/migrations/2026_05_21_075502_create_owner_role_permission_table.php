<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('owner_role_permission', function (Blueprint $table) {

            $table->id();

            $table->foreignId('owner_role_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('owner_permission_id')
                ->constrained()
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('owner_role_permission');
    }
};
