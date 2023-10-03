<?php

namespace App\Repositories\Eloquents;

use App\Models\Permission;
use App\Models\Role;

class RoleEloquent
{
    private $model;

    public function __construct(Role $model)
    {
        $this->model = $model;
    }

    public function index($dataTable)
    {
        $data = [
            'title' => __('dashboard.roles_list'),
        ];

        return $dataTable->render('dashboard.roles.index', $data);
    }

    public function create()
    {
        return view('dashboard.roles.create');
    }

    public function store(array $data)
    {
        $role = new Role();

        $role->name = $data['name'];

        $role->save();

        return redirect('/admin/roles')->with('success', 'Role created successfully');
    }

    public function edit($role)
    {
        $permissions = $permissions = Permission::where('parent_id', 0)->where('guard_name', 'admin')->get();
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        $data = [
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions,
        ];

        return view('dashboard.roles.edit', $data);
    }

    public function update(array $data, $id)
    {
        $permissions = $data['permission'];

        $joinedPermissions = [];

        foreach ($permissions as $permission) {
            $per = Permission::where('name', $permission)->first();
            if ($per->parent_id == 0) {
                $joinedPermissions[] = $permission;
            } else {
                $joinedPermissions[] = $permission;
                $parentPermission = Permission::where('id', $per->parent_id)->first()->name;
                $joinedPermissions[] = $parentPermission;
                if (Permission::where('id', $per->parent_id)->first()->parent_id != 0) {
                    $parentOfParent = Permission::where('id', Permission::where('id', $per->parent_id)->first()->parent_id)->first()->name;
                    $joinedPermissions[] = $parentOfParent;
                }
            }
        }

        $joinedPermissions = array_unique($joinedPermissions);

        $data['permission'] = $joinedPermissions;

        $role = $this->model->find($id);

        $role->update([
            'name' => $data['name'],
        ]);

        $role->syncPermissions($data['permission']);

        return redirect('/admin/roles')->with('success', 'Role updated successfully');
    }

    public function destroy($id)
    {
        //
    }
}
