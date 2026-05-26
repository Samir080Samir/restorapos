<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            if (! Schema::hasColumn('restaurants', 'qr_contact_phone')) {
                $table->string('qr_contact_phone')->nullable()->after('qr_about_description');
            }

            if (! Schema::hasColumn('restaurants', 'qr_address')) {
                $table->string('qr_address')->nullable()->after('qr_contact_phone');
            }

            if (! Schema::hasColumn('restaurants', 'qr_instagram')) {
                $table->string('qr_instagram')->nullable()->after('qr_address');
            }

            if (! Schema::hasColumn('restaurants', 'qr_tiktok')) {
                $table->string('qr_tiktok')->nullable()->after('qr_instagram');
            }

            if (! Schema::hasColumn('restaurants', 'qr_facebook')) {
                $table->string('qr_facebook')->nullable()->after('qr_tiktok');
            }

            if (! Schema::hasColumn('restaurants', 'qr_website')) {
                $table->string('qr_website')->nullable()->after('qr_facebook');
            }
        });
    }

    public function down(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn([
                'qr_contact_phone',
                'qr_address',
                'qr_instagram',
                'qr_tiktok',
                'qr_facebook',
                'qr_website',
            ]);
        });
    }
};
