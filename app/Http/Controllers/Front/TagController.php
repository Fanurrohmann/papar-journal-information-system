<?php

namespace App\Http\Controllers\Front;

use App\Helper\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function show($tag_name)
    {
        Helpers::read_json();

        $all_data = Tag::where('tag_name', $tag_name)->get();
        $all_post_ids = [];
        foreach ($all_data as $row) {
            $all_post_ids[] = $row->post_id;
        }

        $all_posts = Post::where('status', 'acc')->orderBy('id', 'desc')->get();

        return view('front.tag', compact('all_post_ids', 'all_posts', 'tag_name'));
    }
}
