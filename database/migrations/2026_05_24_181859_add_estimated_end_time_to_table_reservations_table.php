<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('table_reservations', function (Blueprint $table) {

            $table->time('estimated_end_time')
                ->nullable()
                ->after('start_time');

            $table->timestamp('arrived_at')
                ->nullable()
                ->after('status');

            $table->timestamp('completed_at')
                ->nullable()
                ->after('arrived_at');

            $table->timestamp('cancelled_at')
                ->nullable()
                ->after('completed_at');

            $table->timestamp('expired_at')
                ->nullable()
                ->after('cancelled_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('table_reservations', function (Blueprint $table) {

            $table->dropColumn([
                'estimated_end_time',
                'arrived_at',
                'completed_at',
                'cancelled_at',
                'expired_at',
            ]);
        });
    }
};
