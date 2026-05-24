<?php

namespace App\Models;

use App\Models\License;
use App\Models\Plan;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'restaurant_id',
        'license_id',
        'plan_id',
        'amount',
        'billing_cycle',
        'payment_method',
        'status',
        'payment_date',
        'transaction_id',
        'note',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function license()
    {
        return $this->belongsTo(License::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }
}
