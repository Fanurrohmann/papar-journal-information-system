<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Helper\Helpers;

class SubCategoryController extends Controller
{
    public function index($id)
    {
        Helpers::read_json();

        $sub_category_data = SubCategory::where('id', $id)->first();
        $post_data = Post::where('sub_category_id', $id)->where('status', 'acc')->orderBy('id', 'desc')->paginate(6);
        return view('front.sub_category', compact('sub_category_data', 'post_data'));
    }
}
