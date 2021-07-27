<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users =
            [
                [
                    'first_name' => "Super",
                    'last_name' => "Administrator",
                    'username' => 'superadmin',
                    'email' => 'superadmin@startapp.id',
                    'password' => bcrypt('P@s5!No12D'),
                    'status' => 'active',
                    'email_verified_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'first_name' => "Admin",
                    'last_name' => "Administrator",
                    'username' => 'admin',
                    'email' => 'admin@startapp.id',
                    'password' => bcrypt('P@s5!No12D'),
                    'status' => 'active',
                    'email_verified_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'first_name' => "Admin",
                    'last_name' => "Operator",
                    'username' => 'operator',
                    'email' => 'operator@startapp.id',
                    'password' => bcrypt('P@s5!No12D'),
                    'status' => 'active',
                    'email_verified_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'first_name' => "Admin",
                    'last_name' => "Reporter",
                    'username' => 'reporter',
                    'email' => 'reporter@startapp.id',
                    'password' => bcrypt('P@s5!No12D'),
                    'status' => 'active',
                    'email_verified_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'first_name' => "Admin",
                    'last_name' => "Manager",
                    'username' => 'manager',
                    'email' => 'manager@startapp.id',
                    'password' => bcrypt('P@s5!No12D'),
                    'status' => 'active',
                    'email_verified_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'first_name' => "Admin",
                    'last_name' => "HRD",
                    'username' => 'hrd',
                    'email' => 'hrd@startapp.id',
                    'password' => bcrypt('P@s5!No12D'),
                    'status' => 'active',
                    'email_verified_at' => date('Y-m-d H:i:s'),
                ]
            ];

        DB::table('users')->insert($users);
    }
}
