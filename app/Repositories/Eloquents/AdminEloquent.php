<?php

namespace App\Repositories\Eloquents;

use App\Models\Admin;
use App\Models\Role;
use App\Models\User;

class AdminEloquent
{
    public function index($dataTable)
    {
        $data = [
            'title' => __('dashboard.admins_list'),
        ];

        return $dataTable->render('dashboard.admins.index', $data);
    }

    public function create()
    {
        $data = [
            'roles' => Role::all(),
        ];

        return view('dashboard.admins.create', $data);
    }

    public function store(array $data)
    {
        $admin = new Admin();

        $admin->email = $data['email'];
        $admin->password = bcrypt($data['password']);
        $admin->name = $data['name'];

        if (isset($data['photo'])) {
            $admin->photo = $this->storeImage('users', 'photo');
        }

        $admin->syncRoles($data['role']);

        if ($admin->save()) {
            return redirect('/admin/admins')->with('success', 'Admin created successfully');
        }
    }

    public function show($admin)
    {
        return view('dashboard.admins.show', compact('admin'));
    }

    public function edit($id)
    {
        $admin = Admin::find($id);

        return view('dashboard.admins.edit', compact('admin'));
    }

    public function update(array $data, $admin)
    {
        dd($admin);
//        $admin->syncRoles(['writer', 'admin']);
    }

    public function destroy($admin)
    {
        //
    }
}
