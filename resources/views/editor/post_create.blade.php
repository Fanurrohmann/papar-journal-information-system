@extends('editor.layout.app')

@section('heading', 'Tambah Berita')

@section('button')
    <a href="{{ route('posts.index') }}" class="btn btn-primary"><i class="fas fa-eye"></i> Lihat Semua</a>
@endsection

@section('main_content')
    <div class="section-body">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <label>Judul Berita *</label>
                        <input type="text" class="form-control" name="post_title" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Detail Berita *</label>
                        <textarea class="form-control snote" name="post_detail" cols="30" rows="10"></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label>Foto *</label>
                        <input type="file" class="form-control" name="post_photo" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Kategori *</label>
                        <select name="sub_category_id" class="form-control" required>
                            @foreach ($sub_categories as $item)
                                <option value="{{ $item->id }}">{{ $item->rCategory->category_name ?? 'N/A' }} -
                                    {{ $item->sub_category_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>Bahasa *</label>
                        <select name="language_id" class="form-control" required>
                            @foreach ($global_language_data as $row)
                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>Izin Dibagikan?</label>
                        <select name="is_share" class="form-control">
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>Izin Komentar?</label>
                        <select name="is_comment" class="form-control">
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>Tags</label>
                        <input type="text" class="form-control" name="tags">
                    </div>

                    <div class="form-group mb-3">
                        <label>Kirim ke Subscriber?</label>
                        <select name="subscriber_send_option" class="form-control">
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
