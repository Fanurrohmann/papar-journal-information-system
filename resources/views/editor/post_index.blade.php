@extends('editor.layout.app')

@section('heading', 'Daftar Berita Editor')

@section('button')
    <a href="{{ route('posts.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Berita</a>
@endsection

@section('main_content')
    <div class="section-body">
        <div class="card">
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Judul</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $post)
                                <tr>
                                    <td>
                                        @if ($post->post_photo)
                                            <img src="{{ asset('uploads/' . $post->post_photo) }}" alt="Foto"
                                                width="300">
                                        @else
                                            <span class="text-muted">Tidak ada foto</span>
                                        @endif
                                    </td>

                                    <td>{{ $post->post_title }}</td>
                                    <td>
                                        <span
                                            class="badge
                        @if ($post->status === 'acc') badge-success
                        @elseif ($post->status === 'pending') badge-warning
                        @elseif ($post->status === 'draft') badge-secondary
                        @else badge-light @endif">
                                            {{ ucfirst($post->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('posts.edit', $post->id) }}"
                                            class="btn btn-sm btn-primary">Edit</a>

                                        @if ($post->status !== 'acc')
                                            <form method="POST" action="{{ route('editor.posts.approve', $post->id) }}"
                                                class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">Setujui</button>
                                            </form>
                                        @else
                                            {{-- Pastikan route ini tersedia di web.php --}}
                                            <form method="POST" action="{{ route('editor.posts.cancel', $post->id) }}"
                                                class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-warning">Batalkan</button>
                                            </form>
                                        @endif

                                        <form method="POST" action="{{ route('posts.destroy', $post->id) }}"
                                            class="d-inline"
                                            onsubmit="return confirm('Yakin ingin menghapus berita ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
