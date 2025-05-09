<?php

namespace App\Http\Controllers\Front;

use App\Helper\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function show($slug)
    {
        Helpers::read_json();
        $tag = Tag::with('posts')->where('slug', $slug)->first();
        if (!$tag) {
            // Handle case where tag doesn't exist
            return redirect()->back()->with('error', 'Tag not found');
        }
        $tag_name = $tag->tag_name;
        $all_post_ids = $tag->posts->pluck('id')->toArray();
        $all_posts = Post::where('status', 'published')->orderBy('id', 'desc')->get();
        return view('front.tag', compact('all_post_ids', 'all_posts', 'tag_name'));
    }

    /**
     * Store a newly created tag.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'tag_name' => 'required|string|max:255|unique:tags,tag_name',
        ]);

        // Create new tag
        $tag = Tag::create([
            'tag_name' => $request->tag_name,
            // slug will be auto-generated in the model's boot method
        ]);

        // Return JSON response for AJAX
        return response()->json([
            'success' => true,
            'message' => 'Tag created successfully',
            'tag' => [
                'id' => $tag->id,
                'tag_name' => $tag->tag_name
            ]
        ]);
    }

    /**
     * Remove the specified tag.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);

        // Detach the tag from all posts
        $tag->posts()->detach();

        // Delete the tag
        $tag->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tag deleted successfully'
        ]);
    }
}
