<?php

namespace Database\Seeders;

use App\Models\Admin;
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
