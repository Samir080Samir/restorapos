<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            if (! Schema::hasColumn('users', 'branch_id')) {
                $table->foreignId('branch_id')
                    ->nullable()
                    ->after('restaurant_id')
                    ->constrained()
                    ->nullOnDelete();
            }

            if (! Schema::hasColumn('users', 'role')) {
                $table->string('role')
                    ->default('staff')
                    ->after('branch_id');
            }

            if (! Schema::hasColumn('users', 'staff_code')) {
                $table->string('staff_code', 10)
                    ->nullable()
                    ->unique()
                    ->after('role');
            }

            if (! Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')
                    ->default(true)
                    ->after('staff_code');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            if (Schema::hasColumn('users', 'staff_code')) {
                $table->dropUnique(['staff_code']);
            }

            foreach (['branch_id', 'role', 'staff_code', 'is_active'] as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
