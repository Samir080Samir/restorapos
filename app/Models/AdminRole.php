<?php

namespace App\Models;

use App\Models\AdminRolePermission;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_system',
        'is_active',
    ];

    protected $casts = [
        'is_system' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Rola aid permission-lar.
     */
    public function permissions()
    {
        return $this->hasMany(AdminRolePermission::class);
    }

    /**
     * Bu rola bağlı istifadəçilər.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'admin_role_id');
    }

    /**
     * Rol aktivdir?
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }
}
