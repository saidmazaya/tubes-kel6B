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

        // SELECT u.*
        // FROM users u
        // JOIN mutuals m ON u.id = m.following_user_id
        // WHERE m.user_id = <user_id>;
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

        // SELECT u.*
        // FROM users u
        // JOIN mutuals m ON u.id = m.user_id
        // WHERE m.following_user_id = <user_id>;
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

    // Follow 
    // INSERT INTO mutuals (user_id, following_user_id)
    // VALUES (<user_id>, <following_user_id>);

    // Unfollow
    // DELETE FROM mutuals
    // WHERE user_id = <user_id> AND following_user_id = <following_user_id>;

}
