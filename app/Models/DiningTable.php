<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiningTable extends Model
{
    /**
     * Bazaya yazılmasına icazə verilən masa sütunları.
     */
    protected $fillable = [
        'restaurant_id',
        'branch_id',
        'name',
        'capacity',
        'status',
        'qr_code',
    ];

    /**
     * Masanın aid olduğu restoran.
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * Masanın aid olduğu filial.
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
