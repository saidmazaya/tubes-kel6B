<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileEditRequest;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            return view('profile', compact('user'));
        } else {
            abort(404);
        }
    }
}
