<?php

use App\Http\Controllers\Auth\ForgetPassword;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\TokenController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/auth/login', [LoginController::class, 'loginUser']);
Route::post('verifyOTP',[LoginController::class,'verifyOTP']);
Route::post('/auth/register', [RegisterController::class, 'createUser']);
Route::post('verifyOtp',[RegisterController::class,'verifyOtp']);
Route::post('resendOtp', [LoginController::class, 'resendOtp']);

Route::get('/tokenGenerated', [HomeController::class, 'apiToken']);


Route::group(['middleware' => ['auth:sanctum']], function(){
});
