<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SqlCountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = base_path('database/seeders/indonesia.sql');
        $sql = file_get_contents($countries);
        DB::unprepared($sql);
    }
}
