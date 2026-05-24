<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosTerminal extends Model
{
    protected $fillable = [
        'restaurant_id',
        'branch_id',
        'name',
        'activation_code',
        'device_token',
        'is_active',
        'activated_at',
        'last_used_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'activated_at' => 'datetime',
        'last_used_at' => 'datetime',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
