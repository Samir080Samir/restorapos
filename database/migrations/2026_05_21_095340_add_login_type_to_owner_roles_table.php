<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('owner_roles', function (Blueprint $table) {
            if (! Schema::hasColumn('owner_roles', 'login_type')) {
                $table->string('login_type')
                    ->default('pos')
                    ->after('restaurant_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('owner_roles', function (Blueprint $table) {
            if (Schema::hasColumn('owner_roles', 'login_type')) {
                $table->dropColumn('login_type');
            }
        });
    }
};
