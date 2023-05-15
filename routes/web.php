<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;


Route::get('/', function () {
    return view('index');
});
Route::get('/blog', function () {
    return view('blog');
});
Route::get('/ourstory', function () {
    return view('ourstory');
});
Route::get('/write', function () {
    return view('write');
});
Route::get('/signin', function () {
    return view('signin');
});
Route::get('/signup', function () {
    return view('signup');
});
Route::get('/menuutama', function () {
    return view('menuutama');
});
Route::get('/blog-single', function () {
    return view('blog-single');
});
Route::get('/nulis', function () {
    return view('main.write');
})->middleware('auth');

Route::get('/notif', function () {
    return view('main.notif');
})->middleware('auth');

Route::get('/signin', [AuthController::class, 'signin'])->name('signin');

Route::post('/signup', [AuthController::class, 'signup'])->name('signup');
Route::post('/menuutama', [AuthController::class, 'signup'])->name('menuutama');
Route::post('/signin', [AuthController::class, 'authentication']);
Route::post('/menuutama', [AuthController::class, 'authentication'])->name('menuutama');
Route::get('/signout', [AuthController::class, 'signout']);





