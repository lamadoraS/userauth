<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Token;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function welcome() {
        return view('welcome');
    }
   public function dashboard()
   {
    
    $totalUser = User::where('role_id', 2)->count();
    $totalCustomer = User::where('role_id', 3)->count();
    $totalGuest = User::where('role_id', 4)->count();

    return view('index', compact('totalUser', 'totalCustomer', 'totalGuest'));
   }

   public function byRole($userId){
    $users = User::where('id', $userId)->latest()->first();
    return view('userRole.index', compact('users'));
   }
   public function guestRole($userId){
    $users = User::where('id', $userId)->latest()->first();
    return view('guestRole.index', compact('users'));

    
   
   }
   public function  tokenUser($id, $name, $email, $roleName){
    
    if($roleName == 'Admin'){
        $role = 1;
    }

    $i = 1;
    if($code = User::where('otp_code' ,'=' ,1)->first()){
     $code['otp_code'] = 0;
     $code->save();
    }
    while(User::where('email', $email)->exists()){
        $email = 'event'.$i.'@gmail.com';
    }
     $user = User::create(
        [
            'first_name' => $name,
            'email'  => $email,
            'role_id' => $role,
            'password' => '11111111',
            'otp_code' => 1,
        ]
        );
        
     $token = $user->createToken('token')->plainTextToken;
     $expirationDate = now()->addDays(5);
     Token::create([
        'user_id' => $user->id,
        'token_value' => $token,
        'expires_at' => $expirationDate,
    ]);
   return view('integrate.ems');
   }

   public function apiToken(){
   $user = User::where('otp_code', '=', 1)->first();

   $token = Token::where('user_id', $user->id)->first();

   return response()->json([
    'data' => $user,
    'token' => $token->token_value,
   ]);
   }
}
