<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowingController extends Controller
{
    public function following($username)
    {
        $user = User::where('username', $username)->first();
        // dd($user->follows);

        if ($user) {
            return view('profile.following', [
                'following' => $user->follows,
                'user' => $user,
            ]);
        } else {
            abort(404);
        }
    }

    public function follower($username)
    {
        $user = User::where('username', $username)->first();
        // dd($user->follows);

        if ($user) {
            return view('profile.follower', [
                'followers' => $user->followers,
                'user' => $user,
            ]);
        } else {
            abort(404);
        }
    }

    public function store(Request $request, User $user)
    {

        if ($user) {
            Auth::user()->hasFollow($user) ? Auth::user()->unfollow($user) : Auth::user()->follow($user);

            return back();
        } else {
            abort(404);
        }
    }
}
