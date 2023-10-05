<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
//        $menus = \App\Http\Resources\PermissionResource::collection(authAdmin()->getAllPermissions()->where('parent_id', 0)->where('in_menu', 1))->resolve();
//
//        return $menus;

        addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);

        $data = [
            'admins_count' => Admin::count(),
            'users_count' => User::count(),
        ];

        return view('pages.dashboards.index', $data);
    }
}
