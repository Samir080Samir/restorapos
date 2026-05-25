<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosPayment extends Model
{
    protected $fillable = [
        'restaurant_id',
        'branch_id',
        'table_id',
        'order_id',
        'staff_id',
        'customer_id',
        'subtotal',
        'discount_type',
        'discount_value',
        'discount_amount',
        'payable_amount',
        'cash_amount',
        'card_amount',
        'debt_amount',
        'payment_method',
        'status',
        'paid_at',
        'note',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount_value' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'payable_amount' => 'decimal:2',
        'cash_amount' => 'decimal:2',
        'card_amount' => 'decimal:2',
        'debt_amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(PosOrder::class, 'order_id');
    }

    public function table()
    {
        return $this->belongsTo(RestaurantTable::class, 'table_id');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
