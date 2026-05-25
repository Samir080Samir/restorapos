<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'restaurant_id',
        'branch_id',
        'full_name',
        'phone',
        'note',
        'bonus_balance',
        'total_debt',
        'status',
    ];

    protected $casts = [
        'bonus_balance' => 'decimal:2',
        'total_debt' => 'decimal:2',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function debts()
    {
        return $this->hasMany(CustomerDebt::class);
    }

    public function activeDebts()
    {
        return $this->hasMany(CustomerDebt::class)->whereIn('status', ['unpaid', 'partial']);
    }
}
