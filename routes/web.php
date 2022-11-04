<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\MarketController;


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
    return view('auth.login');
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
    return view('auth_old/newpassword');
});

Route::get('/test', function () {
    // return view('auth/newpassword');
  echo ini_get('memory_limit');
});

Route::get('/forget', function () {
    return view('auth_old/email');
});

// Auth::routes();
Auth::routes(['register' => false, 'verify' => true]);


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

Route::get('/settings', function () {
    return view('Admin.setting');
});

Route::get('/support', function () {
    return view('Admin.support');
});

//Users
Route::post('/users-data', [App\Http\Controllers\UserController::class, 'data'])->name('user-data');
Route::get('/create/password/{email}/{token}', [App\Http\Controllers\UserController::class, 'createPassword']);
Route::post('/store/password', [App\Http\Controllers\UserController::class, 'storePassword'])->name('store.password');
Route::resource('users', UserController::class);

//Property
Route::post('/property-data', [App\Http\Controllers\PropertyController::class, 'data'])->name('property-data');
// code by aiman
Route::get('/property-view/{id}', [App\Http\Controllers\PropertyController::class, 'buyerPropertyView'])->name('property-view');
// code by aiman
Route::get('/property-create/{id}', [App\Http\Controllers\PropertyController::class, 'view'])->name('property-view');
Route::resource('property', PropertyController::class);

////Bid
Route::post('/bid-status', [App\Http\Controllers\BidController::class, 'status'])->name('bid-status');
Route::post('/bid-data', [App\Http\Controllers\BidController::class, 'data'])->name('bid-data');
// code by aiman
Route::post('/bid-create', [App\Http\Controllers\BidController::class, 'store']);
// code by aiman
Route::resource('bid', BidController::class);

////Market
Route::post('/market-data', [App\Http\Controllers\MarketController::class, 'data'])->name('market-data');
Route::resource('market', MarketController::class);

