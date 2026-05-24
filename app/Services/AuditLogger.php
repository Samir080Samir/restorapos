<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;

class AuditLogger
{
    /**
     * Audit history yazır.
     */
    public static function log(
        string $module,
        string $action,
        string $eventKey,
        ?string $description = null,
        ?Model $auditable = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?array $meta = null
    ): void {

        $user = auth()->user();

        $request = app('request');

        AuditLog::create([

            /*
            |--------------------------------------------------------------------------
            | Kim etdi?
            |--------------------------------------------------------------------------
            */

            'user_id' => $user?->id,

            /*
            |--------------------------------------------------------------------------
            | Hansı restoran / filial daxilində oldu?
            |--------------------------------------------------------------------------
            */

            'restaurant_id' =>
            $user?->restaurant_id
                ?? $auditable?->restaurant_id
                ?? null,

            'branch_id' =>
            $user?->branch_id
                ?? $auditable?->branch_id
                ?? null,

            /*
            |--------------------------------------------------------------------------
            | Əməliyyat məlumatları
            |--------------------------------------------------------------------------
            */

            'module' => $module,

            'action' => $action,

            'event_key' => $eventKey,

            'description' => $description,

            /*
            |--------------------------------------------------------------------------
            | Dəyişiklik məlumatları
            |--------------------------------------------------------------------------
            */

            'old_values' => $oldValues,

            'new_values' => $newValues,

            /*
            |--------------------------------------------------------------------------
            | Polymorphic model bağlantısı
            |--------------------------------------------------------------------------
            */

            'auditable_type' => $auditable
                ? get_class($auditable)
                : null,

            'auditable_id' => $auditable?->id,

            /*
            |--------------------------------------------------------------------------
            | Təhlükəsizlik izi
            |--------------------------------------------------------------------------
            */

            'ip_address' => $request->ip(),

            'user_agent' => $request->userAgent(),

            /*
            |--------------------------------------------------------------------------
            | Əlavə metadata
            |--------------------------------------------------------------------------
            */

            'meta' => $meta,

        ]);
    }
}
