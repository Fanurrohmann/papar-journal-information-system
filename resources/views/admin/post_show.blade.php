@extends('admin.layout.app')

@section('heading','Post')

@section('button')
<a href="{{ route('admin_post_create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add</a>
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
                                @foreach ($posts as $row)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        {{-- <td>
                                            <img src="{{ asset('uploads/post_photos/'.$row->post_photo) }}" alt="" style="width: 200px;">
                                        </td> --}}
                                        <td>{{ $row->post_title }}</td>
                                        <td>
                                            @if($row->status == 'published')
                                                <span class="badge bg-success">Published</span>
                                            @elseif($row->status == 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif($row->status == 'draft')
                                                <span class="badge bg-secondary">Draft</span>
                                            @else
                                                <span class="badge bg-info">{{ ucfirst($row->status) }}</span>
                                            @endif
                                        </td>
                                        {{-- <td>{{ optional($row->rSubCategory)->sub_category_name ?? 'N/A' }}</td> --}}
                                        <td>{{ optional(optional($row->rSubCategory)->rCategory)->category_name ?? 'N/A' }}</td>
                                        <td>
                                            @if($row->author_id != 0)
                                                {{ \App\Models\Author::where('id',$row->author_id)->first()?->name }}
                                            @endif
                                        </td>
                                        {{-- <td>
                                            @if($row->admin_id != 0)
                                                {{ Auth::guard('admin')->user()->name }}
                                            @endif
                                        </td> --}}
                                        <td>
                                            @if($row->editor_id != 0)
                                            {{ \App\Models\Editor::where('id',$row->editor_id)->first()?->name }}
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d F Y H:i') }}</td>
                                        <td>{{ $row->published_at ? \Carbon\Carbon::parse($row->published_at)->format('d F Y H:i') : '' }}</td>
                                        {{-- <td>{{ $row->rLanguage->name }}</td> --}}
                                        <td class="pt_10 pb_10">
                                            @if($row->admin_id!=0)
                                                <div class="d-flex">
                                                    <a href="{{ route('admin_post_edit',$row->id) }}" class="btn btn-sm btn-primary me-1">Edit</a>
                                                    <a href="{{ route('admin_post_delete',$row->id) }}" class="btn btn-sm btn-danger" onClick="return confirm('Are you sure?');">Delete</a>
                                                </div>
                                            @endif
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