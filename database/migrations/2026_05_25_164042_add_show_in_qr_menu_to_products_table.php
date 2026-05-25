<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (! Schema::hasColumn('products', 'show_in_qr_menu')) {
                $table->boolean('show_in_qr_menu')
                    ->default(false)
                    ->after('show_in_terminal');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'show_in_qr_menu')) {
                $table->dropColumn('show_in_qr_menu');
            }
        });
    }
};
