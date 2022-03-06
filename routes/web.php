<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

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

Route::get('/', [AuthController::class, 'index']);

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('register', [AuthController::class, 'register'])->name('register');

Route::get('signin', [AuthController::class, 'signin'])->name('signin');
Route::get('signup', [AuthController::class, 'signup'])->name('signup');

// Protecting Routes
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::resource('home', [AuthController::class, 'home']);

    // API route for logout user
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});