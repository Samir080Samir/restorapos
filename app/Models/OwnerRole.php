<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OwnerRole extends Model
{
    protected $fillable = [

        /*
        |--------------------------------------------------------------------------
        | Restaurant
        |--------------------------------------------------------------------------
        */

        'restaurant_id',

        /*
        |--------------------------------------------------------------------------
        | Login Type
        |--------------------------------------------------------------------------
        |
        | panel
        | pos
        |
        */

        'login_type',

        /*
        |--------------------------------------------------------------------------
        | Role Info
        |--------------------------------------------------------------------------
        */

        'name',
        'slug',

        /*
        |--------------------------------------------------------------------------
        | Status
        |--------------------------------------------------------------------------
        */

        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(
            OwnerPermission::class,
            'owner_role_permission',
            'owner_role_id',
            'owner_permission_id'
        );
    }

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'user_owner_role',
            'owner_role_id',
            'user_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | LOGIN TYPE CHECK
    |--------------------------------------------------------------------------
    */

    public function isPosRole(): bool
    {
        return $this->login_type === 'pos';
    }

    public function isPanelRole(): bool
    {
        return $this->login_type === 'panel';
    }

    /*
    |--------------------------------------------------------------------------
    | ROLE TYPE CHECKS
    |--------------------------------------------------------------------------
    */

    public function isCashier(): bool
    {
        return str_contains(
            strtolower($this->slug),
            'cashier'
        );
    }

    public function isWaiter(): bool
    {
        return str_contains(
            strtolower($this->slug),
            'waiter'
        );
    }

    public function isAdministrator(): bool
    {
        return str_contains(
            strtolower($this->slug),
            'administrator'
        );
    }

    public function isFinance(): bool
    {
        return str_contains(
            strtolower($this->slug),
            'finance'
        );
    }

    public function isBranchManager(): bool
    {
        return str_contains(
            strtolower($this->slug),
            'branch-manager'
        );
    }
}
