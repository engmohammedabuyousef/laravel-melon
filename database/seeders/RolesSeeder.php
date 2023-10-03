<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            /* Administrator */
            // 1
            ['name' => 'Administrator', 'guard_name' => 'admin'],
        ]);
    }
}
