<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\AuthSignUpRequest;

class AuthController extends Controller
{
    public function signin(){
        return view('signin');
    }


    public function signup(AuthSignUpRequest $request)
{
    $user = User::where('email', $request->email)->first();

    // if ($user) {
    //     return redirect()->back()->withInput()->withErrors(['email' => 'Email has already been taken']);
    // }

    // $this->validate($request, [
    //     'password' => 'required|min:8|max:16',
    //     'email' => 'required|unique'
    // ], [
    //     'password.required' => 'Password is required',
    //     'password.min' => 'Password must be at least 8 characters',
    //     'password.max' => 'Password can not exceed 16 characters',
    //     'email.required' => 'Password is required',
    //     'email.unique' => 'Email must be unique'
    // ]);

    $newUser = new User;
    $newUser->name = $request->name;
    $newUser->email = $request->email;
    $name = str_replace(' ', '', $request->name);
    $newUser->username = '@'.strtolower($name).mt_rand(10000,99999);
    $newUser->password = bcrypt($request->password);
    $newUser->role_id = "2";
    $newUser->save();

    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        $request->session()->regenerate();

        $redirect = $request->redirect ? $request->redirect : route('menuutama');
        return redirect()->intended($redirect);
    } else { 
        return redirect()->route('signup')->with('message', 'Email atau Password tidak valid');
    }
}


public function authentication(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        $redirect = $request->redirect ? $request->redirect : route('menuutama');
        return redirect()->intended($redirect);
    } else {
        return redirect('/signin')->with('message', ['type' => 'danger', 'content' => 'Login Gagal !']);
    } 
    
}

public function signout(Request $request){
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
}


}


