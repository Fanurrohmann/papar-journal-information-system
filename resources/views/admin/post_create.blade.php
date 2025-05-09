@extends('admin.layout.app')
@section('heading','Add Post')
@section('button')
<a href="{{ route('admin_post_show') }}" class="btn btn-primary"><i class="fas fa-eye"></i> View</a>
@endsection
@section('main_content')
<div class="section-body">
    <form action="{{ route('admin_post_store') }}" method="post" enctype="multipart/form-data">
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
                            <label>Judul Berita * <span class="text-muted">(60-110 karakter untuk SEO optimal)</span></label>
                            <input type="text" class="form-control" name="post_title" value="{{ old('post_title') }}" required maxlength="110">
                            <small class="text-muted character-count">0/110 karakter</small>
                        </div>

                        <!-- Sub Judul Berita -->
                        <div class="form-group mb-3">
                            <label>Sub Judul Berita</label>
                            <input type="text" class="form-control" name="post_subtitle" value="{{ old('post_subtitle') }}" maxlength="110">
                            <small class="text-muted character-count">0/110 karakter</small>
                        </div>
                        
                        <!-- SEO Slug -->
                        <div class="form-group mb-3">
                            <label>Slug URL * <span class="text-muted">(Otomatis dibuat dari judul)</span></label>
                            <input type="text" class="form-control" name="post_slug" value="{{ old('post_slug') }}" readonly>
                        </div>
                        
                        <!-- Post Content -->
                        <div class="form-group mb-3">
                            <label>Konten *</label>
                            <textarea name="content" class="form-control snote content" cols="30" rows="10">{{ old('content') }}</textarea>
                        </div>
                    </div>
                </div>
                
                <!-- Media Section -->
                <div class="card" >
                    <div class="card-header">
                        <h4>Media</h4>
                    </div>
                    <div class="card-body">
                        <!-- Media -->
                        <div class="form-group mb-3" style="overflow: clip">
                            <label>Gambar Berita *</label>
                            <div><input type="file" name="post_photo" required accept="image/*"></div>
                        </div>
                        
                        <!-- Alt Text untuk Gambar (SEO) -->
                        <div class="form-group mb-3">
                            <label>Caption Gambar <span class="text-muted">(Penting untuk SEO dan aksesibilitas)</span></label>
                            <input type="text" class="form-control" name="photo_caption" value="{{ old('photo_caption') }}">
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- KOLOM KANAN - ELEMEN TAMBAHAN -->
            <div class="col-md-4">
                <!-- Publikasi -->
                <div class="card">
                    <div class="card-header">
                        <h4>Publikasi</h4>
                    </div>
                    <div class="card-body">
                        <!-- Publication Status -->
                        <div class="form-group mb-3">
                            <label>Status Publikasi</label>
                            <select name="status" class="form-control">
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Publish</option>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending Review</option>
                            </select>
                        </div>
                        
                        <!-- Publication Date -->
                        <div class="form-group mb-3">
                                <label>Tanggal & Waktu Publikasi <span class="text-muted">(Kosongkan untuk waktu saat ini)</span></label>
                                <input type="text" class="form-control datetimepicker" name="published_at" value="{{ old('published_at') }}">
                            </div>

                        <!-- Submit Buttons -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block mb-2">Publish</button>
                            {{-- <button type="button" class="btn btn-secondary btn-block" onclick="saveAsDraft()">Save as Draft</button> --}}
                        </div>
                    </div>
                </div>
                
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
                                <option value="{{ $item->id }}" {{ old('sub_category_id') == $item->id ? 'selected' : '' }}>
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
                                <select name="tags[]" class="form-control select2" id="tags-select"  multiple required>
                                    <option value="">-- Pilih Tag --</option>
                                    @foreach($tags as $item)
                                    <option value="{{ $item->id }}" {{ old('tags') == $item->id ? 'selected' : '' }}>
                                        {{ $item->tag_name }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="input-group-append" >
                                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addTagModal"style="height: 100%">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- SEO Settings -->
                <div class="card">
                    <div class="card-header">
                        <h4>SEO Settings</h4>
                    </div>
                    <div class="card-body">
                        <!-- SEO Meta Description -->
                        <div class="form-group mb-3">
                            <label>Meta Description * <span class="text-muted">(150-160 karakter)</span></label>
                            <textarea name="meta_description" class="form-control" maxlength="160" style="height: 70px">{{ old('meta_description') }}</textarea>
                            <small class="text-muted character-count">0/160 karakter</small>
                        </div>
                    </div>
                </div>
                
                <!-- Pengaturan Tambahan -->
                <div class="card">
                    <div class="card-header">
                        <h4>Pengaturan Tambahan</h4>
                    </div>
                    <div class="card-body">
                        <!-- Editor dan Reporter -->
                        <div class="form-group mb-3">
                            <label>Redaktur / Editor *</label>
                            <select name="editor_id" class="form-control select2" required>
                                <option value="">-- Pilih --</option>
                                @foreach($editors as $item)
                                    <option value="{{ $item->id }}" {{ old('editor_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label>Penulis / Reporter *</label>
                            <select name="author_id" class="form-control select2" required>
                                <option value="">-- Pilih Reporter --</option>
                                @foreach($authors as $item)
                                    <option value="{{ $item->id }}" {{ old('author_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Interactive Options -->
                        <div class="form-group mb-3">
                            <label>Is Sharable?</label>
                            <select name="is_share" class="form-control">
                                <option value="1" {{ old('is_share') == '1' ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ old('is_share') == '0' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label>Allow Comments?</label>
                            <select name="is_comment" class="form-control">
                                <option value="1" {{ old('is_comment') == '1' ? 'selected' : '' }}>Yes</option>
                                <option value="0" selected {{ old('is_comment') == '0' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label>Featured Post?</label>
                            <select name="is_featured" class="form-control">
                                <option value="0" {{ old('is_featured') == '0' ? 'selected' : '' }}>No</option>
                                <option value="1" {{ old('is_featured') == '1' ? 'selected' : '' }}>Yes</option>
                            </select>
                        </div>
                        
                        <!-- Subscriber Notification -->
                        <div class="form-group mb-3">
                            <label>Send to subscribers?</label>
                            <select name="subscriber_send_option" class="form-control">
                                <option value="1" {{ old('subscriber_send_option') == '1' ? 'selected' : '' }}>Yes</option>
                                <option value="0" selected {{ old('subscriber_send_option') == '0' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>

<!-- Modal untuk Tambah Tag -->
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
                    <div class="invalid-feedback" id="tag-error-message"></div>
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

        // $('.datetimepicker').daterangepicker({
        //     locale: { format: 'YYYY-MM-DD HH:mm' },
        //     singleDatePicker: true,
        //     timePicker: true,
        //     timePicker24Hour: true,
        // });
    });
// JavaScript untuk menghitung karakter dan mem-preview slug
document.addEventListener('DOMContentLoaded', function() {
    // Karakter counter untuk judul dan meta description
    const textInputs = document.querySelectorAll('input[name="post_title"], input[name="post_subtitle"], textarea[name="meta_description"]');
    textInputs.forEach(input => {
        const counter = input.nextElementSibling;
        if (counter && counter.classList.contains('character-count')) {
            // Initial count
            const charCount = input.value.length;
            const maxLength = input.getAttribute('maxlength');
            counter.textContent = `${charCount}/${maxLength} karakter`;
            
            // Update on input
            input.addEventListener('input', function() {
                const charCount = this.value.length;
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
    
    // Auto-generate slug dari judul
    const titleInput = document.querySelector('input[name="post_title"]');
    const slugInput = document.querySelector('input[name="post_slug"]');
    
    titleInput.addEventListener('blur', function() {
        // if (slugInput.value === '') {
            // Slug generation logic - convert to lowercase, replace spaces with dashes, remove special chars
            let slug = this.value?.trim()?.toLowerCase()
                         .replace(/[^\w\s-]/g, '')  // Remove special characters
                         .replace(/\s+/g, '-')      // Replace spaces with dashes
                         .replace(/-+/g, '-');      // Replace multiple dashes with single dash
            
            slugInput.value = slug;
        // }
    });
    
    // Save as draft function
    window.saveAsDraft = function() {
        const statusSelect = document.querySelector('select[name="status"]');
        statusSelect.value = 'draft';
        document.querySelector('form').submit();
    };

        // Add new tag functionality
        $('#save-new-tag').on('click', function() {
            const $saveButton = $(this);
            const tagName = $('#new-tag-name').val().trim();
            
            if (tagName === '') {
                $('#tag-error-message').text('Nama tag tidak boleh kosong!').show();
                $('#new-tag-name').addClass('is-invalid');
                return;
            }
            
            // Show loading indicator
            $saveButton.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');
            $saveButton.prop('disabled', true);
            
            // AJAX request to save the new tag
            $.ajax({
                url: "{{ route('tags.store') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "tag_name": tagName
                },
                dataType: "json",
                success: function(response) {
                    // Menghilangkan spinner dan mengembalikan tombol ke keadaan awal
                    $saveButton.html('Simpan');
                    $saveButton.prop('disabled', false);
                    
                    if (response.success) {
                        // Add the new tag to the select dropdown
                        const newOption = new Option(response.tag.tag_name, response.tag.id, true, true);
                        $('#tags-select').append(newOption).trigger('change');
                        // Reset the modal
                        $('#new-tag-name').val('');
                        $('#addTagModal').modal('hide');
                        // Show success notification
                    } else {
                        $('#tag-error-message').text(response.message).show();
                        $('#new-tag-name').addClass('is-invalid');
                    }
                },
                error: function(xhr) {
                    // Menghilangkan spinner dan mengembalikan tombol ke keadaan awal
                    $saveButton.html('Simpan');
                    $saveButton.prop('disabled', false);
                    
                    const message = xhr?.responseJSON?.message;
                    if (message) {
                        $('#tag-error-message').text(message).show();
                        $('#new-tag-name').addClass('is-invalid');
                    } else {
                        $('#tag-error-message').text('Terjadi kesalahan. Silakan coba lagi.').show();
                        $('#new-tag-name').addClass('is-invalid');
                    }
                }
            });
        });
        
        // Reset validation state when modal is hidden
        $('#addTagModal').on('hidden.bs.modal', function() {
            $('#new-tag-name').removeClass('is-invalid');
            $('#tag-error-message').hide();
            $('#new-tag-name').val('');
        });
        
        // Allow submitting the tag form with Enter key
        $('#new-tag-name').on('keypress', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                $('#save-new-tag').click();
            }
        });
});
</script>
@endsection