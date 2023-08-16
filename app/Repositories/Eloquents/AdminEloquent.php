<?php

namespace App\Repositories\Eloquents;

use App\Models\Admin;

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
        return view('dashboard.admins.create');
    }

    public function store(array $data)
    {
        $admin = new Admin();
        $admin->email = $data['email'];
        $admin->name = $data['email'];
        $admin->password = $data['email'];
        $admin->save();

        return redirect('/admin/admins')->with('success', 'Admin created successfully');
    }

    public function show($admin)
    {
        return view('dashboard.admins.show', compact('admin'));
    }

    public function edit($admin)
    {
        return 'edit';
    }

    public function update(array $data, $admin)
    {
        //
    }

    public function destroy($admin)
    {
        //
    }
}
