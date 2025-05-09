@extends('front.layout.app')

@section('title', $post_detail->post_title . ' - ' . $post_detail->rSubCategory->sub_category_name . ' | ' . config('app.name'))

@section('meta_tags')
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
    
    {{-- Canonical URL --}}
    <link rel="canonical" href="{{ url()->current() }}">
@endsection

@section('schema_markup')
    <script type="application/ld+json">
    {!! $post_detail->getSchemaJson() !!}
    </script>
@endsection


@section('main_content')
<style>
    /* Add these styles to your CSS file */
.social-share-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin: 15px 0;
}

.share-btn {
    display: inline-flex;
    align-items: center;
    padding: 8px 15px;
    border-radius: 4px;
    color: #fff;
    text-decoration: none;
    font-size: 14px;
    transition: all 0.3s ease;
}

.share-btn i {
    margin-right: 8px;
}

.share-btn:hover {
    opacity: 0.9;
    transform: translateY(-2px);
}

.facebook {
    background-color: #3b5998;
}

.twitter {
    background-color: #1da1f2;
}

.whatsapp {
    background-color: #25d366;
}

.telegram {
    background-color: #0088cc;
}

.linkedin {
    background-color: #0077b5;
}

.email {
    background-color: #7d7d7d;
}

.copy-link {
    background-color: #333333;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .social-share-buttons {
        justify-content: center;
    }
    
    .share-btn {
        padding: 6px 12px;
        font-size: 13px;
    }
}

@media (max-width: 576px) {
    .social-share-buttons {
        justify-content: center;
        flex-direction: row;
        flex-wrap: wrap;
    }

    .share-btn {
        flex: 0 0 calc(50% - 10px);
        margin-bottom: 10px;
        justify-content: center;
    }
}


</style>

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
                <div class="main-text clearfix">
                    {!! $post_detail->content !!}
                </div>
                <div class="clearfix"></div>
                <div class="tag-section">
                    <h2>{{ TAGS }}</h2>
                    <div class="tag-section-content">
                        @foreach($tag_data as $item)
                        <a href="{{ route('tag_post_show',$item->slug) }}"><span class="badge bg-success">{{ $item->tag_name }}</span></a>
                        @endforeach
                    </div>
                </div>
                
                {{-- @if($post_detail->is_share == 1)
                <div class="share-content">
                    <h2>{{ SHARE }}</h2>
                    <div class="addthis_inline_share_toolbox"></div>
                </div>
                @endif --}}

                @if($post_detail->is_share == 1)
                    <div class="share-content">
                        <h2>{{ SHARE }}</h2>
                        <div class="social-share-buttons">
                            <!-- Facebook -->
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="share-btn facebook">
                                <i class="fab fa-facebook-f"></i> Facebook
                            </a>
                            
                            <!-- Twitter/X -->
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post_detail->post_title) }}" target="_blank" class="share-btn twitter">
                                <i class="fab fa-twitter"></i> Twitter
                            </a>
                            
                            <!-- WhatsApp -->
                            <a href="https://wa.me/?text={{ urlencode($post_detail->post_title . ' ' . url()->current()) }}" target="_blank" class="share-btn whatsapp">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </a>
                            
                            <!-- Telegram -->
                            <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($post_detail->post_title) }}" target="_blank" class="share-btn telegram">
                                <i class="fab fa-telegram"></i> Telegram
                            </a>
                            
                            <!-- LinkedIn -->
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($post_detail->post_title) }}" target="_blank" class="share-btn linkedin">
                                <i class="fab fa-linkedin-in"></i> LinkedIn
                            </a>
                            
                            <!-- Email -->
                            <a href="mailto:?subject={{ urlencode($post_detail->post_title) }}&body={{ urlencode('Check out this article: ' . url()->current()) }}" class="share-btn email">
                                <i class="fas fa-envelope"></i> Email
                            </a>
                            
                            <!-- Copy Link -->
                            <a href="javascript:void(0);" onclick="copyToClipboard('{{ url()->current() }}')" class="share-btn copy-link">
                                <i class="fas fa-link"></i> Copy Link
                            </a>
                        </div>
                    </div>

                    <!-- Add this script at the end of your main content section -->
                    <script>
                    function copyToClipboard(text) {
                        var tempInput = document.createElement('input');
                        tempInput.value = text;
                        document.body.appendChild(tempInput);
                        tempInput.select();
                        document.execCommand('copy');
                        document.body.removeChild(tempInput);
                        
                        // Show feedback
                        alert('Link copied to clipboard!');
                    }
                    </script>
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
                                <img src="{{ asset('uploads/post_photos/'.$item->post_photo) }}" alt="{{$item->post_photo}}">
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