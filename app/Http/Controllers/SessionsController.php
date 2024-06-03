<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    public function create()
    {
        return view('session.login-session');
    }

    public function store()
    {
        $attributes = request()->validate([
            'email' => 'required|email',
            'password' => 'required',
            'captcha' => 'required|captcha'
        ]);

        if (Auth::attempt(['email' => $attributes['email'], 'password' => $attributes['password']])) {
            request()->session()->regenerate();
            return redirect()->intended('dashboard')->with('success', 'Berhasil Login.');
        }

        return back()->withErrors([
            'email' => 'Email atau password Password.',
        ]);
    }

    public function destroy()
    {
        Auth::logout();

        return redirect('/login')->with('success', 'Berhasil Logout');
    }

    public function reloadCaptcha()
    {
        return response()->json(['captcha' => captcha_img('math')]);
    }
}
