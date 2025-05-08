<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\Websitemail;
use App\Models\Editor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminEditorController extends Controller
{
    public function index()
    {
        $editors = Editor::get();
        return view('admin.editor.index', compact('editors'));
    }

    public function create()
    {
        return view('admin.editor.create');
    }

    public function store(Request $request)
    {
        $editor = new Editor();

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:editors',
            'password' => 'required',
            'retype_password' => 'required|same:password'
        ]);

        if ($request->hasFile('photo')) {
            $request->validate([
                'photo' => 'image|mimes:jpg,jpeg,png,gif'
            ]);

            $now = time();
            $ext = $request->file('photo')->extension();
            $final_name = 'editor_photo_' . $now . '.' . $ext;
            $request->file('photo')->move(public_path('uploads/'), $final_name);
            $editor->photo = $final_name;
        }

        $editor->name = $request->name;
        $editor->email = $request->email;
        $editor->password = Hash::make($request->password);
        $editor->token = '';
        $editor->save();

        // Send email
        $subject = 'Your editor account has been created';
        $message = 'Hi, your editor account has been created successfully. Please log in from the editor login page: <br><br>';
        $message .= '<a href="' . route('editor.login') . '">Click here to login</a><br><br>';
        $message .= 'Your password is: <strong>' . $request->password . '</strong><br>Please change it after login.';

        \Mail::to($request->email)->send(new Websitemail($subject, $message));

        return redirect()->route('admin.editor.index')->with('success', 'Editor account is created successfully.');
    }

    public function edit($id)
    {
        $editor = Editor::findOrFail($id);
        return view('admin.editor.edit', compact('editor'));
    }

    public function update(Request $request, $id)
    {
        $editor = Editor::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('editors')->ignore($editor->id)
            ]
        ]);

        if ($request->password != '') {
            $request->validate([
                'password' => 'required',
                // 'retype_password' => 'required|same:password'
            ]);
            $editor->password = Hash::make($request->password);
        }

        if ($request->hasFile('photo')) {
            $request->validate([
                'photo' => 'image|mimes:jpg,jpeg,png,gif'
            ]);

            if ($editor->photo && file_exists(public_path('uploads/' . $editor->photo))) {
                unlink(public_path('uploads/' . $editor->photo));
            }

            $now = time();
            $ext = $request->file('photo')->extension();
            $final_name = 'editor_photo_' . $now . '.' . $ext;
            $request->file('photo')->move(public_path('uploads/'), $final_name);
            $editor->photo = $final_name;
        }

        $editor->name = $request->name;
        $editor->email = $request->email;
        $editor->update();

        return redirect()->route('admin.editor.index')->with('success', 'Editor updated successfully.');
    }

    public function delete($id)
    {
        $editor = Editor::findOrFail($id);

        if ($editor->photo && file_exists(public_path('uploads/' . $editor->photo))) {
            unlink(public_path('uploads/' . $editor->photo));
        }

        $editor->delete();

        return redirect()->route('admin.editor.index')->with('success', 'Editor deleted successfully.');
    }
}
