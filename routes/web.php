<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\BidController;


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
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/login', function () {
    return view('auth/login');
});

Route::get('/signup', function () {
    return view('auth/signup');
});

Route::get('/forget', function () {
    return view('auth_old/email');
});

Route::get('/new-password', function () {
    return view('auth/newpassword');
});

Route::get('/test', function () {
    // return view('auth/newpassword');
  echo ini_get('memory_limit');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/user', function () {
    return view('Admin/user/index');
});

Route::get('/property', function () {
    return view('Admin/Properties/index');
});

Route::get('/bid', function () {
    return view('Admin/Bid/index');
});

Route::get('/market', function () {
    return view('Admin/Market/index');
});

//Users
Route::post('/users-data', [App\Http\Controllers\UserController::class, 'data'])->name('user-data');
Route::resource('users', UserController::class);

//Property
Route::post('/property-data', [App\Http\Controllers\PropertyController::class, 'data'])->name('property-data');
Route::resource('property', PropertyController::class);

////Bid
Route::post('/bid-data', [App\Http\Controllers\BidController::class, 'data'])->name('bid-data');
Route::post('/bid-user', [App\Http\Controllers\BidController::class, 'user'])->name('bid-user');
Route::resource('bid', BidController::class);
