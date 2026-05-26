<?php

namespace App\Models;

use App\Models\Plan;
use App\Models\Branch;
use App\Models\License;
use App\Models\Payment;
use App\Models\Category;
use App\Models\Product;
use App\Models\DiningTable;
use App\Models\RestaurantTable;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $fillable = [
        'plan_id',
        'name',
        'slug',
        'owner_name',
        'phone',
        'email',
        'owner_password',
        'logo',
        'status',
        'subscription_ends_at',

        /*
        |--------------------------------------------------------------------------
        | QR Menu Settings
        |--------------------------------------------------------------------------
        */
        'qr_is_active',
        'qr_background_image',
        'qr_welcome_text',
        'qr_about_title',
        'qr_about_description',
        'qr_contact_phone',
        'qr_address',
        'qr_instagram',
        'qr_tiktok',
        'qr_facebook',
        'qr_website',
    ];

    protected $casts = [
        'subscription_ends_at' => 'datetime',
        'qr_is_active' => 'boolean',
    ];

    protected $hidden = [
        'owner_password',
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function licenses()
    {
        return $this->hasMany(License::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function latestLicense()
    {
        return $this->hasOne(License::class)->latestOfMany();
    }

    public function activeLicense()
    {
        return $this->hasOne(License::class)
            ->where('status', 'active')
            ->whereDate('end_date', '>=', now())
            ->latestOfMany();
    }

    public function hasActiveLicense(): bool
    {
        return $this->activeLicense()->exists();
    }

    public function isLicenseBlocked(): bool
    {
        return ! $this->hasActiveLicense();
    }

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function diningTables()
    {
        return $this->hasMany(DiningTable::class);
    }

    public function tables()
    {
        return $this->hasMany(RestaurantTable::class);
    }
}
