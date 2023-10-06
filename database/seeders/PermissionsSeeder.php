<?php

namespace Database\Seeders;

use App\Models\Role;
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
            ['name' => 'dashboard', 'category' => 'Dashboard', 'parent_id' => 0, 'link' => 'dashboard', 'guard_name' => 'admin', 'in_menu' => 1, 'icon' => 'element-1'],

            /* Admins & Roles Management */
            // 2
            ['name' => 'admins and roles', 'category' => 'Administration Management', 'parent_id' => 0, 'link' => '#', 'guard_name' => 'admin', 'in_menu' => 1, 'icon' => 'element-2'],
            /* Admins Management */
            // 3
            ['name' => 'admins', 'category' => 'Administration Management', 'parent_id' => 2, 'link' => 'admins.index', 'guard_name' => 'admin', 'in_menu' => 1, 'icon' => 'element-3'],
            // 4
            ['name' => 'create admin', 'category' => 'Administration Management', 'parent_id' => 3, 'link' => 'admins.create', 'guard_name' => 'admin', 'in_menu' => 0, 'icon' => ''],
            // 5
            ['name' => 'edit admin', 'category' => 'Administration Management', 'parent_id' => 3, 'link' => 'admin.edit', 'guard_name' => 'admin', 'in_menu' => 0, 'icon' => ''],
            // 6
            ['name' => 'delete admin', 'category' => 'Administration Management', 'parent_id' => 3, 'link' => 'admins.delete', 'guard_name' => 'admin', 'in_menu' => 0, 'icon' => ''],

            /* Roles Management */
            // 7
            ['name' => 'roles', 'category' => 'Administration Management', 'parent_id' => 2, 'link' => 'roles.index', 'guard_name' => 'admin', 'in_menu' => 1, 'icon' => 'element-4'],
            // 8
            ['name' => 'create role', 'category' => 'Administration Management', 'parent_id' => 7, 'link' => 'roles.create', 'guard_name' => 'admin', 'in_menu' => 0, 'icon' => ''],
            // 9
            ['name' => 'edit role', 'category' => 'Administration Management', 'parent_id' => 7, 'link' => 'roles.edit', 'guard_name' => 'admin', 'in_menu' => 0, 'icon' => ''],
            // 10
            ['name' => 'delete role', 'category' => 'Administration Management', 'parent_id' => 7, 'link' => 'roles.delete', 'guard_name' => 'admin', 'in_menu' => 0, 'icon' => ''],

            /* Users Management */
            // 11
            ['name' => 'users', 'category' => 'Users Management', 'parent_id' => 0, 'link' => 'users.index', 'guard_name' => 'admin', 'in_menu' => 1, 'icon' => 'element-5'],
            // 12
            ['name' => 'change user activation', 'category' => 'Users Management', 'parent_id' => 11, 'link' => 'users.change-status', 'guard_name' => 'admin', 'in_menu' => 0, 'icon' => ''],
            // 13
            ['name' => 'create user', 'category' => 'Users Management', 'parent_id' => 11, 'link' => 'users.create', 'guard_name' => 'admin', 'in_menu' => 0, 'icon' => ''],
            // 14
            ['name' => 'edit user', 'category' => 'Users Management', 'parent_id' => 11, 'link' => 'users.edit', 'guard_name' => 'admin', 'in_menu' => 0, 'icon' => ''],
            // 15
            ['name' => 'delete user', 'category' => 'Users Management', 'parent_id' => 11, 'link' => 'users.delete', 'guard_name' => 'admin', 'in_menu' => 0, 'icon' => ''],


            /* Notifications Management */
            // 16
            ['name' => 'notifications', 'category' => 'Notifications Management', 'parent_id' => 0, 'link' => 'notifications.create', 'guard_name' => 'admin', 'in_menu' => 1, 'icon' => 'element-6'],
        ]);

        $role = Role::first();

        if ($role) {
            $permissions = Permission::all();
            $role->syncPermissions($permissions);

            $admin = Admin::first();

            if ($admin) {
                $admin->assignRole($role);
            }
        }
    }
}
