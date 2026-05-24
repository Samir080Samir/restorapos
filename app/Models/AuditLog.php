<?php

namespace App\Models;

use App\Models\Branch;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = [
        'user_id',
        'restaurant_id',
        'branch_id',

        'module',
        'action',
        'event_key',
        'description',

        'old_values',
        'new_values',

        'auditable_type',
        'auditable_id',

        'ip_address',
        'user_agent',

        'meta',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'meta' => 'array',
    ];

    /**
     * Əməliyyatı edən istifadəçi.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Əməliyyatın aid olduğu restoran.
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * Əməliyyatın aid olduğu filial.
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Əməliyyat olunan model.
     */
    public function auditable()
    {
        return $this->morphTo();
    }

    /**
     * Action badge rəngi.
     */
    public function actionColor(): string
    {
        return match ($this->action) {
            'created' => 'green',
            'updated' => 'yellow',
            'deleted' => 'red',
            'login' => 'blue',
            'logout' => 'gray',
            'suspended' => 'orange',
            'payment' => 'purple',
            default => 'gray',
        };
    }
}
