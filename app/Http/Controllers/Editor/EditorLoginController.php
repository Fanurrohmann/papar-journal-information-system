<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EditorLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('editor.login'); // buat file login.blade.php di folder /resources/views/editor
    }

    public function login_submit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('editor')->attempt($credentials)) {
            return redirect()->route('editor.posts.index'); // sesuaikan dengan route editor
        }

        return redirect()->back()->withErrors(['email' => 'Email atau password salah']);
    }

    public function logout()
    {
        Auth::guard('editor')->logout();
        return redirect()->route('editor.login');
    }
}
