@extends('front.layout.app')

@section('title', $post_detail->post_title . ' - ' . $post_detail->rSubCategory->sub_category_name . ' | ' . config('app.name'))

@section('meta_tags')
    {{-- Primary Meta Tags --}}
    {{-- <meta name="title" content="{{ $post_detail->post_title }}"> --}}
    <meta name="description" content="{{ $post_detail->meta_description ?? Str::limit(strip_tags($post_detail->content), 160) }}">
    <meta name="author" content="{{ $user_data->name }}">
    <meta name="keywords" content="{{ $post_detail->getTagNamesAttribute() }}">
    
    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $post_detail->post_title }}">
    <meta property="og:description" content="{{ $post_detail->meta_description ?? Str::limit(strip_tags($post_detail->content), 160) }}">
    <meta property="og:image" content="{{ asset('uploads/post_photos/'.$post_detail->post_photo) }}">
    <meta property="article:published_time" content="{{ $post_detail->published_at ?? $post_detail->created_at }}">
    <meta property="article:modified_time" content="{{ $post_detail->updated_at }}">
    <meta property="article:section" content="{{ $post_detail->rSubCategory->sub_category_name }}">
    <meta property="article:tag" content="{{ $post_detail->getTagNamesAttribute() }}">
    
    {{-- Twitter --}}
    {{-- <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $post_detail->post_title }}">
    <meta property="twitter:description" content="{{ $post_detail->meta_description ?? Str::limit(strip_tags($post_detail->content), 160) }}">
    <meta property="twitter:image" content="{{ asset('uploads/post_photos/'.$post_detail->post_photo) }}"> --}}
    
    {{-- Canonical URL --}}
    <link rel="canonical" href="{{ url()->current() }}">
@endsection

@section('schema_markup')
    <script type="application/ld+json">
    {!! $post_detail->getSchemaJson() !!}
    </script>
@endsection


@section('main_content')
<div class="page-top">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 style="font-size: 30px">{{ $post_detail->post_title }}</h1>
                <nav class="breadcrumb-container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ HOME }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('category',$post_detail->sub_category_id) }}">{{ $post_detail->rSubCategory->sub_category_name }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $post_detail->post_title }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="page-content">
    <div class="container">
        <div class="row">

            <div class="col-lg-8 col-md-6">
                <div class="featured-photo">
                    <img src="{{ asset('uploads/post_photos/'.$post_detail->post_photo) }}" alt="{{ $post_detail->photo_caption }}">
                    <div class="photo-caption">
                        {{ $post_detail->photo_caption }}
                    </div>
                </div>
                <div class="sub">
                    <div class="item">
                        <b><i class="fas fa-user"></i></b>
                        <a href="">{{ $user_data->name }}</a>
                    </div>
                    <div class="item">
                        <b><i class="fas fa-edit"></i></b>
                        <a href="{{ route('category',$post_detail->rSubCategory->slug) }}">{{ $post_detail->rSubCategory->sub_category_name }}</a>
                    </div>
                    <div class="item">
                        <b><i class="fas fa-clock"></i></b>
                        @php
                        $ts = strtotime($post_detail->updated_at);
                        $updated_date = date('d F, Y',$ts);
                        @endphp
                        {{ $updated_date }}
                    </div>
                </div>
                <div class="main-text">
                    {!! $post_detail->content !!}
                </div>
                <div class="tag-section">
                    <h2>{{ TAGS }}</h2>
                    <div class="tag-section-content">
                        @foreach($tag_data as $item)
                        <a href="{{ route('tag_post_show',$item->slug) }}"><span class="badge bg-success">{{ $item->tag_name }}</span></a>
                        @endforeach
                    </div>
                </div>
                
                @if($post_detail->is_share == 1)
                <div class="share-content">
                    <h2>{{ SHARE }}</h2>
                    <div class="addthis_inline_share_toolbox"></div>
                </div>
                @endif

                @if($post_detail->is_comment == 1)
                <div class="comment-fb">
                    <h2>{{ COMMENT }}</h2>
                    <div id="disqus_thread"></div>
                    {!! $global_setting_data->disqus_code !!}
                </div>
                @endif

                <div class="related-news">
                    <div class="related-news-heading">
                        <h2>{{ RELATED_NEWS }}</h2>
                    </div>
                    <div class="related-post-carousel owl-carousel owl-theme">
                        @foreach($related_post_array as $item)
                        @if($item->id == $post_detail->id)
                            @continue
                        @endif
                        <div class="item">
                            <div class="photo">
                                <img src="{{ asset('uploads/post_photos/'.$item->post_photo) }}" alt="">
                            </div>
                            <div class="category">
                                <span class="badge bg-success">{{ $item->rSubCategory->sub_category_name }}</span>
                            </div>
                            <h3><a href="{{ route('news_detail',$item->post_slug) }}">{{ $item->post_title }}</a></h3>
                            <div class="date-user">
                                <div class="user">
                                    @if($item->author_id==0)
                                        @php
                                        $user_data = \App\Models\Admin::where('id',$item->admin_id)->first();
                                        @endphp
                                    @else
                                        @php
                                        $user_data = \App\Models\Author::where('id',$item->author_id)->first();
                                        @endphp
                                    @endif
                                    <a href="javascript:void;">{{ $user_data->name }}</a>
                                </div>
                                <div class="date">
                                    @php
                                    $ts = strtotime($item->updated_at);
                                    $updated_date = date('d F, Y',$ts);
                                    @endphp
                                    <a href="javascript:void;">{{ $updated_date }}</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 sidebar-col">

            @include('front.layout.sidebar')

            </div>

        </div>
    </div>
</div>
@endsection