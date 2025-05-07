@extends('admin.layout.app')

@section('heading', 'Edit Editor')

@section('button')
    <a href="{{ route('admin.editor.index') }}" class="btn btn-primary"><i class="fas fa-eye"></i> Lihat Semua</a>
@endsection

@section('main_content')
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.editor.update', $editor->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                           <div class="form-group mb-3">
                                <label>Existing Photo</label>
                                <div>
                                    <img src="{{ asset($editor->photo) }}" alt="" style="width: 150px;">
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label>Change Photo</label>
                                <div>
                                    <input type="file" name="photo" id="">
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label>Nama</label>
                                <input type="text" class="form-control" name="name" value="{{ $editor->name }}"
                                    required>
                            </div>
                            <div class="form-group mb-3">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" value="{{ $editor->email }}"
                                    required>
                            </div>
                            <div class="form-group mb-3">
                                <label>Password Baru <small>(Kosongkan jika tidak diubah)</small></label>
                                <input type="password" class="form-control" name="password">
                            </div>
                            <button type="submit" class="btn btn-success">Perbarui</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
