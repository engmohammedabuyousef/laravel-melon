<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\AdminsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admins\CreateAdminRequest;
use App\Models\Admin;
use App\Repositories\Eloquents\AdminEloquent;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private $admin;

    public function __construct(AdminEloquent $adminEloquent)
    {
        $this->admin = $adminEloquent;
    }

    public function index(AdminsDataTable $dataTable)
    {
        return $this->admin->index($dataTable);
    }

    public function create()
    {
        return $this->admin->create();
    }

    public function store(CreateAdminRequest $request)
    {
        return $this->admin->store($request->all());
    }

    public function show(Admin $admin)
    {
        return $this->admin->show($admin);
    }

    public function edit($id)
    {
        return $this->admin->edit($id);
    }

    public function update(Request $request, $id)
    {
        return $this->admin->update($request->all(), $id);
    }

    public function destroy(Admin $admin)
    {
        return $this->admin->destroy($admin);
    }
}
