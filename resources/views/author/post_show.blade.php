@extends('author.layout.app')

@section('heading', 'Berita Saya')

@section('button')
    <a href="{{ route('author_post_create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add</a>
@endsection

@section('main_content')
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="example1">
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
                                                <a href="{{ route('author_post_edit', $post->id) }}"
                                                    class="btn btn-sm btn-primary me-1">Edit</a>
                                                <form method="POST" action="{{ route('author_post_delete', $post->id) }}"
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
        </div>
    </div>
@endsection
