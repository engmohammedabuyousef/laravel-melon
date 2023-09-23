<?php

namespace App\Repositories\Eloquents;

use App\Models\Admin;
use App\Models\Role;

class RoleEloquent
{
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

    public function show($admin)
    {
        //
    }

    public function edit($role)
    {
        return view('dashboard.roles.edit', compact('role'));
    }

    public function update(array $data, $admin)
    {
        return 'update';
    }

    public function destroy($admin)
    {
        //
    }
}
