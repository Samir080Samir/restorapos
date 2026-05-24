<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantTable extends Model
{
    protected $fillable = [
        'restaurant_id',
        'branch_id',
        'dining_area_id',

        'name',
        'code',

        'shape',
        'seats',
        'show_seats',

        'position_x',
        'position_y',

        'width',
        'height',

        'status',

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

    public function diningArea()
    {
        return $this->belongsTo(DiningArea::class);
    }

    public function openOrder()
    {
        return $this->hasOne(PosOrder::class, 'table_id')
            ->where('status', 'open')
            ->latestOfMany();
    }
    public function activeReservation()
    {
        return $this->hasOne(TableReservation::class, 'table_id')
            ->where('status', 'reserved')
            ->whereDate('reservation_date', now()->toDateString())
            ->latestOfMany();
    }
    
    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function isEmpty()
    {
        return $this->status === 'empty';
    }

    public function isBusy()
    {
        return $this->status === 'busy';
    }

    public function isReserved()
    {
        return $this->status === 'reserved';
    }

    public function isWaitingPayment()
    {
        return $this->status === 'waiting_payment';
    }
}
