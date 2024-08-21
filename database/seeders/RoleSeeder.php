<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('roles')->insert([

            [
                'role_name' => 'admin',
            ],
            [
                'role_name' => 'regular_user',
            ],
            [
                'role_name' => 'api_consumer',
            ],
            [
                'role_name' => 'guest',
            ]
            ]);
    }
}
