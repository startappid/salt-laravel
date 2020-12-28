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
                    'email' => 'superadmin@sagara.id',
                    'password' => bcrypt('P@s5!No12D'),
                    'status' => 'active',
                    'email_verified_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'first_name' => "Admin",
                    'last_name' => "Administrator",
                    'username' => 'admin',
                    'email' => 'admin@sagara.id',
                    'password' => bcrypt('P@s5!No12D'),
                    'status' => 'active',
                    'email_verified_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'first_name' => "Admin",
                    'last_name' => "Operator",
                    'username' => 'operator',
                    'email' => 'operator@sagara.id',
                    'password' => bcrypt('P@s5!No12D'),
                    'status' => 'active',
                    'email_verified_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'first_name' => "Admin",
                    'last_name' => "Reporter",
                    'username' => 'reporter',
                    'email' => 'reporter@sagara.id',
                    'password' => bcrypt('P@s5!No12D'),
                    'status' => 'active',
                    'email_verified_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'first_name' => "Admin",
                    'last_name' => "Manager",
                    'username' => 'manager',
                    'email' => 'manager@sagara.id',
                    'password' => bcrypt('P@s5!No12D'),
                    'status' => 'active',
                    'email_verified_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'first_name' => "Admin",
                    'last_name' => "HRD",
                    'username' => 'hrd',
                    'email' => 'hrd@sagara.id',
                    'password' => bcrypt('P@s5!No12D'),
                    'status' => 'active',
                    'email_verified_at' => date('Y-m-d H:i:s'),
                ]
            ];

        DB::table('users')->insert($users);
    }
}
