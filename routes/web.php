<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TagAdminController;
use App\Http\Controllers\UserAdminController;
use App\Http\Controllers\ArticleAdminController;
use App\Http\Controllers\ArticleAdminEditController;
use App\Http\Controllers\CommentListAdminController;
use App\Http\Controllers\CommentArticleAdminController;

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

Route::get('/signin', [AuthController::class, 'signin'])->name('signin')->middleware('guest');

Route::post('/signup', [AuthController::class, 'signup'])->name('signup');
Route::post('/menuutama', [AuthController::class, 'signup'])->name('menuutama');
Route::post('/signin', [AuthController::class, 'authentication'])->middleware('guest');
Route::post('/menuutama', [AuthController::class, 'authentication'])->name('menuutama');
Route::get('/signout', [AuthController::class, 'signout'])->middleware('auth');


Route::get('/signup', function () {
    return view('signup');
})->middleware('guest');

Route::get('/ourstory', function () {
    return view('ourstory');
});

Route::get('/write', function () {
    return view('write');
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

Route::get('/profile', function () {
    return view('profile');
})->middleware('auth');

Route::get('/library', function () {
    return view('library');
})->middleware('auth');

Route::get('/stories', function () {
    return view('stories');
})->middleware('auth');

Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth', 'must-admin']);


Route::middleware(['auth', 'must-admin'])->group(function () {
    Route::resource('/admin/account', UserAdminController::class);
});

Route::middleware(['auth', 'must-admin'])->group(function () {
    Route::resource('/admin/tag', TagAdminController::class);
});

Route::middleware(['auth', 'must-admin'])->group(function () {
    Route::resource('/admin/article', ArticleAdminController::class);
});


Route::put('/articles/{id}/update-status', [ArticleAdminController::class, 'updateStatus'])->name('article.update-status')->middleware(['auth', 'must-admin']);

Route::middleware(['auth', 'must-admin'])->group(function () {
    Route::resource('/admin/administrator', ArticleAdminEditController::class);
});

Route::middleware(['auth', 'must-admin'])->group(function () {
    Route::resource('/admin/comment', CommentArticleAdminController::class);
});


Route::put('/comment/{id}/update-status', [CommentArticleAdminController::class, 'updateStatus'])->name('comment.update-status')->middleware(['auth', 'must-admin']);

Route::middleware(['auth', 'must-admin'])->group(function () {
    Route::resource('/admin/list', CommentListAdminController::class);
});

Route::put('/comment-list/{id}/update-status', [CommentListAdminController::class, 'updateStatus'])->name('list.update-status')->middleware(['auth', 'must-admin']);