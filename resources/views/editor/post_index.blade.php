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
                                <th>No</th>
                                {{-- <th>Thumbnail</th> --}}
                                <th>Judul</th>
                                <th>Status</th>
                                <th>Kategori</th>
                                <th>Author</th>
                                <th>Editor</th>
                                <th>Tanggal Dibuat</th>
                                <th>Tanggal Terbit</th>
                                {{-- <th>Admin</th> --}}
                                {{-- <th>Language</th> --}}
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $post)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                        {{-- <td>
                                            <img src="{{ asset('uploads/post_photos/'.$post->post_photo) }}" alt="" style="width: 200px;">
                                        </td> --}}
                                        <td>{{ $post->post_title }}</td>
                                        <td>
                                            @if($post->status == 'published')
                                                <span class="badge bg-success">Published</span>
                                            @elseif($post->status == 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif($post->status == 'draft')
                                                <span class="badge bg-secondary">Draft</span>
                                            @else
                                                <span class="badge bg-info">{{ ucfirst($post->status) }}</span>
                                            @endif
                                        </td>
                                        {{-- <td>{{ optional($post->rSubCategory)->sub_category_name ?? 'N/A' }}</td> --}}
                                        <td>{{ optional(optional($post->rSubCategory)->rCategory)->category_name ?? 'N/A' }}</td>
                                        <td>
                                            @if($post->author_id != 0)
                                                {{ \App\Models\Author::where('id',$post->author_id)->first()?->name }}
                                            @endif
                                        </td>
                                        {{-- <td>
                                            @if($post->admin_id != 0)
                                                {{ Auth::guard('admin')->user()->name }}
                                            @endif
                                        </td> --}}
                                        <td>
                                            @if($post->editor_id != 0)
                                            {{ \App\Models\Editor::where('id',$post->editor_id)->first()?->name }}
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($post->created_at)->format('d F Y H:i') }}</td>
                                        <td>{{ $post->published_at ? \Carbon\Carbon::parse($post->published_at)->format('d F Y H:i') : '' }}</td>
                                        {{-- <td>{{ $post->rLanguage->name }}</td> --}}
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('posts.edit', $post->id) }}"
                                                class="btn btn-sm btn-primary me-1">Edit</a>
    
                                            @if ($post->status !== 'published')
                                                <form method="POST" action="{{ route('editor.posts.approve', $post->id) }}"
                                                    class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success me-1">Setujui</button>
                                                </form>
                                            @else
                                                {{-- Pastikan route ini tersedia di web.php --}}
                                                <form method="POST" action="{{ route('editor.posts.cancel', $post->id) }}"
                                                    class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-warning me-1">Batalkan</button>
                                                </form>
                                            @endif
    
                                            <form method="POST" action="{{ route('posts.destroy', $post->id) }}"
                                                class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus berita ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger me-1">Hapus</button>
                                            </form>
                                        </div>
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
