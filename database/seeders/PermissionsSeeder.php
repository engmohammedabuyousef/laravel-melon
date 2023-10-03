<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

use App\Models\Admin;
use App\Models\Permission;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        Artisan::call('cache:forget spatie.role.cache');
        Artisan::call('cache:forget spatie.permission.cache');
        Artisan::call('cache:clear');
        Artisan::call('config:cache');

        DB::table('model_has_permissions')->truncate();
        DB::statement("SET foreign_key_checks=0");
        Permission::truncate();
        DB::statement("SET foreign_key_checks=1");
        Permission::insert([
            /* Dashboard */
            // 1
            ['name' => 'dashboard', 'category' => 'Dashboard', 'parent_id' => 0, 'link' => 'dashboard', 'guard_name' => 'admin', 'in_menu' => 1, 'icon' => 'dashboard'],

            /* Admins Management */
            // 2
            ['name' => 'admins and roles', 'category' => 'Administration Management', 'parent_id' => 0, 'link' => '#', 'guard_name' => 'admin', 'in_menu' => 1, 'icon' => 'admin'],
            // 3
            ['name' => 'admins', 'category' => 'Administration Management', 'parent_id' => 2, 'link' => '#', 'guard_name' => 'admin', 'in_menu' => 1, 'icon' => 'menu-bullet menu-bullet-line'],
            // 4
            ['name' => 'admins list', 'category' => 'Administration Management', 'parent_id' => 3, 'link' => 'admins.index', 'guard_name' => 'admin', 'in_menu' => 1, 'icon' => 'menu-bullet menu-bullet-line'],
            // 5
            ['name' => 'create admin', 'category' => 'Administration Management', 'parent_id' => 3, 'link' => 'admins.create', 'guard_name' => 'admin', 'in_menu' => 0, 'icon' => 'admin'],
            // 6
            ['name' => 'edit admin', 'category' => 'Administration Management', 'parent_id' => 3, 'link' => 'admin.edit', 'guard_name' => 'admin', 'in_menu' => 0, 'icon' => 'admin'],
            // 7
            ['name' => 'delete admin', 'category' => 'Administration Management', 'parent_id' => 3, 'link' => 'admins.delete', 'guard_name' => 'admin', 'in_menu' => 0, 'icon' => 'admin'],

            /* Roles Management */
            // 8
            ['name' => 'roles', 'category' => 'Administration Management', 'parent_id' => 2, 'link' => '#', 'guard_name' => 'admin', 'in_menu' => 1, 'icon' => 'menu-bullet menu-bullet-line'],
            // 9
            ['name' => 'roles list', 'category' => 'Administration Management', 'parent_id' => 8, 'link' => 'roles.index', 'guard_name' => 'admin', 'in_menu' => 1, 'icon' => 'menu-bullet menu-bullet-line'],
            // 10
            ['name' => 'create role', 'category' => 'Administration Management', 'parent_id' => 8, 'link' => 'roles.create', 'guard_name' => 'admin', 'in_menu' => 1, 'icon' => 'menu-bullet menu-bullet-line'],
            // 11
            ['name' => 'edit role', 'category' => 'Administration Management', 'parent_id' => 8, 'link' => 'roles.edit', 'guard_name' => 'admin', 'in_menu' => 0, 'icon' => 'admin'],
            // 12
            ['name' => 'delete role', 'category' => 'Administration Management', 'parent_id' => 8, 'link' => 'roles.delete', 'guard_name' => 'admin', 'in_menu' => 0, 'icon' => 'admin'],

            /* Users Management */
            // 13
            ['name' => 'customers', 'category' => 'Customers Management', 'parent_id' => 0, 'link' => 'customers.index', 'guard_name' => 'admin', 'in_menu' => 1, 'icon' => 'customer'],
            // 14
            ['name' => 'change customer activation', 'category' => 'Customers Management', 'parent_id' => 13, 'link' => 'customers.change-status', 'guard_name' => 'admin', 'in_menu' => 0, 'icon' => 'customer'],
            // 15
            ['name' => 'create customer', 'category' => 'Customers Management', 'parent_id' => 13, 'link' => 'customers.create', 'guard_name' => 'admin', 'in_menu' => 0, 'icon' => 'customer'],
            // 16
            ['name' => 'edit customer', 'category' => 'Customers Management', 'parent_id' => 13, 'link' => 'customers.edit', 'guard_name' => 'admin', 'in_menu' => 0, 'icon' => 'customer'],
            // 17
            ['name' => 'delete customer', 'category' => 'Customers Management', 'parent_id' => 13, 'link' => 'customers.delete', 'guard_name' => 'admin', 'in_menu' => 0, 'icon' => 'customer'],
        ]);

        $admin = Admin::first();

        if ($admin) {
            $permissions = Permission::pluck('id')->toArray();
            $admin->syncPermissions($permissions);
        }
    }
}
