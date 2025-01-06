<?php

use App\Consts\UserRoleConst;
use App\Http\Controllers\AdminDashboard;
use App\Http\Controllers\ManagerDashboard;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\AuthController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login-view', [AuthController::class, 'loginview'])->name('login');
Route::get('/register-view', [AuthController::class, 'registeview'])->name('register.view');


// Route group for USER role
Route::middleware(['auth:web', 'role:' . UserRoleConst::USER])->group(function () {
    Route::get('/home', [UserController::class, 'home_view'])->name('home');
});

Route::middleware(['auth:web'])->group(function () {
    // Admin Dashboard route
    Route::middleware('role:' . UserRoleConst::ADMIN)->group(function () {
        Route::get('/admin/dashboard', [AdminDashboard::class, 'dashboard_view'])->name('admin.dashboard');
    });

    // Manager Dashboard route
    Route::prefix('manager')
    ->middleware(['auth', 'role:' . UserRoleConst::MANAGER])
    ->name('manager.')
    ->group(function () {
        Route::get('/dashboard', [ManagerDashboard::class, 'index'])->name('dashboard');
        Route::get('/tokens', [TokenController::class, 'index'])->name('tokens.index');

    });
});