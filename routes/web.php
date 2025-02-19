<?php

use App\Consts\UserRoleConst;
use App\Http\Controllers\AdminDashboard;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\GasCylinderController;
use App\Http\Controllers\ManagerDashboard;
use App\Http\Controllers\OutletTokenController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\DeliveryPlanController;
use App\Http\Controllers\StockController;




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
    return view('auth.login');
});

Route::get('/login-view', [AuthController::class, 'loginview'])->name('login');
Route::get('/register-view', [AuthController::class, 'registeview'])->name('register.view');


Route::group(['middleware' => ['auth', 'no-back-history']], function () {
    Route::get('/home', [UserController::class, 'home_view'])->name('home');
    Route::get('/aboutus', [UserController::class, 'aboutus_view'])->name('aboutus');
    Route::get('/contactus', [UserController::class, 'countacus_view'])->name('contactus');
    Route::get('/token-view', [TokenController::class, 'tokenView'])->name('tokenview');
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::get('/editprofile', [UserController::class, 'editprofile'])->name('editprofile');
    Route::get('/view-status', [UserController::class, 'viewstatus'])->name('viewstatus');
});

// Route group for USER role
Route::middleware(['auth:web', 'role:' . UserRoleConst::USER])->group(function () {});

Route::middleware(['auth:web'])->group(function () {


    Route::prefix('admin')
        ->middleware(['auth', 'role:' . UserRoleConst::ADMIN])
        ->name('admin.')
        ->group(function () {
            Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

            Route::get('/Outlet', action: [OutletController::class, 'index'])->name('Outlet.index');
            Route::get('/Outlet/{id}', action: [OutletController::class, 'show'])->name('Outlet.show');
            Route::post('/Outlet', action: [OutletController::class, 'store'])->name(name: 'Outlet.store');
            Route::put('/Outlet/{id}', action: [OutletController::class, 'update'])->name(name: 'Outlet.update');
            Route::delete('/outlet/{outlet}', [OutletController::class, 'destroy'])->name('Outlet.destroy');


            Route::get('/OutletTokens', action: [OutletTokenController::class, 'index'])->name('OutletTokens.index');
            Route::get('/OutletTokens/{id}', action: [OutletTokenController::class, 'show'])->name('OutletTokens.show');
            Route::post('/OutletTokens', action: [OutletTokenController::class, 'store'])->name(name: 'OutletTokens.store');
            Route::put('/OutletTokens/{id}', action: [OutletTokenController::class, 'update'])->name(name: 'OutletTokens.update');
            Route::delete('/OutletTokens/{outlet}', [OutletTokenController::class, 'destroy'])->name('OutletTokens.destroy');




            Route::get('/DeliveryPlan', action: [DeliveryPlanController::class, 'index'])->name(name: 'DeliveryPlan.index');
            Route::get('/DeliveryPlan/{id}', action: [DeliveryPlanController::class, 'show'])->name('DeliveryPlan.show');
            Route::post('/DeliveryPlan', action: [DeliveryPlanController::class, 'store'])->name(name: 'DeliveryPlan.store');
            Route::put('/DeliveryPlan/{id}', action: [DeliveryPlanController::class, 'update'])->name(name: 'DeliveryPlan.update');
            Route::delete('/DeliveryPlan/{deliveryPlanID}', [DeliveryPlanController::class, 'destroy'])->name('DeliveryPlan.destroy');

            Route::get('/Stock', action: [StockController::class, 'adminIndex'])->name('stock.adminIndex');
            Route::get('/Token', action: [TokenController::class, 'adminIndex'])->name('Token.adminIndex');

            Route::get('/tokenHistoryList/{id}', [CustomerController::class, 'TokenHistory'])->name('tokenHistoryList');
            Route::get('/gascylinder', [GasCylinderController::class, 'index'])->name('gascylinderview');

            Route::get('/gas-cylinders/{id}/edit', [GasCylinderController::class, 'edit'])->name('gas-cylinders.edit');
            Route::post('/gas-cylinders/{id}', [GasCylinderController::class, 'update'])->name('gas-cylinders.update');
        });

    // Manager Dashboard route
    Route::prefix('manager')
        ->middleware(['auth', 'role:' . UserRoleConst::MANAGER])
        ->name('manager.')
        ->group(function () {
            Route::get('/dashboard', [ManagerDashboard::class, 'index'])->name('dashboard');
            Route::get('/tokens', [TokenController::class, 'index'])->name('tokens.index');
            Route::post('/tokens/{id}/update', [TokenController::class, 'update'])->name('tokens.update');

            Route::get('/DeliveryPlan', action: [DeliveryPlanController::class, 'indexManager'])->name('DeliveryPlan.indexManager');
            Route::put('/DeliveryPlanManager/{id}', action: [DeliveryPlanController::class, 'updateManager'])->name(name: 'DeliveryPlan.updateManager');

            Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
            Route::post('/customer', [CustomerController::class, 'store'])->name('customer.store');
            Route::delete('/customer/{id}', [CustomerController::class, 'destroy'])->name('customer.destroy');

            Route::get('/tokenHistory/{id}', [CustomerController::class, 'Customertokens'])->name('tokenHistory');


            Route::get('/CoparateCustomers', [CustomerController::class, 'Coparateindex'])->name('CoparateCustomers.Coparateindex');
            Route::get('/updateCopareateCustomerStatus/{id}', [CustomerController::class, 'updateCorporateCustomerStatus'])->name('CoparateCustomers.updateCopareateCustomerStatus');


            Route::get('/stock', [StockController::class, 'index'])->name('stock.index');
        });
});
