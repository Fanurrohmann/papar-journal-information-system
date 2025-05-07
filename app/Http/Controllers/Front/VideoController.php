<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Helper\Helpers;
use App\Models\Language;

class VideoController extends Controller
{
    public function index()
    {
        Helpers::read_json();

        if(!session()->get('session_short_name')) {
            $current_short_name = Language::where('is_default','Yes')->first()->short_name;
        } else {
            $current_short_name = session()->get('session_short_name');
        }
        $current_language_id = Language::where('short_name',$current_short_name)->first()->id;

        $videos = Video::where('language_id',$current_language_id)->paginate(8);
        return view('front.video_gallery', compact('videos'));
    }
}
