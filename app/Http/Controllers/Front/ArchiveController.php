<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Helper\Helpers;

class ArchiveController extends Controller
{
    public function show(Request $request)
    {
        Helpers::read_json();

        // Validasi input format MM-YYYY
        $request->validate([
            'archive_month_year' => ['required', 'regex:/^\d{2}-\d{4}$/']
        ]);

        $temp = explode('-', $request->archive_month_year);

        // Cek apakah hasil explode valid
        if (count($temp) !== 2) {
            return redirect()->back()->withErrors(['archive_month_year' => 'Invalid archive format.']);
        }

        $month = $temp[0];
        $year = $temp[1];

        return redirect()->route('archive_detail', [$year, $month]);
    }

    public function detail($year, $month)
    {
        Helpers::read_json();

        $post_data_archive = Post::with('rSubCategory')
            ->whereMonth('created_at', '=', $month)
            ->whereYear('created_at', '=', $year)->where('status', 'acc')
            ->paginate(12);

        $updated_date = null;

        if ($post_data_archive->count()) {
            $ts = strtotime($post_data_archive[0]->created_at);
            $updated_date = date('F, Y', $ts);
        } else {
            // Jika tidak ada data, tampilkan bulan/tahun dari URL
            $updated_date = date('F, Y', strtotime("$year-$month-01"));
        }

        return view('front.archive', compact('post_data_archive', 'updated_date'));
    }
}
