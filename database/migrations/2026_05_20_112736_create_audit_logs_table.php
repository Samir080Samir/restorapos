<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Audit history cədvəli.
     */
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Kim etdi?
            |--------------------------------------------------------------------------
            */
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Hansı restoran / filial daxilində oldu?
            |--------------------------------------------------------------------------
            */
            $table->foreignId('restaurant_id')
                ->nullable()
                ->constrained('restaurants')
                ->nullOnDelete();

            $table->foreignId('branch_id')
                ->nullable()
                ->constrained('branches')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Hansı modulda və hansı əməliyyat oldu?
            |--------------------------------------------------------------------------
            | module: restaurants, users, plans, licenses, payments, inventory, qr_menu...
            | action: created, updated, deleted, login, logout, suspended...
            |--------------------------------------------------------------------------
            */
            $table->string('module')->index();
            $table->string('action')->index();

            /*
            |--------------------------------------------------------------------------
            | Dil paketi üçün açar
            |--------------------------------------------------------------------------
            | Məs: audit.restaurants.created
            | Gələcəkdə lang/az/audit.php, lang/en/audit.php ilə tərcümə olunacaq.
            |--------------------------------------------------------------------------
            */
            $table->string('event_key')->index();

            /*
            |--------------------------------------------------------------------------
            | Oxunaqlı əlavə açıqlama
            |--------------------------------------------------------------------------
            */
            $table->text('description')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Dəyişiklik məlumatları
            |--------------------------------------------------------------------------
            */
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Polymorphic model bağlantısı
            |--------------------------------------------------------------------------
            | Məs: Restaurant #5, User #12, Payment #8
            |--------------------------------------------------------------------------
            */
            $table->nullableMorphs('auditable');

            /*
            |--------------------------------------------------------------------------
            | Təhlükəsizlik izi
            |--------------------------------------------------------------------------
            */
            $table->ipAddress('ip_address')->nullable();
            $table->text('user_agent')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Əlavə metadata
            |--------------------------------------------------------------------------
            */
            $table->json('meta')->nullable();

            $table->timestamps();

            $table->index(['restaurant_id', 'module']);
            $table->index(['user_id', 'action']);
            $table->index(['created_at']);
        });
    }

    /**
     * Audit history cədvəlini silir.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
