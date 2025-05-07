@extends('admin.layout.app')

@section('heading', 'Tambah Editor')

@section('button')
    <a href="{{ route('admin.editor.index') }}" class="btn btn-primary"><i class="fas fa-eye"></i> Lihat Semua</a>
@endsection

@section('main_content')
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.editor.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mb-3">
                                <label>Photo</label>
                                <div>
                                    <input type="file" name="photo" id="">
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label>Nama *</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="form-group mb-3">
                                <label>Email *</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="form-group mb-3">
                                <label>Password *</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <div class="form-group mb-3">
                                <label>Retype Password *</label>
                                <div>
                                    <input type="password" class="form-control" name="retype_password">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
