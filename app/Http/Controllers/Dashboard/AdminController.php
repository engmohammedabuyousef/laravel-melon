<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\AdminsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admins\CreateAdminRequest;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(AdminsDataTable $dataTable)
    {
        $data = [
            'title' => __('dashboard.admins_list'),
        ];

        return $dataTable->render('admin.admins.index', $data);
    }

    public function create()
    {
        return view('admin.admins.create');
    }

    public function store(CreateAdminRequest $request)
    {
        $admin = new Admin();
        $admin->email = $request->email;
        $admin->name = $request->email;
        $admin->password = $request->email;
        $admin->save();

        return redirect('/admin/admins')->with('success', 'Admin created successfully');
    }

    public function show(Admin $admin)
    {
        return view('admin.admins.show', compact('admin'));
    }

    public function edit(Admin $admin)
    {
        return 'edit';
    }

    public function update(Request $request, Admin $admin)
    {
        //
    }

    public function destroy(Admin $admin)
    {
        //
    }
}
