<?php

namespace App\Http\Controllers;

use App\Models\Role;
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
}
