<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\SubCategory;
use App\Models\Language;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class EditorPostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();
        return view('editor.post_index', compact('posts'));
    }

    public function create()
    {
        $sub_categories = SubCategory::with('rCategory')->get();
        $global_language_data = Language::all();
        return view('editor.post_create', compact('sub_categories', 'global_language_data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'post_title' => 'required|string|max:255',
            'post_detail' => 'required|string',
            'post_photo' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'language_id' => 'required|exists:languages,id',
        ]);

        $photo = $request->file('post_photo');
        $photoName = time() . '.' . $photo->getClientOriginalExtension();
        $photo->move(public_path('uploads'), $photoName);

        $post = new Post();
        $post->post_title = $request->post_title;
        $post->post_detail = $request->post_detail;
        $post->post_photo = 'uploads/' . $photoName;
        $post->sub_category_id = $request->sub_category_id;
        $post->language_id = $request->language_id;
        $post->editor_id = Auth::guard('editor')->id();
        $post->status = $request->status ?? 'pending';
        $post->visitors = 0;
        $post->author_id = null;
        $post->admin_id = null;
        $post->is_share = $request->is_share ?? 0;
        $post->is_comment = $request->is_comment ?? 1;
        $post->save();

        // Simpan tags jika ada
        if (!empty($request->tags)) {
            $tags = array_map('trim', explode(',', $request->tags));

            // Menghapus semua tag yang sudah ada
            $post->tags()->detach();

            // Menambahkan tag baru
            foreach ($tags as $tagName) {
                $tag = Tag::firstOrCreate(['tag_name' => $tagName]);
                $post->tags()->attach($tag->id);
            }
        }

        return redirect()->route('posts.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $sub_categories = SubCategory::with('rCategory')->get();
        $global_language_data = Language::all();
        $existing_tags = $post->tags;  // Mendapatkan tags yang terhubung ke post

        return view('editor.post_edit', compact('post', 'sub_categories', 'existing_tags', 'global_language_data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'post_title' => 'required',
            'post_detail' => 'required'
        ]);

        $post = Post::findOrFail($id);

        if ($request->hasFile('post_photo')) {
            $request->validate([
                'post_photo' => 'image|mimes:jpg,jpeg,png,gif'
            ]);

            // 🧹 Hapus file lama jika ada
            if ($post->post_photo && file_exists(public_path('uploads/' . $post->post_photo))) {
                unlink(public_path('uploads/' . $post->post_photo));
            }

            $now = time();
            $ext = $request->file('post_photo')->extension();
            $final_name = 'post_photo_' . $now . '.' . $ext;
            $request->file('post_photo')->move(public_path('uploads'), $final_name);

            $post->post_photo = $final_name;
        }

        $post->sub_category_id = $request->sub_category_id;
        $post->post_title = $request->post_title;
        $post->post_detail = $request->post_detail;
        $post->is_share = $request->is_share;
        $post->is_comment = $request->is_comment;
        $post->language_id = $request->language_id;
        
        $post->save();

        // Menghapus semua tag lama dan menambahkan yang baru
        if (!empty($request->tags)) {
            $tags = array_map('trim', explode(',', $request->tags));
            $post->tags()->detach();  // Menghapus semua tag yang sudah ada
            foreach ($tags as $tagName) {
                $tag = Tag::firstOrCreate(['tag_name' => $tagName]);
                $post->tags()->attach($tag->id);
            }
        }

        $post->save();

        return redirect()->route('posts.index')->with('success', 'Data is updated successfully');
    }

    public function approve($id)
    {
        $post = Post::findOrFail($id);
        $post->status = 'acc';
        $post->editor_id = Auth::guard('editor')->id();
        $post->save();

        return redirect()->route('posts.index')->with('success', 'Berita telah disetujui dan dipublikasikan.');
    }

    public function cancel($id)
    {
        $post = Post::findOrFail($id);
        $post->status = 'pending';
        $post->save();

        return redirect()->route('posts.index')->with('success', 'Persetujuan dibatalkan.');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Berita berhasil dihapus.');
    }

    public function deleteTag($tagId, $postId)
    {
        $post = Post::findOrFail($postId);
        $post->tags()->detach($tagId);

        return redirect()->back()->with('success', 'Tag berhasil dihapus.');
    }
}
