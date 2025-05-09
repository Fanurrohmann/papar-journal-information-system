@extends('author.layout.app')

@section('heading','Edit Post')

@section('button')
<a href="{{ route('author_post_show') }}" class="btn btn-primary"><i class="fas fa-eye"></i> View</a>
@endsection
@section('main_content')
<div class="section-body">
    <form action="{{ route('author_post_update', $post->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <!-- KOLOM KIRI - ELEMEN PENTING -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Informasi Utama</h4>
                    </div>
                    <div class="card-body">
                        <!-- Judul Berita -->
                        <div class="form-group mb-3">
                            <label>Judul Berita * <span class="text-muted">(60-70 karakter untuk SEO optimal)</span></label>
                            <input type="text" class="form-control" name="post_title" value="{{ $post->post_title }}" required maxlength="70">
                            <small class="text-muted character-count">{{ strlen($post->post_title) }}/70 karakter</small>
                        </div>

                        <!-- Sub Judul Berita -->
                        <div class="form-group mb-3">
                            <label>Sub Judul Berita</label>
                            <input type="text" class="form-control" name="post_subtitle" value="{{ $post->post_subtitle }}" maxlength="70">
                            <small class="text-muted character-count">{{ strlen($post->post_subtitle) }}/70 karakter</small>
                        </div>
                        
                        <!-- SEO Slug -->
                       
                        
                        <!-- Post Content -->
                        <div class="form-group mb-3">
                            <label>Konten *</label>
                            <textarea name="content" class="form-control snote content" cols="30" rows="10">{{ $post->content }}</textarea>
                        </div>
                    </div>
                </div>
                
                <!-- Media Section -->
                <div class="card" >
                    <div class="card-header">
                        <h4>Media</h4>
                    </div>
                    <div class="card-body">
                        <!-- Current Image -->
                        <div class="form-group mb-3">
                            <label>Gambar Berita Saat Ini</label>
                            <div>
                                <img src="{{ asset('uploads/post_photos/'.$post->post_photo) }}" alt="Current image" style="max-width: 300px;" class="img-fluid">
                            </div>
                        </div>
                        
                        <!-- Media -->
                        <div class="form-group mb-3" style="overflow: clip">
                            <label>Ganti Gambar Berita</label>
                            <div><input type="file" name="post_photo" accept="image/*"></div>
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengganti gambar</small>
                        </div>
                        
                        <!-- Alt Text untuk Gambar (SEO) -->
                        <div class="form-group mb-3">
                            <label>Caption Gambar <span class="text-muted">(Penting untuk SEO dan aksesibilitas)</span></label>
                            <input type="text" class="form-control" name="photo_caption" value="{{ $post->photo_caption }}">
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- KOLOM KANAN - ELEMEN TAMBAHAN -->
            <div class="col-md-4">
                
                <!-- Kategori & Tags -->
                <div class="card">
                    <div class="card-header">
                        <h4>Kategori & Tags</h4>
                    </div>
                    <div class="card-body">
                        <!-- Kategori -->
                        <div class="form-group mb-3">
                            <label>Kategori *</label>
                            <select name="sub_category_id" class="form-control select2" required>
                                <option value="">-- Pilih Category --</option>
                                @foreach($sub_categories as $item)
                                <option value="{{ $item->id }}" {{ $post->sub_category_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->sub_category_name }}
                                    ({{ $item->rCategory->category_name ?? 'No Category' }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- SEO Tags -->
                        <div class="form-group mb-3">
                            <label>Tags *</label>
                            <div class="d-flex">
                                <select name="tags[]" class="form-control select2" multiple required>
                                    <option value="">-- Pilih Tag --</option>
                                    @foreach($tags as $item)
                                    <option value="{{ $item->id }}" {{ in_array($item->id, $post->tags->pluck('id')->toArray()) ? 'selected' : '' }}>
                                        {{ $item->tag_name }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addTagModal" style="height: 100%">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <div class="card">
                    <div class="card-body">
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary btn-block">Update</button>
                        </div>
                    </div>
                </div>
                
               
            </div>
        </div>
    </form>

</div>

<div class="modal fade" id="addTagModal" tabindex="-1" role="dialog" aria-labelledby="addTagModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTagModalLabel">Tambah Tag Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="new-tag-name">Nama Tag</label>
                    <input type="text" class="form-control" id="new-tag-name" placeholder="Masukkan nama tag baru">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="save-new-tag">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.content').summernote({
            tabsize: 2,
            height: 300,
        });
    });

    // JavaScript untuk menghitung karakter
    document.addEventListener('DOMContentLoaded', function() {
        // Karakter counter untuk judul dan meta description
        const textInputs = document.querySelectorAll('input[name="post_title"], input[name="post_subtitle"]');
        textInputs.forEach(input => {
            const counter = input.nextElementSibling;
            if (counter && counter.classList.contains('character-count')) {
                // Update on input
                input.addEventListener('input', function() {
                    const charCount = this.value.length;
                    const maxLength = input.getAttribute('maxlength');
                    counter.textContent = `${charCount}/${maxLength} karakter`;
                    
                    // Memberikan peringatan warna jika mendekati batas
                    if (charCount > parseInt(maxLength) * 0.9) {
                        counter.classList.add('text-danger');
                    } else {
                        counter.classList.remove('text-danger');
                    }
                });
            }
        });
        
        // Handle add new tag
        document.getElementById('save-new-tag').addEventListener('click', function() {
            const tagName = document.getElementById('new-tag-name').value;
            
            if (tagName.trim() === '') {
                alert('Nama tag tidak boleh kosong!');
                return;
            }
            
            // AJAX request untuk menyimpan tag baru
            // Implement your AJAX code here
        });
    });
</script>
@endsection