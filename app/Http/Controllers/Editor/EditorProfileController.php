<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Editor;

class EditorProfileController extends Controller
{
    public function edit()
    {
        $editor = Auth::guard('editor')->user();
        return view('editor.profile_edit', compact('editor'));
    }

    public function update(Request $request)
    {
        $editor = Auth::guard('editor')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:editors,email,' . $editor->id,
            'password' => 'nullable|min:6|confirmed',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $editor->name = $request->name;
        $editor->email = $request->email;

        if ($request->filled('password')) {
            $editor->password = Hash::make($request->password);
        }

        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($editor->photo && file_exists(public_path($editor->photo))) {
                unlink(public_path($editor->photo));
            }

            $ext = $request->file('photo')->getClientOriginalExtension();
            $fileName = 'editor_' . time() . '_' . Str::random(5) . '.' . $ext;
            $request->file('photo')->move(public_path('uploads'), $fileName);
            $editor->photo = 'uploads/' . $fileName;
        }

        $editor->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function logout()
    {
        Auth::guard('editor')->logout();
        return redirect()->route('editor.login')->with('success', 'Logout berhasil.');
    }
}
