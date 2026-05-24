<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Filiallara SaaS idarəetmə sütunları əlavə edir.
     */
    public function up(): void
    {
        Schema::table('branches', function (Blueprint $table) {
            $table->string('manager_name')->nullable()->after('address');
            $table->string('city')->nullable()->after('manager_name');

            $table->string('branch_type')->default('standard')->after('status');
            $table->string('live_status')->default('offline')->after('branch_type');

            $table->integer('pos_terminals_count')->default(0)->after('live_status');
            $table->integer('kds_count')->default(0)->after('pos_terminals_count');
            $table->integer('printer_count')->default(0)->after('kds_count');
            $table->boolean('qr_menu_enabled')->default(false)->after('printer_count');

            $table->date('last_payment_date')->nullable()->after('qr_menu_enabled');
            $table->date('next_payment_date')->nullable()->after('last_payment_date');
            $table->decimal('debt_amount', 10, 2)->default(0)->after('next_payment_date');

            $table->time('opens_at')->nullable()->after('debt_amount');
            $table->time('closes_at')->nullable()->after('opens_at');
        });
    }

    /**
     * Filiallardan SaaS idarəetmə sütunlarını silir.
     */
    public function down(): void
    {
        Schema::table('branches', function (Blueprint $table) {
            $table->dropColumn([
                'manager_name',
                'city',
                'branch_type',
                'live_status',
                'pos_terminals_count',
                'kds_count',
                'printer_count',
                'qr_menu_enabled',
                'last_payment_date',
                'next_payment_date',
                'debt_amount',
                'opens_at',
                'closes_at',
            ]);
        });
    }
};
