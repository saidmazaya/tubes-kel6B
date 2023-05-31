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
    }

    public function update(ProfileEditRequest $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->id !== auth()->user()->id) {
            abort(403, 'Unauthorized');
        }
        // $request->validate([
        //     'name' => 'required|string|max:50',
        //     'bio' => 'nullable|string',
        //     'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1000',
        // ]);

        // dd($request->all());
        // if ($request->hasFile('image')) {
        //     $imagePath = $request->file('image')->store('images/profile_photos', 'public');
        //     $user->image = $imagePath;
        // }

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

        if ($request->photo == '') {
            $oldPhotoPath = $user->image; // Path foto lama yang disimpan dalam database

            if ($oldPhotoPath != '') {
                // Hapus foto lama dari sistem file menggunakan Storage::delete()
                Storage::disk('public')->delete('photo/' . $oldPhotoPath);
            }
        }

        $user->update($request->all());

        return redirect(route('profile', $request->username))->with('message', 'Profil berhasil diperbarui.');
    }

    public function show($username)
    {
        $user = User::where('username', $username)->first();

        if ($user) {
            $article = Article::where('author_id', $user->id)
                ->where('status', 'Published')
                ->get();

        // Mengambil semua data article_list yang dimiliki oleh user
        $userList = ArticleList::where('user_id', $user->id)->get();

            return view('profile', compact('user', 'article', 'userList'));
        } else {
            abort(404);
        }
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
}
