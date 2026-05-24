<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiningArea extends Model
{
    protected $fillable = [
        'restaurant_id',
        'branch_id',
        'name',
        'slug',
        'sort_order',
        'is_active',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function tables()
    {
        return $this->hasMany(RestaurantTable::class)
            ->orderBy('sort_order')
            ->orderBy('id');
    }
}
