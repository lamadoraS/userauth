<?php

use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\Auth\ForgotpasswordController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForgotPasswordController as ControllersForgotPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/index', [HomeController::class, 'dashboard']);
Route::get('/', [HomeController::class, 'welcome']);
Route::get('/login', function () { return view('auth.login'); });
Route::get('/register', function () {  return view('auth.register'); });
Route::resource('users', UserController::class); 
Route::resource('roles', RoleController::class); 
Route::resource('permissions', PermissionController::class); 

//auditlogs
Route::resource('auditlogs', AuditLogController::class); 

//tokens
Route::resource('tokens', TokenController::class); 



Route::get('/dashboard', [DashboardController::class, 'dashboard']);


//user
Route::get('/userRole/{id}', [UserController::class, 'userCreate'])->name('userRole');
Route::get('/userRoleEdit/{id}/{userId}', [UserController::class, 'userEdit'])->name('userEdit');
Route::get('/userRoleDelete/{id}/{userId}', [UserController::class, 'userDelete'])->name('userDelete');
Route::get('/userRoleShow/{id}/{userId}', [UserController::class, 'userShow'])->name('userShow');


//role
Route::get('/createRole/{id}', [RoleController::class, 'roleCreate'])->name('createRole');
Route::get('/editRole/{id}/{roleId}', [RoleController::class, 'roleEdit'])->name('editRole');
Route::get('/DeleteRole/{id}/{roleId}', [RoleController::class, 'roleDelete'])->name('roleDelete');

// Permissions
Route::get('/createPermissions/{id}', [PermissionController::class, 'permissionCreate'])->name('createPermissions');
Route::get('/editPermissions/{id}/{permissionId}', [PermissionController::class, 'permissionEdit'])->name('editPermissions');
Route::get('/deletePermissions/{id}/{permissionId}', [PermissionController::class, 'permissionDelete'])->name('deletePermissions');



//Forgot Password Routes
Route::get('/forgot-password', [ControllersForgotPasswordController::class, 'index']);
Route::post('/verifyEmail', [ControllersForgotPasswordController::class, 'verify']);
Route::get('/forgotModal', [ControllersForgotPasswordController::class, 'verifyModal']);
Route::post('/verifyCode', [ControllersForgotPasswordController::class, 'verifyCode']);
Route::get('/reset-password', [ControllersForgotPasswordController::class, 'showResetForm']);
Route::post('/reset-password', [ControllersForgotPasswordController::class, 'resetPassword']);



//UserRole Blade
Route::get('/byRole/{id}', [HomeController::class, 'byRole']);

//guestRole Blade

Route::get('/guestRole/{id}', [HomeController::class, 'guestRole']);

//Generate Token

Route::get('/generateToken/{id}', [UserController::class, 'generate']);









