<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pos_payments', function (Blueprint $table) {
            if (! Schema::hasColumn('pos_payments', 'customer_id')) {
                $table->foreignId('customer_id')
                    ->nullable()
                    ->after('staff_id')
                    ->constrained('customers')
                    ->nullOnDelete();
            }

            if (! Schema::hasColumn('pos_payments', 'debt_amount')) {
                $table->decimal('debt_amount', 12, 2)
                    ->default(0)
                    ->after('card_amount');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pos_payments', function (Blueprint $table) {
            if (Schema::hasColumn('pos_payments', 'customer_id')) {
                $table->dropConstrainedForeignId('customer_id');
            }

            if (Schema::hasColumn('pos_payments', 'debt_amount')) {
                $table->dropColumn('debt_amount');
            }
        });
    }
};
