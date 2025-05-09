<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Editor;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\SubCategory;
use App\Models\Language;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class EditorPostController extends Controller
{
    public function dashboard()
    {
        // Get today's date
        $today = Carbon::today();
        $firstDayOfMonth = Carbon::today()->startOfMonth();

        // Count posts created today
        $today_posts_count = Post::whereDate('created_at', $today)->count();

        // Count posts created this month
        $month_posts_count = Post::whereDate('created_at', '>=', $firstDayOfMonth)
            ->whereDate('created_at', '<=', $today)
            ->count();

        // Count visitors today (assuming visitors are tracked in posts)
        $today_visitors = Post::whereDate('created_at', $today)->sum('visitors');

        // Count visitors this month
        $month_visitors = Post::whereDate('created_at', '>=', $firstDayOfMonth)
            ->whereDate('created_at', '<=', $today)
            ->sum('visitors');

        // Get reporter posts that need editor approval
        $reporter_posts = Post::with(['author', 'tags'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('editor.post_dashboard', compact(
            'today_posts_count',
            'month_posts_count',
            'today_visitors',
            'month_visitors',
            'reporter_posts'
        ));
    }

    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();
        return view('editor.post_index', compact('posts'));
    }

    public function create()
    {
        $global_language_data = Language::all();

        $sub_categories = SubCategory::with('rCategory')->get();
        $tags = Tag::get();
        $editors = Editor::all();
        $authors = Author::all();

        return view('editor.post_create', compact('sub_categories', 'global_language_data', 'tags', 'editors', 'authors'));
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
        $post->author_id = $request->author_id;
        $post->admin_id = 1; // super admin
        $post->editor_id = Auth::guard('editor')->user()->id;
        $post->is_share = $request->is_share ? 1 : 0;
        $post->is_comment = $request->is_comment ? 1 : 0;
        $post->is_featured = $request->is_featured ? 1 : 0;
        $post->language_id = $request->language_id ?? 1; // Default to 1 if not provided
        $post->meta_description = $request->meta_description;
        $post->status = $request->status;

        // Handle published_at date
        if ($request->published_at) {
            $post->published_at = Carbon::parse($request->published_at);
        } elseif ($request->status === 'published') {
            $post->published_at = Carbon::now();
        }

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

        return redirect()->route('admin_post_show')->with('success', 'Post was added successfully');
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
        $editors = Editor::all();
        $authors = Author::all();

        return view('editor.post_edit', compact('post', 'sub_categories', 'tags', 'editors', 'authors'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'post_title' => 'required',
            'content' => 'required',
        ]);

        $post = Post::where('id', $id)->first();

        if (!$post) {
            return redirect()->route('posts.index')->with('error', 'Post not found');
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
        $post->author_id = $request->author_id;
        $post->editor_id = $request->editor_id;
        $post->is_share = $request->is_share ? 1 : 0;
        $post->is_comment = $request->is_comment ? 1 : 0;
        $post->is_featured = $request->is_featured ? 1 : 0;
        $post->language_id = $request->language_id ?? 1; // Default to 1 if not provided
        $post->meta_description = $request->meta_description;
        $post->status = $request->status;

        // Handle published_at date
        if ($request->published_at) {
            $post->published_at = Carbon::parse($request->published_at);
        } elseif ($request->status === 'published' && !$post->published_at) {
            $post->published_at = Carbon::now();
        }

        $post->save();

        // Handle tags (sync will remove old associations and add new ones)
        if ($request->tags) {
            $post->tags()->sync($request->tags);
        } else {
            $post->tags()->detach();
        }

        return redirect()->route('posts.index')->with('success', 'Post was updated successfully');
    }

    public function approve($id)
    {
        $post = Post::findOrFail($id);
        $post->status = 'published';
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
