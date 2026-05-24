<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\AdminRole;
use App\Models\Branch;
use App\Models\OwnerRole;
use App\Models\Permission;
use App\Models\Restaurant;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',

        'restaurant_id',
        'branch_id',

        /*
        |--------------------------------------------------------------------------
        | Sistem rolları
        |--------------------------------------------------------------------------
        |
        | super_admin
        | restaurant_admin
        | branch_manager
        | finance
        | cashier
        | waiter
        | warehouse_manager
        | staff
        |
        */

        'role',

        /*
        |--------------------------------------------------------------------------
        | Giriş tipi
        |--------------------------------------------------------------------------
        |
        | panel
        | pos
        |
        */

        'login_type',

        /*
        |--------------------------------------------------------------------------
        | Staff giriş kodu
        |--------------------------------------------------------------------------
        |
        | POS:
        | 4 rəqəm
        |
        | PANEL:
        | 8 simvol
        |
        */

        'staff_code',

        'is_active',

        /*
        |--------------------------------------------------------------------------
        | Köhnə Super Admin sistemi
        |--------------------------------------------------------------------------
        */

        'admin_role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'staff_code',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
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

    /*
    |--------------------------------------------------------------------------
    | Super Admin Role Sistemi
    |--------------------------------------------------------------------------
    */

    public function adminRole()
    {
        return $this->belongsTo(AdminRole::class, 'admin_role_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(
            Permission::class,
            'user_permissions'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Owner Role Sistemi
    |--------------------------------------------------------------------------
    */

    public function ownerRoles()
    {
        return $this->belongsToMany(
            OwnerRole::class,
            'user_owner_role',
            'user_id',
            'owner_role_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Owner Permission Check
    |--------------------------------------------------------------------------
    */

    public function hasOwnerPermission(string $permission): bool
    {
        return $this->ownerRoles()
            ->whereHas('permissions', function ($query) use ($permission) {
                $query->where('slug', $permission);
            })
            ->exists();
    }

    public function hasAnyOwnerPermission(array $permissions): bool
    {
        return $this->ownerRoles()
            ->whereHas('permissions', function ($query) use ($permissions) {
                $query->whereIn('slug', $permissions);
            })
            ->exists();
    }

    /*
    |--------------------------------------------------------------------------
    | Sistem Rol Yoxlamaları
    |--------------------------------------------------------------------------
    */

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isRestaurantAdmin(): bool
    {
        return $this->role === 'restaurant_admin';
    }

    public function isBranchManager(): bool
    {
        return $this->role === 'branch_manager';
    }

    public function isFinance(): bool
    {
        return $this->role === 'finance';
    }

    public function isCashier(): bool
    {
        return $this->role === 'cashier';
    }

    public function isWaiter(): bool
    {
        return $this->role === 'waiter';
    }

    /*
    |--------------------------------------------------------------------------
    | Login Type
    |--------------------------------------------------------------------------
    */

    public function isPosLogin(): bool
    {
        return $this->login_type === 'pos';
    }

    public function isPanelLogin(): bool
    {
        return $this->login_type === 'panel';
    }

    /*
    |--------------------------------------------------------------------------
    | Restaurant / License
    |--------------------------------------------------------------------------
    */

    public function hasRestaurant(): bool
    {
        return ! is_null($this->restaurant_id);
    }

    public function hasActiveRestaurantLicense(): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        if (! $this->restaurant) {
            return false;
        }

        return $this->restaurant->hasActiveLicense();
    }

    public function isBlockedByLicense(): bool
    {
        if ($this->isSuperAdmin()) {
            return false;
        }

        return ! $this->hasActiveRestaurantLicense();
    }

    /*
    |--------------------------------------------------------------------------
    | Super Admin Permission Check
    |--------------------------------------------------------------------------
    */

    public function hasPermission($slug): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        return $this->permissions()
            ->where('slug', $slug)
            ->exists();
    }

    public function hasAdminPermission(
        string $module,
        string $action = 'view'
    ): bool {

        if ($this->isSuperAdmin()) {
            return true;
        }

        if (! $this->adminRole || ! $this->adminRole->is_active) {
            return false;
        }

        $permission = $this->adminRole
            ->permissions()
            ->where('module', $module)
            ->first();

        if (! $permission) {
            return false;
        }

        return match ($action) {

            'view' => $permission->can_view,

            'create' => $permission->can_create,

            'update' => $permission->can_update,

            'delete' => $permission->can_delete,

            default => false,
        };
    }
}
