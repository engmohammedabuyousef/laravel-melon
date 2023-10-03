<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as PermissionSpatie;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Traits\RefreshesPermissionCache;

class Permission extends PermissionSpatie
{
    use HasRoles;
    use RefreshesPermissionCache;

    protected $guarded = [];

    public function children()
    {
        return $this->hasMany(Permission::class, 'parent_id', 'id');
    }
}
