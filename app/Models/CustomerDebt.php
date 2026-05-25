<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerDebt extends Model
{
    protected $fillable = [
        'restaurant_id',
        'branch_id',
        'customer_id',
        'order_id',
        'payment_id',
        'staff_id',
        'amount',
        'paid_amount',
        'remaining_amount',
        'status',
        'note',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'remaining_amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function order()
    {
        return $this->belongsTo(PosOrder::class, 'order_id');
    }

    public function payment()
    {
        return $this->belongsTo(PosPayment::class, 'payment_id');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
}
