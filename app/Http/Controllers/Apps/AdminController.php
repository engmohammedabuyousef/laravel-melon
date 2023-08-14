<?php

namespace App\Http\Controllers\Apps;

use App\DataTables\AdminsDataTable;
use App\DataTables\CustomersDataTable;
use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\CreateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

use DataTables;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AdminsDataTable $dataTable)
    {
        return $dataTable->render('admin.admins.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request)
    {
        $user = new User();
        $user->email = $request->email;
        $user->name = $request->email;
        $user->username = $request->email;
        $user->password = $request->email;
        $user->phone_number = $request->email;
        $user->save();

        return redirect('/admin/customers')->with('success', 'Data dumped successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('pages.apps.user-management.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    // public function list()
    // {
    //     return view('pages.apps.user-management.users.new-list');
    // }

    public function list(AdminsDataTable $dataTable)
    {
    return $dataTable->render('admin.admins.index');
    }


    public function customersData()
    {
        // dd('hiiiiii');
        // $users = User::all();

        // return datatables()->of($users)->toJson();

            $data = User::latest()->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);




    }
}
