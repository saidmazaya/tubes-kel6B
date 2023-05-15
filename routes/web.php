<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagAdminController;
use App\Http\Controllers\UserAdminController;
use App\Http\Controllers\ArticleAdminController;

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

Route::get('/profile', function () {
    return view('profile');
});

Route::get('/library', function () {
    return view('library');
});

Route::get('/stories', function () {
    return view('stories');
});

Route::get('/dashboard', function () {
    return view('admin.index');
});

Route::get('/userfollow', function () {
    return view('user-follow');
});

Route::get('/edit', function () {
    return view('editprofile');
});


// Route::middleware(['auth'])->group(function () {
    
// });
Route::resource('/admin/account', UserAdminController::class);

Route::resource('/admin/tag', TagAdminController::class);

Route::resource('/admin/article', ArticleAdminController::class);

Route::put('/articles/{id}/update-status', [ArticleAdminController::class, 'updateStatus'])->name('article.update-status');