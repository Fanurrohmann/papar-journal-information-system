<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\Websitemail;
use App\Models\Post;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Subscriber;
use App\Models\Tag;
use Auth;
use Illuminate\Support\Facades\DB;

class AuthorPostController extends Controller
{
    public function show()
    {
        $posts = Post::with('rSubCategory.rCategory', 'rLanguage')
            ->where('author_id', Auth::guard('author')->user()->id)
            ->get();

        return view('author.post_show', compact('posts'));
    }

    public function create()
    {
        $sub_categories = SubCategory::with('rCategory')->get();
        return view('author.post_create', compact('sub_categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'post_title' => 'required',
            'post_detail' => 'required',
            'post_photo' => 'required|image|mimes:jpg,jpeg,png,gif'
        ]);

        $q = DB::select("SHOW TABLE STATUS LIKE 'posts'");
        $ai_id = $q[0]->Auto_increment;

        $now = time();
        $ext = $request->file('post_photo')->extension();
        $final_name = 'post_photo_' . $now . '.' . $ext;
        $request->file('post_photo')->move(public_path('uploads'), $final_name);

        $post = new Post();
        $post->sub_category_id = $request->sub_category_id;
        $post->post_title = $request->post_title;
        $post->post_detail = $request->post_detail;
        $post->post_photo = $final_name;
        $post->visitors = 1;
        $post->author_id = Auth::guard('author')->user()->id;
        $post->status = 'pending';
        $post->admin_id = 0;
        $post->is_share = $request->is_share;
        $post->is_comment = $request->is_comment;
        $post->language_id = $request->language_id;
        $post->save();

        if ($request->tags != '') {
            $tags_array_new = array_unique(array_map('trim', explode(',', $request->tags)));
            $tag_ids = [];

            foreach ($tags_array_new as $tag_name) {
                $tag = Tag::firstOrCreate(['tag_name' => $tag_name]);
                $tag_ids[] = $tag->id;
            }

            $post->tags()->sync($tag_ids);
        }

        if ($request->subscriber_send_option == 1) {
            $subject = 'A new post is published';
            $message = 'Hi, A new post is published on our website. Please go to see that post:<br>';
            $message .= '<a target="_blank" href="' . route('news_detail', $ai_id) . '">';
            $message .= $request->post_title;
            $message .= '</a>';

            $subscribers = Subscriber::where('status', 'Active')->get();
            foreach ($subscribers as $row) {
                \Mail::to($row->email)->send(new Websitemail($subject, $message));
            }
        }

        return redirect()->route('author_post_show')->with('success', 'Data is added successfully');
    }

    public function edit($id)
    {
        $test = Post::where('id', $id)
            ->where('author_id', Auth::guard('author')->user()->id)
            ->exists();

        if (!$test) {
            return redirect()->route('author_home');
        }

        $sub_categories = SubCategory::with('rCategory')->get();
        $post_single = Post::with('tags')->findOrFail($id);
        $existing_tags = $post_single->tags;

        return view('author.post_edit', compact('post_single', 'sub_categories', 'existing_tags'));
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

        // Update tags using pivot
        if ($request->tags != '') {
            $tags_array = array_unique(array_map('trim', explode(',', $request->tags)));
            $tag_ids = [];

            foreach ($tags_array as $tag_name) {
                $tag = Tag::firstOrCreate(['tag_name' => $tag_name]);
                $tag_ids[] = $tag->id;
            }

            $post->tags()->sync($tag_ids);
        } else {
            $post->tags()->detach();
        }

        return redirect()->route('author_post_show')->with('success', 'Data is updated successfully');
    }

    public function delete_tag($id, $post_id)
    {
        $post = Post::findOrFail($post_id);
        $post->tags()->detach($id);
        return redirect()->route('author_post_edit', $post_id)->with('success', 'Tag deleted successfully');
    }

    public function delete($id)
    {
        $test = Post::where('id', $id)
            ->where('author_id', Auth::guard('author')->user()->id)
            ->exists();

        if (!$test) {
            return redirect()->route('author_home');
        }

        $post = Post::findOrFail($id);

        if ($post->post_photo && file_exists(public_path('uploads/' . $post->post_photo))) {
            unlink(public_path('uploads/' . $post->post_photo));
        }

        $post->tags()->detach();
        $post->delete();

        return redirect()->route('author_post_show')->with('success', 'Post deleted successfully');
    }
}
