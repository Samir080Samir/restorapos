<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            if (! Schema::hasColumn('restaurants', 'qr_is_active')) {
                $table->boolean('qr_is_active')->default(true)->after('slug');
            }

            if (! Schema::hasColumn('restaurants', 'qr_background_image')) {
                $table->string('qr_background_image')->nullable()->after('qr_is_active');
            }

            if (! Schema::hasColumn('restaurants', 'qr_welcome_text')) {
                $table->string('qr_welcome_text', 500)->nullable()->after('qr_background_image');
            }

            if (! Schema::hasColumn('restaurants', 'qr_about_title')) {
                $table->string('qr_about_title')->nullable()->after('qr_welcome_text');
            }

            if (! Schema::hasColumn('restaurants', 'qr_about_description')) {
                $table->text('qr_about_description')->nullable()->after('qr_about_title');
            }
        });
    }

    public function down(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            foreach (
                [
                    'qr_about_description',
                    'qr_about_title',
                    'qr_welcome_text',
                    'qr_background_image',
                    'qr_is_active',
                ] as $column
            ) {
                if (Schema::hasColumn('restaurants', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
