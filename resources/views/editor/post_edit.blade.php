@extends('editor.layout.app')

@section('heading', 'Edit Berita')

@section('button')
    <a href="{{ route('posts.index') }}" class="btn btn-primary"><i class="fas fa-eye"></i> Lihat Semua</a>
@endsection

@section('main_content')
    <div class="section-body">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <label>Judul Berita *</label>
                        <input type="text" class="form-control" name="post_title" value="{{ $post->post_title }}"
                            required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Detail Berita *</label>
                        <textarea class="form-control snote" name="post_detail" cols="30" rows="10">{{ $post->post_detail }}</textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label>Foto Lama</label><br>
                        <img src="{{ asset('uploads/' . $post->post_photo) }}" alt="" width="200">
                    </div>

                    <div class="form-group mb-3">
                        <label>Ganti Foto</label>
                        <input type="file" class="form-control" name="post_photo">
                    </div>

                    <div class="form-group mb-3">
                        <label>Kategori *</label>
                        <select name="sub_category_id" class="form-control" required>
                            @foreach ($sub_categories as $item)
                                <option value="{{ $item->id }}"
                                    {{ $post->sub_category_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->rCategory->category_name }} - {{ $item->sub_category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>Bagikan?</label>
                        <select name="is_share" class="form-control">
                            <option value="1" {{ $post->is_share == 1 ? 'selected' : '' }}>Ya</option>
                            <option value="0" {{ $post->is_share == 0 ? 'selected' : '' }}>Tidak</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>Izin Komentar?</label>
                        <select name="is_comment" class="form-control">
                            <option value="1" {{ $post->is_comment == 1 ? 'selected' : '' }}>Ya</option>
                            <option value="0" {{ $post->is_comment == 0 ? 'selected' : '' }}>Tidak</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>Tag yang Ada</label>
                        <table class="table table-bordered">
                            @foreach ($existing_tags as $tag)
                                <tr>
                                    <td>{{ $tag->tag_name }}</td>
                                    <td>
                                        <a href="{{ route('editor_post_delete_tag', [$tag->id, $post->id]) }}"
                                            onclick="return confirm('Yakin ingin menghapus tag ini?');">Hapus</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>

                    <div class="form-group mb-3">
                        <label>Tag Baru</label>
                        <input type="text" class="form-control" name="tags" value="">
                        <small class="text-muted">Pisahkan dengan koma jika lebih dari satu. Contoh: berita, nasional,
                            opini</small>
                    </div>

                    <div class="form-group mb-3">
                        <label>Bahasa *</label>
                        <select name="language_id" class="form-control" required>
                            @foreach ($global_language_data as $lang)
                                <option value="{{ $lang->id }}"
                                    {{ $post->language_id == $lang->id ? 'selected' : '' }}>
                                    {{ $lang->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="pending" {{ $post->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="draft" {{ $post->status == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="acc" {{ $post->status == 'acc' ? 'selected' : '' }}>ACC</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
