<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $session_data = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        Auth::attempt($session_data);

        if(Auth::check()){
            return redirect()->to('')->with('success', 'Login berhasil.');
        } else {
            return redirect()->route('login')->with('failed', 'Email atau Password yang Anda masukkan salah.');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
