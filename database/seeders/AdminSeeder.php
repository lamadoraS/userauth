<?php

namespace Database\Seeders;

use App\Models\Token;
use App\Models\User;
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
              'email'=> 'admin@gmail.com',
              'phone_number'=> '09631157992',
              'password'=> Hash::make('12345678'),  
              
            ]
            ]);

          $user = User::first();

          $token = $user->createToken("API TOKEN")->plainTextToken;
        
          Token::create([
              'user_id' => $user->id,
              'token_value' => $token,
          ]);

    }
}
