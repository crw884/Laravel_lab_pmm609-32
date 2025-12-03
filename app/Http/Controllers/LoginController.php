<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function authenticate(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ],[
            'email.required' => 'Введите email.',
            'password.required' => 'Введите пароль.',
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/posts')->with('success', 'Вы вошли в аккаунт.');
        }

        return back()->with('error', 'Неверный логин или пароль.')->onlyInput('email', 'password');
    }

    public function login(Request $request)
    {
        return view('login',[
            'user' => Auth::user(),
        ]);
    }

    public function logout(Request $request) : RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/posts')->with('success', 'Вы вышли из аккаунта.');
    }
}
