<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    /**
     * Bazaya yazılmasına icazə verilən filial sütunları.
     */
    protected $fillable = [
        'restaurant_id',
        'name',
        'phone',
        'address',
        'manager_name',
        'city',
        'status',
        'branch_type',
        'live_status',
        'pos_terminals_count',
        'kds_count',
        'printer_count',
        'qr_menu_enabled',
        'last_payment_date',
        'next_payment_date',
        'debt_amount',
        'opens_at',
        'closes_at',
        'logo',
    ];

    /**
     * Filialın aid olduğu restoran.
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * Filiala aid masalar.
     */
    public function diningTables()
    {
        return $this->hasMany(DiningTable::class);
    }
}
