<?php

namespace App\Models;

use App\Models\Plan;
use App\Models\Payment;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    /**
     * Mass assignable sütunlar.
     */
    protected $fillable = [

        'restaurant_id',
        'plan_id',

        'billing_cycle',

        'start_date',
        'end_date',

        'status',

        'amount',

        'last_payment_date',
        'next_payment_date',

        'auto_suspend',

        'suspended_at',
        'suspend_reason',

        'note',
    ];

    /**
     * Cast tip çevirmələri.
     */
    protected $casts = [

        'start_date' => 'date',
        'end_date' => 'date',

        'last_payment_date' => 'date',
        'next_payment_date' => 'date',

        'suspended_at' => 'datetime',

        'auto_suspend' => 'boolean',

        'amount' => 'decimal:2',
    ];

    /**
     * Restoran əlaqəsi.
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * Paket əlaqəsi.
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Lisenziyaya aid ödənişlər.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Lisenziya aktivdir?
     */
    public function isActive(): bool
    {
        return $this->status === 'active'
            && $this->end_date >= now()->toDateString();
    }

    /**
     * Lisenziya müddəti bitib?
     */
    public function isExpired(): bool
    {
        return $this->end_date < now()->toDateString();
    }

    /**
     * Lisenziya dayandırılıb?
     */
    public function isSuspended(): bool
    {
        return $this->status === 'suspended';
    }

    /**
     * Qalan gün sayı.
     */
    public function remainingDays(): int
    {
        return now()->diffInDays($this->end_date, false);
    }

    /**
     * Status badge rəngi.
     */
    public function statusColor(): string
    {
        return match ($this->status) {

            'active' => 'green',

            'expired' => 'red',

            'suspended' => 'yellow',

            'cancelled' => 'gray',

            default => 'gray',
        };
    }

    /**
     * Aylıq lisenziyadır?
     */
    public function isMonthly(): bool
    {
        return $this->billing_cycle === 'monthly';
    }

    /**
     * İllik lisenziyadır?
     */
    public function isYearly(): bool
    {
        return $this->billing_cycle === 'yearly';
    }
}
