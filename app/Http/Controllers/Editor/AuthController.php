<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Editor;
use Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('editor.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('editor')->attempt($credentials)) {
            return redirect()->intended(route('editor_home'));
        }

        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    public function logout()
    {
        Auth::guard('editor')->logout();
        return redirect()->route('editor.login');
    }
}

