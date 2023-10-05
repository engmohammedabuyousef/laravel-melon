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

    public function allChildren()
    {
        return Permission::whereIn('id', $this->nestedChildren())->get();
    }

    public function nestedChildren($childrenIds = [])
    {
        if ($childrenIds == []) {
            $childrenIds = array_merge($childrenIds, [$this->id]);
        }

        $childrens = $this->hasMany(Permission::class, 'parent_id');
        $childrenIds = array_merge($childrenIds, $childrens->pluck('id')->toArray());

        foreach ($childrens->get() as $child) {
            $childrenIds = $child->nestedChildren($childrenIds);
        }

        return $childrenIds;
    }
}
