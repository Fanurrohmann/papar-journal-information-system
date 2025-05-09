@if (!session()->get('session_short_name'))
    @php
        $current_short_name = $global_short_name;
    @endphp
@else
    @php
        $current_short_name = session()->get('session_short_name');
    @endphp
@endif
@php
    $current_language_id = \App\Models\Language::where('short_name', $current_short_name)->first()->id;
@endphp

<div class="sidebar">

    {{-- SIDEBAR ATAS --}}
    <div class="widget">
        <div class="ad-sidebar" id="sidebar-ad-top">
            @foreach ($global_sidebar_top_ad as $index => $row)
                <div class="sidebar-ad-item top" style="{{ $index === 0 ? '' : 'display:none;' }}">
                    @if ($row->sidebar_ad_url == '')
                        <img src="{{ asset('uploads/' . $row->sidebar_ad) }}" alt="Iklan Sidebar">
                    @else
                        <a href="{{ $row->sidebar_ad_url }}" target="_blank">
                            <img src="{{ asset('uploads/' . $row->sidebar_ad) }}" alt="Iklan Sidebar">
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
    </div>


    <div class="widget">
        <div class="tag-heading">
            <h2>{{ TAGS }}</h2>
        </div>
        <div class="tag">
            @php
                $tags = \App\Models\Tag::whereHas('posts', function ($query) use ($current_language_id) {
                    $query->where('language_id', $current_language_id)
                          ->where('status', 'published');
                })->get();
            @endphp
    
            <div class="tag-list">
                @foreach ($tags as $index => $tag)
                    <div class="tag-item" style="{{ $index >= 5 ? 'display: none;' : '' }}" data-tag-item>
                        <a href="{{ route('tag_post_show', $tag->slug) }}">
                            <span class="badge bg-secondary">{{ $tag->tag_name }}</span>
                        </a>
                    </div>
                @endforeach
            </div>
    
            @if ($tags->count() > 5)
                <div class="mt-3" style="clear: both;">
                    <button
                        class="btn btn-sm w-100 text-secondary border border-secondary bg-white"
                        id="toggleTagButton"
                        onclick="toggleTagDisplay()"
                        onmouseover="this.classList.replace('text-secondary', 'text-primary')"
                        onmouseout="this.classList.replace('text-primary', 'text-secondary')"
                    >
                        Lihat Semua Tag
                    </button>
                </div>
            @endif
        </div>
    </div>


    <div class="widget">
        <div class="archive-heading">
            <h2>{{ ARCHIVE }}</h2>
        </div>
        <div class="archive">
            @php
                $archive_array = [];
                $all_post_data = \App\Models\Post::orderBy('id', 'desc')->get();
                foreach ($all_post_data as $row) {
                    $ts = strtotime($row->created_at);
                    $month = date('m', $ts);
                    $month_full = date('F', $ts);
                    $year = date('Y', $ts);
                    $archive_array[] = $month . '-' . $month_full . '-' . $year;
                }
                $archive_array = array_values(array_unique($archive_array));
            @endphp
            <form action="{{ route('archive_show') }}" method="post">
                @csrf
                <select name="archive_month_year" class="form-select" onChange="this.form.submit()">
                    <option value="">{{ SELECT_MONTH }}</option>
                    @for ($i = 0; $i < count($archive_array); $i++)
                        @php
                            $temp_arr = explode('-', $archive_array[$i]);
                        @endphp
                        <option value="{{ $temp_arr[0] . '-' . $temp_arr[2] }}">{{ $temp_arr[1] }},
                            {{ $temp_arr[2] }}
                        </option>
                    @endfor
                </select>
            </form>
        </div>
    </div>

    <div class="widget">
        @php
            $live_channel_data = \App\Models\LiveChannel::where('language_id', $current_language_id)->get();
        @endphp
        @foreach ($live_channel_data as $item)
            <div class="live-channel">
                <div class="live-channel-heading">
                    <h2>{{ $item->heading }}</h2>
                </div>
                <div class="live-channel-item">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $item->video_id }}"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                </div>
            </div>
        @endforeach

    </div>

    <div class="widget">
        <div class="news">
            <div class="news-heading">
                <h2>{{ POPULAR_RECENT_NEWS }}</h2>
            </div>
    
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                        aria-selected="true">{{ RECENT_NEWS }}</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                        aria-selected="false">{{ POPULAR_NEWS }}</button>
                </li>
            </ul>
    
            <div class="tab-content" id="pills-tabContent">
                {{-- RECENT NEWS --}}
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    @php
                        $recent_news_data = \App\Models\Post::with('rSubCategory')
                            ->where('language_id', $current_language_id)
                            ->orderBy('id', 'desc')
                            ->where('status', 'published')
                            ->get();
                    @endphp
    
                    @foreach ($recent_news_data as $index => $item)
                        <div class="news-item d-flex recent-item {{ $index >= 3 ? 'd-none' : '' }}">
                            <div class="left">
                                <img src="{{ asset('uploads/post_photos/' . $item->post_photo) }}" alt="{{ $item->post_photo }}">
                            </div>
                            <div class="right">
                                <div class="category">
                                    <span class="badge bg-success">
                                        {{ optional($item->rSubCategory)->sub_category_name ?? 'Uncategorized' }}
                                    </span>
                                </div>
                                <h2><a href="{{ route('news_detail', $item->post_slug) }}">{{ $item->post_title }}</a></h2>
                                <div class="date-user">
                                    <div class="user">
                                        @php
                                            $user_data = $item->author_id == 0
                                                ? \App\Models\Admin::find($item->admin_id)
                                                : \App\Models\Author::find($item->author_id);
                                        @endphp
                                        <a href="javascript:void(0);">{{ optional($user_data)->name ?? 'User tidak ditemukan' }}</a>
                                    </div>
                                    <div class="date">
                                        <a href="javascript:void(0);">{{ \Carbon\Carbon::parse($item->updated_at)->translatedFormat('d F, Y') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
    
                    @if ($recent_news_data->count() > 3)
                        <div class="mt-2 text-center">
                            <button class="btn btn-sm w-100 text-secondary border border-secondary bg-white"
                                id="toggleRecentBtn"
                                onclick="toggleNews('recent')"
                                onmouseover="this.classList.replace('text-secondary', 'text-primary')"
                                onmouseout="this.classList.replace('text-primary', 'text-secondary')">
                                Lihat Semua Berita
                            </button>
                        </div>
                    @endif
                </div>
    
                {{-- POPULAR NEWS --}}
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    @php
                        $popular_news_data = \App\Models\Post::with('rSubCategory')
                            ->where('language_id', $current_language_id)
                            ->where('status', 'published')
                            ->orderBy('visitors', 'desc')
                            ->get();
                    @endphp
    
                    @foreach ($popular_news_data as $index => $item)
                        <div class="news-item d-flex popular-item {{ $index >= 3 ? 'd-none' : '' }}">
                            <div class="left">
                                <img src="{{ asset('uploads/post_photos/' . $item->post_photo) }}" alt="{{ $item->post_photo }}">
                            </div>
                            <div class="right">
                                <div class="category">
                                    <span class="badge bg-success">
                                        {{ optional($item->rSubCategory)->sub_category_name ?? 'Uncategorized' }}
                                    </span>
                                </div>
                                <h2><a href="{{ route('news_detail', $item->post_slug) }}">{{ $item->post_title }}</a></h2>
                                <div class="date-user">
                                    <div class="user">
                                        @php
                                            $user_data = $item->author_id == 0
                                                ? \App\Models\Admin::find($item->admin_id)
                                                : \App\Models\Author::find($item->author_id);
                                        @endphp
                                        <a href="javascript:void(0);">{{ optional($user_data)->name ?? 'User tidak ditemukan' }}</a>
                                    </div>
                                    <div class="date">
                                        <a href="javascript:void(0);">{{ \Carbon\Carbon::parse($item->updated_at)->translatedFormat('d F, Y') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
    
                    @if ($popular_news_data->count() > 3)
                        <div class="mt-2 text-center">
                            <button class="btn btn-sm w-100 text-secondary border border-secondary bg-white"
                                id="togglePopularBtn"
                                onclick="toggleNews('popular')"
                                onmouseover="this.classList.replace('text-secondary', 'text-primary')"
                                onmouseout="this.classList.replace('text-primary', 'text-secondary')">
                                Lihat Semua Berita
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div



    <div class="widget">
        <div class="poll-heading">
            <h2>{{ ONLINE_POLL }}</h2>
        </div>
        <div class="poll">
            @php
                $online_poll_data = \App\Models\OnlinePoll::orderBy('id', 'desc')
                    ->where('language_id', $current_language_id)
                    ->first();
            @endphp

            @if ($online_poll_data)
                <div class="question">
                    {{ $online_poll_data->question }}
                </div>

                @php
                    $total_vote = $online_poll_data->yes_vote + $online_poll_data->no_vote;
                    $total_yes_percentage =
                        $total_vote > 0 ? ceil(($online_poll_data->yes_vote * 100) / $total_vote) : 0;
                    $total_no_percentage = $total_vote > 0 ? ceil(($online_poll_data->no_vote * 100) / $total_vote) : 0;
                @endphp

                @if (session()->get('current_poll_id') == $online_poll_data->id)
                    <div class="poll-result">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <td style="width: 100px;">{{ YES }} ({{ $online_poll_data->yes_vote }})
                                    </td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar bg-success" role="progressbar"
                                                style="width: {{ $total_yes_percentage }}%"
                                                aria-valuenow="{{ $total_yes_percentage }}" aria-valuemin="0"
                                                aria-valuemax="100">
                                                {{ $total_yes_percentage }}%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ NO }} ({{ $online_poll_data->no_vote }})</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar bg-danger" role="progressbar"
                                                style="width: {{ $total_no_percentage }}%"
                                                aria-valuenow="{{ $total_no_percentage }}" aria-valuemin="0"
                                                aria-valuemax="100">
                                                {{ $total_no_percentage }}%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <a href="{{ route('poll_previous') }}" class="btn btn-primary old"
                            style="margin-top: 0;">{{ OLD_RESULTS }}</a>
                    </div>
                @else
                    <div class="answer-option">
                        <form action="{{ route('poll_submit') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $online_poll_data->id }}">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="vote" id="poll_id_1"
                                    value="Yes" checked>
                                <label class="form-check-label" for="poll_id_1">{{ YES }}</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="vote" id="poll_id_2"
                                    value="No">
                                <label class="form-check-label" for="poll_id_2">{{ NO }}</label>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">{{ SUBMIT }}</button>
                                <a href="{{ route('poll_previous') }}"
                                    class="btn btn-primary old">{{ OLD_RESULTS }}</a>
                            </div>
                        </form>
                    </div>
                @endif
            @else
                <div class="question">
                    <p>{{ __('Tidak ada polling tersedia.') }}</p>
                </div>
            @endif
        </div>
    </div>


    {{-- SIDEBAR BAWAH --}}
    <div class="widget">
        <div class="ad-sidebar" id="sidebar-ad-bottom">
            @foreach ($global_sidebar_bottom_ad as $index => $row)
                <div class="sidebar-ad-item bottom" style="{{ $index === 0 ? '' : 'display:none;' }}">
                    @if ($row->sidebar_ad_url == '')
                        <img src="{{ asset('uploads/' . $row->sidebar_ad) }}" alt="Advertisement">
                    @else
                        <a href="{{ $row->sidebar_ad_url }}" target="_blank">
                            <img src="{{ asset('uploads/' . $row->sidebar_ad) }}" alt="Advertisement">
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

</div>

{{-- SCRIPT ADV  --}}

<script>
    function rotateAds(selector, interval = 5000) {
        const ads = document.querySelectorAll(selector);
        if (ads.length <= 1) return;

        let current = 0;
        setInterval(() => {
            ads[current].style.display = 'none';
            current = (current + 1) % ads.length;
            ads[current].style.display = 'block';
        }, interval);
    }

    // Panggil fungsi untuk iklan top dan bottom
    rotateAds('.sidebar-ad-item.top', 5000);     // sama dengan detik (5 detik)
    rotateAds('.sidebar-ad-item.bottom', 5000);  
</script>

{{-- SCRIPT TAGS --}}
<script>
    let tagsExpanded = false;

    function toggleTagDisplay() {
        const tagItems = document.querySelectorAll('[data-tag-item]');
        const toggleButton = document.getElementById('toggleTagButton');

        tagItems.forEach((tag, index) => {
            if (index >= 5) {
                tag.style.display = tagsExpanded ? 'none' : 'block';
            }
        });

        toggleButton.textContent = tagsExpanded ? 'Lihat Semua Tag' : 'Sembunyikan Tag';
        tagsExpanded = !tagsExpanded;
    }
</script>

{{-- SCRIPT Berita Populer & Terbaru --}}
<script>
    const toggleNews = (type) => {
        const items = document.querySelectorAll(`.${type}-item`);
        const button = document.getElementById(`toggle${type.charAt(0).toUpperCase() + type.slice(1)}Btn`);
        let expanded = button.dataset.expanded === "true";
    
        items.forEach((el, idx) => {
            if (idx >= 3) { // Hanya berlaku untuk item ke-4 dan seterusnya
                if (expanded) {
                    el.classList.add("d-none");
                } else {
                    el.classList.remove("d-none");
                }
            }
        });
    
        button.textContent = expanded ? "Lihat Semua Berita" : "Sembunyikan Berita";
        button.dataset.expanded = expanded ? "false" : "true";
    };

    const syncToggleButton = (type) => {
        const items = document.querySelectorAll(`.${type}-item`);
        const button = document.getElementById(`toggle${type.charAt(0).toUpperCase() + type.slice(1)}Btn`);

        let isExpanded = false;
        items.forEach((el, idx) => {
            if (idx >= 3 && !el.classList.contains('d-none')) {
                isExpanded = true;
            }
        });

        button.textContent = isExpanded ? "Sembunyikan Berita" : "Lihat Semua Berita";
        button.dataset.expanded = isExpanded ? "true" : "false";
    };

    window.addEventListener('DOMContentLoaded', () => {
        syncToggleButton('recent');
        syncToggleButton('popular');
    });
</script>

