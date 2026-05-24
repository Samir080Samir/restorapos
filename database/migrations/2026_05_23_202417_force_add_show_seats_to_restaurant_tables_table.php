<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('restaurant_tables', 'show_seats')) {
            Schema::table('restaurant_tables', function (Blueprint $table) {
                $table->boolean('show_seats')
                    ->default(true)
                    ->after('seats');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('restaurant_tables', 'show_seats')) {
            Schema::table('restaurant_tables', function (Blueprint $table) {
                $table->dropColumn('show_seats');
            });
        }
    }
};
