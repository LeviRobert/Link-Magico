<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->middleware('auth');


Route::group(['middleware' => ['guest']], function() {
    Route::get('login', [App\Http\Controllers\AuthController::class, 'showLogin'])->name('login.show');
    Route::post('login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
    Route::get('verify-login/{token}', [App\Http\Controllers\AuthController::class,'verifyLogin'])->name('verify-login');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});


