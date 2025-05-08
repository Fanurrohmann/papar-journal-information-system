@extends('editor.layout.app')
@section('heading', 'Dashboard Editor')
{{-- @section('button')
    <a href="{{ route('posts.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Berita</a>
@endsection --}}
@section('main_content')
<div class="section-body">
    <div class="row">
        <!-- Card: Tambah Berita -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-newspaper fa-2x"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Tambah Berita</h4>
                  </div>
                  <div class="card-body">
                    <a href="{{ route('posts.create') }}" class="card-link">Buat Berita Baru</a>
                  </div>
                </div>
              </div>
        </div>

        <!-- Card: Iklan/Advetorial -->
        {{-- <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card">
                <div class="card-body d-flex">
                    <div class="bg-success text-white p-3 rounded mr-3">
                        <i class="fas fa-ad fa-2x"></i>
                    </div>
                    <div>
                        <h5 class="card-title">Iklan</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Advetorial</h6>
                        <a href="#" class="card-link">Kelola Iklan</a>
                    </div>
                </div>
            </div>

           
        </div> --}}

        <!-- Card: Halaman Redaksi -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="fas fa-ad fa-2x"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Iklan Advetorial</h4>
                  </div>
                  <div class="card-body">
                    <a href="{{ route('editor_top_ad_show') }}" class="card-link">Kelola Iklan</a>
                  </div>
                </div>
              </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Card: Berita Hari Ini -->
        <div class="col-lg-6 col-md-12">
            <div class="card bg-info text-white" style="height: 90%">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-3">Berita Hari ini : {{ $today_posts_count ?? 1 }}</h4>
                            <h5>Pembaca Hari ini : {{ $today_visitors ?? 6 }}</h5>
                        </div>
                        <div>
                            <i class="fa fa-chart-line fa-3x"></i>
                        </div>
                    </div>
                    <div class="text-right mt-3">
                        <a href="{{ route('posts.index') }}" class="btn btn-outline-light">Lihat Semua Berita <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card: Berita Bulan Ini -->
        <div class="col-lg-6 col-md-12">
            <div class="card bg-secondary text-white" style="height: 90%">
                <div class="card-body" >
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-3">Berita Bulan ini : {{ $month_posts_count ?? 10 }}</h4>
                            <h5>Pembaca Bulan ini : {{ $month_visitors ?? 192 }}</h5>
                        </div>
                        <div>
                            <i class="fa fa-chart-bar fa-3x"></i>
                        </div>
                    </div>
                    {{-- <div class="text-right mt-3">
                        <a href="#" class="btn btn-outline-light">Lihat Rekap Berita <i class="fas fa-arrow-circle-right"></i></a>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

    <!-- Table: Berita Kiriman Reporter -->
    <div class="card mt-4">
        <div class="card-header">
            <h4>Berita Kiriman Reporter</h4>
            <div class="card-header-action">
                <button type="button" class="btn btn-info" onclick="refresh()"><i class="fas fa-sync-alt"></i> Refresh</button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="example1">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>REPORTER</th>
                            <th>JUDUL <i class="fas fa-sort"></i></th>
                            <th>TANGGAL <i class="fas fa-sort"></i></th>
                            <th>STATUS</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reporter_posts ?? [] as $index => $post)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $post->author->name ?? 'N/A' }}</td>
                            <td>{{ $post->post_title }}</td>
                            <td>{{ $post->created_at ? \Carbon\Carbon::parse($post->created_at)->format('d F Y H:i') : '-' }}</td>
                            <td>
                                @if($post->status == 'published')
                                <span class="badge bg-success">Published</span>
                                @elseif($post->status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                                @elseif($row->status == 'draft')
                                <span class="badge bg-secondary">Draft</span>
                                @else
                                                <span class="badge bg-info">{{ ucfirst($row->status) }}</span>
                                            @endif
                                
                            </td>
                            <td>
                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                @if($post->status == 'pending')
                                    <a href="{{ route('editor.posts.approve', $post->id) }}" class="btn btn-success btn-sm" onclick="return confirm('Approve this post?')"><i class="fas fa-check"></i></a>
                                @endif
                                <a href="#" class="btn btn-danger btn-sm delete-item" data-id="{{ $post->id }}"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No data available in table</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                @if(empty($reporter_posts) || count($reporter_posts) == 0)
                <div class="text-muted mt-3">data masih kosong</div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    function refresh(){
        location.reload();
    }
    
    $(document).ready(function() {
        // Delete confirmation
        $('.delete-item').on('click', function(e) {
            e.preventDefault();
            if (confirm('Apakah anda yakin ingin menghapus berita ini?')) {
                const postId = $(this).data('id');
                // Create form for delete request
                const form = $('<form>', {
                    'method': 'POST',
                    'action': '/editor/posts/' + postId + '/destroy'
                });
                
                form.append($('<input>', {
                    'name': '_method',
                    'type': 'hidden',
                    'value': 'DELETE'
                }));
                
                form.append($('<input>', {
                    'name': '_token',
                    'type': 'hidden',
                    'value': $('meta[name="csrf-token"]').attr('content')
                }));
                
                form.appendTo('body').submit();
            }
        });
    });
</script>
@endsection



