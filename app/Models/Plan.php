<?php

namespace App\Models;

use App\Models\License;
use App\Models\Payment;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    /**
     * Bazaya yazılmasına icazə verilən paket sütunları.
     */
    protected $fillable = [
        'name',
        'slug',

        'monthly_price',
        'yearly_price',

        'max_branches',
        'max_users',
        'max_tables',

        'qr_menu',
        'waiter_app',
        'kitchen_display',
        'kiosk',
        'inventory',
        'reports',
        'multi_branch',

        'status',
        'is_popular',
    ];

    /**
     * Boolean tipli sütunlar.
     */
    protected $casts = [
        'qr_menu' => 'boolean',
        'waiter_app' => 'boolean',
        'kitchen_display' => 'boolean',
        'kiosk' => 'boolean',
        'inventory' => 'boolean',
        'reports' => 'boolean',
        'multi_branch' => 'boolean',

        'is_popular' => 'boolean',
    ];

    /**
     * Paketə aid restoranlar.
     */
    public function restaurants()
    {
        return $this->hasMany(Restaurant::class);
    }

    /**
     * Paketə aid lisenziyalar.
     */
    public function licenses()
    {
        return $this->hasMany(License::class);
    }

    /**
     * Paketə aid ödənişlər.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Aktiv restoran sayı.
     */
    public function activeRestaurantsCount(): int
    {
        return $this->restaurants()
            ->where('status', 'active')
            ->count();
    }

    /**
     * Paket aktivdir?
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Premium paketdir?
     */
    public function isPopular(): bool
    {
        return $this->is_popular;
    }
}
