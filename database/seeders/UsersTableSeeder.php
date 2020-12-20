<?php

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
                    'email' => 'superadmin@spacebear.id',
                    'password' => bcrypt('P@s5!No12D'),
                    'status' => 'active',
                    'email_verified_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'first_name' => "Admin",
                    'last_name' => "Administrator",
                    'username' => 'admin',
                    'email' => 'admin@spacebear.id',
                    'password' => bcrypt('P@s5!No12D'),
                    'status' => 'active',
                    'email_verified_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'first_name' => "Admin",
                    'last_name' => "Operator",
                    'username' => 'operator',
                    'email' => 'operator@spacebear.id',
                    'password' => bcrypt('P@s5!No12D'),
                    'status' => 'active',
                    'email_verified_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'first_name' => "Admin",
                    'last_name' => "Reporter",
                    'username' => 'reporter',
                    'email' => 'reporter@spacebear.id',
                    'password' => bcrypt('P@s5!No12D'),
                    'status' => 'active',
                    'email_verified_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'first_name' => "Admin",
                    'last_name' => "Manager",
                    'username' => 'manager',
                    'email' => 'manager@spacebear.id',
                    'password' => bcrypt('P@s5!No12D'),
                    'status' => 'active',
                    'email_verified_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'first_name' => "Admin",
                    'last_name' => "HRD",
                    'username' => 'hrd',
                    'email' => 'hrd@spacebear.id',
                    'password' => bcrypt('P@s5!No12D'),
                    'status' => 'active',
                    'email_verified_at' => date('Y-m-d H:i:s'),
                ]
            ];

        DB::table('users')->insert($users);
    }
}
