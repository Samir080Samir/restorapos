<?php

namespace App\Models;

use App\Models\AdminRole;
use Illuminate\Database\Eloquent\Model;

class AdminRolePermission extends Model
{
    protected $fillable = [
        'admin_role_id',
        'module',
        'can_view',
        'can_create',
        'can_update',
        'can_delete',
    ];

    protected $casts = [
        'can_view' => 'boolean',
        'can_create' => 'boolean',
        'can_update' => 'boolean',
        'can_delete' => 'boolean',
    ];

    public function role()
    {
        return $this->belongsTo(AdminRole::class, 'admin_role_id');
    }
}
