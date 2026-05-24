<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('owner_permissions', function (Blueprint $table) {
            if (! Schema::hasColumn('owner_permissions', 'type')) {
                $table->string('type')->default('panel')->after('id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('owner_permissions', function (Blueprint $table) {
            if (Schema::hasColumn('owner_permissions', 'type')) {
                $table->dropColumn('type');
            }
        });
    }
};
