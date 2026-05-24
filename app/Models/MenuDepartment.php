<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuDepartment extends Model
{
    protected $fillable = [
        'restaurant_id',
        'name',
        'slug',
        'sort_order',
        'is_active',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
