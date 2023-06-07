<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Models\ArticleList;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfileEditRequest;

class ProfileSetController extends Controller
{
    public function edit($username)
    {
        $user = User::where('username', $username)->first();

        if ($user->id !== auth()->user()->id) {
            abort(403, 'Unauthorized');
        }
        $users = auth()->user();

        return view('editprofile', compact('users'));

        // SELECT *
        // FROM users
        // WHERE username = '<username>' AND id = <user_id>;
    }

    public function update(ProfileEditRequest $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->id !== auth()->user()->id) {
            abort(403, 'Unauthorized');
        }

        if ($request->hasFile('photo')) {
            $oldPhotoPath = $user->image; // Path foto lama yang disimpan dalam database

            if ($oldPhotoPath != '') {
                // Hapus foto lama dari sistem file menggunakan Storage::delete()
                Storage::disk('public')->delete('photo/' . $oldPhotoPath);
            }

            // Simpan Foto Baru
            $extension = $request->file('photo')->getClientOriginalExtension();
            $today = now()->format('dmY_His');
            $newName = Auth::user()->username . '-' . 'profile-image' . '-' . $today . '-' . now()->timestamp . '-' . Str::random(10) . '.' . $extension;
            $request->file('photo')->storeAs('photo', $newName);

            $request['image'] = $newName;
        }

        $user->update($request->all());

        return redirect(route('profile', $request->username))->with('message', 'Profil berhasil diperbarui.');

        // UPDATE users
        // SET name = '<name>', bio = '<bio>', image = '<image>', username = '<username>', email = '<email>'
        // WHERE id = <id>;
    }

    public function deleteProfile($id)
    {
        $user = User::findOrFail($id);

        if ($user->id !== auth()->user()->id) {
            abort(403, 'Unauthorized');
        }

        // Hapus foto lama jika ada
        if ($user->image != '') {
            Storage::disk('public')->delete('photo/' . $user->image);
        }

        $user->image = NULL;

        $user->save();

        return redirect(route('profile', Auth::user()->username))->with('message', 'Profil berhasil diperbarui.');

        // UPDATE users
        // SET image = NULL
        // WHERE id = <id>;
    }

    public function show($username)
    {
        $user = User::where('username', $username)->first();

        if ($user) {
            $article = Article::where('author_id', $user->id)
                ->where('status', 'Published')
                ->get();

            // Mengambil semua data article_list yang dimiliki oleh user
            if ($user->id == Auth::user()->id) {
                $userList = ArticleList::where('user_id', $user->id)
                    ->where('owner_id', $user->id)
                    ->get();
            } else {
                $userList = ArticleList::where('user_id', $user->id)
                    ->where('owner_id', $user->id)
                    ->where('visibility', 'Public')
                    ->get();
            }

            return view('profile', compact('user', 'article', 'userList'));
        } else {
            abort(404);
        }

        // -- Mengambil data pengguna berdasarkan username
        // SELECT * FROM users WHERE username = <username>;

        // -- Mengambil artikel yang dimiliki oleh pengguna dengan status 'Published'
        // SELECT * FROM articles WHERE author_id = <user_id> AND status = 'Published';

        // -- Mengambil daftar artikel yang dimiliki oleh pengguna dengan user_id dan owner_id yang sama
        // SELECT * FROM article_lists WHERE user_id = <user_id> AND owner_id = <user_id>;

        // -- Mengambil daftar artikel yang dimiliki oleh pengguna dengan user_id dan owner_id yang sama,
        // -- dan memiliki visibility 'Public' jika user_id tidak sama dengan Auth::user()->id
        // SELECT * FROM article_lists WHERE user_id = <user_id> AND owner_id = <user_id> AND visibility = 'Public';
    }

    public function updateAbout(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->id !== auth()->user()->id) {
            abort(403, 'Unauthorized');
        }

        $user->about = $request->about;
        $user->save();

        return redirect(route('profile', Auth::user()->username))->with('message', 'About berhasil diperbarui.');
    }

    // UPDATE users SET about = <new_about> WHERE id = <user_id>;
}
