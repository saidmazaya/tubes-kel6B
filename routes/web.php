<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\TagAdminController;
use App\Http\Controllers\FollowingController;
use App\Http\Controllers\UserAdminController;
use App\Http\Controllers\ProfileSetController;
use App\Http\Controllers\ClapArticleController;
use App\Http\Controllers\ArticleAdminController;
use App\Http\Controllers\CommentArticleController;
use App\Http\Controllers\ArticleAdminEditController;
use App\Http\Controllers\CommentListAdminController;
use App\Http\Controllers\ClapCommentArticleController;
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

Route::get('/menuutama', [ArticleController::class, 'index']);

Route::get('/write-article', [ArticleController::class, 'create'])->name('write-article')->middleware('auth');
Route::post('/write-article-store', [ArticleController::class, 'store'])->name('write-article.store')->middleware('auth');
Route::get('/write-article/{id}/edit', [ArticleController::class, 'edit'])->name('write-article.edit')->middleware('auth');
Route::put('/write-article-update/{id}', [ArticleController::class, 'update'])->name('write-article.update')->middleware('auth');
Route::get('/article/{id}', [ArticleController::class, 'show'])->name('article.detail');
Route::delete('/article-delete/{id}', [ArticleController::class, 'destroyDraft'])->name('article.destroy-draft')->middleware('auth');
Route::delete('/article-delete-published/{id}', [ArticleController::class, 'destroyPublished'])->name('article.destroy-published')->middleware('auth');

Route::delete('/write-article-delete-tes/{id}', [ArticleController::class, 'destroyArticle'])->name('write-article.destroy-article')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::resource('/komentar', CommentArticleController::class);
});

Route::get('/clap/{id}', [ClapArticleController::class, 'clap'])->middleware('auth');
Route::get('/clap-comment/{id}', [ClapCommentArticleController::class, 'clap'])->middleware('auth');

Route::get('/notif', function () {
    return view('main.notif');
})->middleware('auth');

Route::post('/profile/{user}/follows', [FollowingController::class, 'store'])->name('following.store')->middleware('auth');
Route::get('/profile/{user}/following', [FollowingController::class, 'following'])->name('profile.following')->middleware('auth');
Route::get('/profile/{user}/follower', [FollowingController::class, 'follower'])->name('profile.follower')->middleware('auth');

Route::get('/profile/{id}', [ProfileSetController::class, 'show'])->name('profile')->middleware('auth');
Route::get('/profile/{username}/edit', [ProfileSetController::class, 'edit'])->name('profile.edit')->middleware('auth');
Route::put('/profile-update/{id}', [ProfileSetController::class, 'update'])->name('profile.update')->middleware('auth');

Route::get('/profile/{username}/about', function () {
    return view('about');
})->middleware('auth');
Route::put('/about-update/{id}', [ProfileSetController::class, 'updateAbout'])->name('about.update')->middleware('auth');

Route::get('/library', function () {
    return view('library');
})->middleware('auth');

Route::get('/stories/draft/{id}', [ArticleController::class, 'draft'])->name('stories.draft')->middleware('auth');
Route::get('/stories/public/{id}', [ArticleController::class, 'published'])->name('stories.published')->middleware('auth');

Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth', 'must-admin'])->name('dashboard_admin');


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
