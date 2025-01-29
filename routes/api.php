<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\SMSController;


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

Route::middleware('auth:sanctum')->group(function () {

});
Route::post('/register', [AuthController::class, 'register'])->name('register.api');
Route::post('/registerByAdmin', [AuthController::class, 'registerByAdmin'])->name('registerByAdmin.api');
Route::post('/updateCustomer', [AuthController::class, 'updateCustomer'])->name('updateCustomer.api');


Route::post('/login', [AuthController::class, 'login'])->name('login.api');

Route::post('/issue-token', [TokenController::class, 'issueToken'])->name('api.issueToken');
Route::post('/issue-token-api', [TokenController::class, 'issueTokenAPI'])->name('api.issueTokenAPI');





Route::get('/token-history/{id}', [TokenController::class, 'getTokenHistoryByID']);

Route::post('/send-sms', [SMSController::class, 'sendSMS']);

Route::post('/assign-newUser', [TokenController::class, 'assignNewUserToToken']);


Route::post('/contact', [EmailController::class, 'submitForm'])->name('contact.submit');

Route::post('/logout', function () {
    auth()->logout();
    return redirect()->route('login');
})->name('logout');


Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');