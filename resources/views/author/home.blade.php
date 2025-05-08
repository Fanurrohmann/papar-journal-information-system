@extends('author.layout.app')

@section('heading','Dashboard')

@section('main_content')
<div class="row">
<div class="col-lg-4 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
        <div class="card-icon bg-primary">
            <i class="fas fa-newspaper fa-2x"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Tambah Berita</h4>
          </div>
          <div class="card-body">
            <a href="{{ route('author_post_create') }}" class="card-link">Buat Berita Baru</a>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection