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
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


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
        $tags = Tag::get();

        return view('author.post_create', compact('sub_categories', 'tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'post_title' => 'required',
            'content' => 'required',
            'post_photo' => 'required|image|mimes:jpg,jpeg,png,gif'
        ]);

        // Handle file upload
        $now = time();
        $ext = $request->file('post_photo')->extension();
        $final_name = 'post_photo_' . $now . '.' . $ext;
        $request->file('post_photo')->move(public_path('uploads/post_photos/'), $final_name);

        // Create new post
        $post = new Post();
        $post->sub_category_id = $request->sub_category_id;
        $post->post_title = $request->post_title;
        $post->post_subtitle = $request->post_subtitle;
        $post->post_slug = $request->post_slug ?? Str::slug($request->post_title);
        $post->content = $request->content; // Changed from post_detail to content
        $post->post_photo = $final_name;
        $post->photo_caption = $request->photo_caption;
        $post->visitors = 0;
        $post->author_id = Auth::guard('author')->user()->id;
        $post->admin_id = 1; // super admin
        // $post->editor_id = ;
        $post->is_share = $request->is_share ? 1 : 0;
        $post->is_comment = $request->is_comment ? 1 : 0;
        $post->is_featured = $request->is_featured ? 1 : 0;
        $post->language_id = $request->language_id ?? 1; // Default to 1 if not provided
        // $post->meta_description = $request->meta_description;
        $post->status = 'pending';

        $post->save();

        // Handle tags
        if ($request->tags) {
            $post->tags()->attach($request->tags);
        }

        // Sending this post to subscribers
        // if ($request->subscriber_send_option == 1) {
        //     $subject = 'A new post is published';
        //     $message = 'Hi, A new post is published into our website. Please go to see that post:<br>';
        //     $message .= '<a target="_blank" href="' . route('post.detail', $post->post_slug) . '">';
        //     $message .= $request->post_title;
        //     $message .= '</a>';

        //     $subscribers = Subscriber::where('status', 'Active')->get();
        //     foreach ($subscribers as $row) {
        //         Mail::to($row->email)->send(new Websitemail($subject, $message));
        //     }
        // }

        return redirect()->route('author_post_show')->with('success', 'Post was added successfully');
    }

    public function edit($id)
    {
        $post = Post::with('tags')->where('id', $id)->first();
        // Check if post exists and belongs to current admin
        if (!$post || $post->admin_id != Auth::guard('admin')->user()->id) {
            return redirect()->route('admin_home');
        }

        $sub_categories = SubCategory::with('rCategory')->get();
        $tags = Tag::get();

        return view('author.post_edit', compact('post', 'sub_categories', 'tags'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'post_title' => 'required',
            'content' => 'required',
        ]);

        $post = Post::where('id', $id)->first();

        if (!$post) {
            return redirect()->route('author_post_show')->with('error', 'Post not found');
        }

        // Handle file upload if a new photo is provided
        if ($request->hasFile('post_photo')) {
            $request->validate([
                'post_photo' => 'image|mimes:jpg,jpeg,png,gif'
            ]);

            // Delete old photo if exists
            if ($post->post_photo && file_exists(public_path('uploads/post_photos/' . $post->post_photo))) {
                unlink(public_path('uploads/post_photos/' . $post->post_photo));
            }

            $now = time();
            $ext = $request->file('post_photo')->extension();
            $final_name = 'post_photo_' . $now . '.' . $ext;
            $request->file('post_photo')->move(public_path('uploads/post_photos/'), $final_name);

            $post->post_photo = $final_name;
        }

        // Update post details
        $post->sub_category_id = $request->sub_category_id;
        $post->post_title = $request->post_title;
        $post->post_subtitle = $request->post_subtitle;
        $post->post_slug = $request->post_slug ?? Str::slug($request->post_title);
        $post->content = $request->content;
        $post->photo_caption = $request->photo_caption;
        $post->author_id = Auth::guard('author')->user()->id;
        // $post->editor_id = $request->editor_id;
        $post->is_share = $request->is_share ? 1 : 0;
        $post->is_comment = $request->is_comment ? 1 : 0;
        $post->is_featured = $request->is_featured ? 1 : 0;
        $post->language_id = $request->language_id ?? 1; // Default to 1 if not provided
        // $post->meta_description = $request->meta_description ?? null;


        $post->save();

        // Handle tags (sync will remove old associations and add new ones)
        if ($request->tags) {
            $post->tags()->sync($request->tags);
        } else {
            $post->tags()->detach();
        }

        return redirect()->route('author_post_show')->with('success', 'Post was updated successfully');
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

        // if ($post->post_photo && file_exists(public_path('uploads/post_photos' . $post->post_photo))) {
        //     unlink(public_path('uploads/' . $post->post_photo));
        // }

        // $post->tags()->detach();
        $post->delete();

        return redirect()->route('author_post_show')->with('success', 'Post deleted successfully');
    }
}
