<?php

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
});
Route::get('/notif', function () {
    return view('main.notif');
});

