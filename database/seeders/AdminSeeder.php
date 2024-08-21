<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert ([
            [ 
              'role_id' => 1,
              'first_name'=> 'Antonette',
              'last_name'=> 'Lozares',
              'email'=> 'antonette@gmail.com',
              'phone_number'=> '09631157992',
              'password'=> Hash::make('12345678'),  
              
            ]
            ]);

    }
}
