<?php

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\TagAdminController;
use App\Http\Controllers\FollowingController;
use App\Http\Controllers\UserAdminController;
use App\Http\Controllers\ProfileSetController;
use App\Http\Controllers\ClapArticleController;
use App\Http\Controllers\ArticleAdminController;
use App\Http\Controllers\CommentArticleController;
use App\Http\Controllers\ArticleAdminEditController;
use App\Http\Controllers\ArticleIndexController;
use App\Http\Controllers\CommentListAdminController;
use App\Http\Controllers\ClapCommentArticleController;
use App\Http\Controllers\CommentArticleAdminController;
use App\Http\Controllers\TagController;

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

Route::get('/', [ArticleIndexController::class, 'tampilanAwal'])->name('index')->middleware('guest');


// Route::post('/menuutama', [AuthController::class, 'authentication'])->name('menuutama');
// Route::post('/menuutama', [AuthController::class, 'signup'])->name('menuutama');

Route::get('/signin', [AuthController::class, 'signin'])->name('signin')->middleware('guest');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup');
Route::post('/signin', [AuthController::class, 'authentication'])->middleware('guest');
Route::get('/signout', [AuthController::class, 'signout'])->middleware('auth');

Route::get('/signup', function () {
    return view('signup');
})->middleware('guest');

Route::get('/change-password', [AuthController::class, 'changePassword'])->middleware('auth')->name('profile.change');
Route::post('/change-password/{id}', [AuthController::class, 'processChangePassword'])->middleware('auth')->name('profile.change-password');



Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function (string $token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed|max:16',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('signin')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');



Route::get('/ourstory', function () {
    return view('ourstory');
});

Route::get('/write', function () {
    return view('write');
});

Route::get('/menuutama', [ArticleController::class, 'index'])->name('menuutama');

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

Route::get('/tag/{slug}', [TagController::class, 'show'])->name('tag.detail');
Route::get('/explore-tags', [TagController::class, 'explore'])->name('tag.explore');

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
