<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArticleController;

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
    return view('home.dashboard_home');
});

Route::get('write', function () {
    return view('main.write');
});

Route::get('ourstory', function () {
    return view('home.ourstory');
});
Route::get('homewrite', function () {
    return view('home.homewrite');
});
Route::get('menuutama', function () {
    return view('main.menuutama');
});

Route::get('notif', function () {
    return view('main.notif');
});

Route::resource('/profile', UserController::class);
Route::resource('/article', ArticleController::class);

Route::get('editprofile', function () {
    return view('editprofile');
});