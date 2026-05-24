<?php

namespace App\Models;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = [
        'title',
        'slug',

        'type',

        'discount_type',
        'discount_value',

        'promo_code',

        'plan_id',

        'start_date',
        'end_date',

        'usage_limit',
        'used_count',

        'applies_to_monthly',
        'applies_to_yearly',

        'is_active',

        'description',
        'terms',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',

        'applies_to_monthly' => 'boolean',
        'applies_to_yearly' => 'boolean',
        'is_active' => 'boolean',

        'discount_value' => 'decimal:2',
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function isActive(): bool
    {
        if (! $this->is_active) {
            return false;
        }

        if ($this->start_date && now()->lt($this->start_date)) {
            return false;
        }

        if ($this->end_date && now()->gt($this->end_date)) {
            return false;
        }

        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    public function discountLabel(): string
    {
        return match ($this->discount_type) {
            'percentage' => $this->discount_value . '%',
            'fixed' => '₼' . $this->discount_value,
            'free_month' => $this->discount_value . ' ay pulsuz',
            default => $this->discount_value,
        };
    }
}
