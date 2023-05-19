<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileSetController extends Controller
{
    public function edit()
    {
        $user = auth()->user();

        return view('editprofile', compact('user'));
    }

    public function update(Request $request)
{
    $user = auth()->user();

    $request->validate([
        'name' => 'required|string|max:50',
        'bio' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1000',
    ]);

    $user->name = $request->name;
    $user->bio = $request->bio;

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('images/profile_photos', 'public');
        $user->image = $imagePath;
    }

    $user->save();

    return redirect(route('profile', Auth::user()->id))->with('success', 'Profil berhasil diperbarui.');
}

}
