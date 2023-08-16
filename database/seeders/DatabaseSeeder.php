<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Laravel\Passport\Client;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RolesPermissionsSeeder::class,
        ]);

        $admin = new Admin();
        $admin->name = 'Admin';
        $admin->email = 'admin@admin.com';
        $admin->password = bcrypt('password');
        $admin->last_login_at = now();
        $admin->save();

        $user = new User();
        $user->name = 'First User';
        $user->username = 'first_user';
        $user->phone_number = '123456789';
        $user->email = 'test@test.com';
        $user->password = bcrypt('password');
        $user->last_login_at = now();
        $user->save();

        $client = new Client();
        $client->id = '99cbc47b-dea3-475b-b38f-5beb04a0dd5b';
        $client->secret = 'hJ1OTRMLoukNxKxnhJexEptwKmlWPelihcJbsGxY';
        $client->name = 'Laravel Password Grant Client';
        $client->redirect = 'http://localhost';
        $client->provider = 'users';
        $client->personal_access_client = false;
        $client->password_client = true;
        $client->revoked = false;
        $client->save();
    }
}
