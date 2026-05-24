<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OwnerPermission extends Model
{
    protected $fillable = [
        'group',
        'name',
        'slug',
    ];

    public function roles()
    {
        return $this->belongsToMany(
            OwnerRole::class,
            'owner_role_permission',
            'owner_permission_id',
            'owner_role_id'
        );
    }
}
