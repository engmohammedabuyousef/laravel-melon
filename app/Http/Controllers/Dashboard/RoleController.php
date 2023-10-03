<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\RolesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admins\CreateAdminRequest;
use App\Models\Admin;
use App\Models\Role;
use App\Repositories\Eloquents\RoleEloquent;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private $role;

    public function __construct(RoleEloquent $roleEloquent)
    {
        $this->role = $roleEloquent;
    }

    public function index(RolesDataTable $dataTable)
    {
        return $this->role->index($dataTable);
    }

    public function create()
    {
        return $this->role->create();
    }

    public function store(Request $request)
    {
        return $this->role->store($request->all());
    }

    public function edit($id)
    {
        $role = Role::find($id);

        return $this->role->edit($role);
    }

    public function update(Request $request, $id)
    {
        return $this->role->update($request->all(), $id);
    }

    public function destroy(Role $role)
    {
        return $this->role->destroy($role);
    }
}
