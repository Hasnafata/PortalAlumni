@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">

<style>
    /* Styling khusus agar textarea edit profil estetik */
    textarea.estetik::placeholder {
        text-align: center;
        opacity: 0.7;
    }
    textarea.estetik:focus {
        outline: none !important;
        box-shadow: 0 0 10px rgba(0, 118, 189, 0.1) !important;
        background-color: #fff !important;
        border: 1px solid #0076bd !important;
    }
</style>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow border-0 rounded-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i>Edit Profil Saya</h5>
            </div>
            <div class="card-body p-4">
                
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show small" role="alert">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('admin.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="text-center mb-4">
                        <div class="position-relative d-inline-block">
                            <img id="avatar_preview" 
                                 src="{{ $user->foto ? asset('storage/' . $user->foto) : '' }}" 
                                 class="rounded-circle shadow mb-2 {{ $user->foto ? '' : 'd-none' }}" 
                                 style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #fff;">

                            <div id="avatar_initials" class="bg-secondary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 {{ $user->foto ? 'd-none' : '' }}" 
                                 style="width: 120px; height: 120px; font-size: 3rem; color: white; border: 3px solid #fff;">
                                {{ substr($user->name, 0, 1) }}
                            </div>

                            <label for="upload_image" class="position-absolute bottom-0 end-0 bg-white rounded-circle shadow p-2" style="cursor: pointer; width: 40px; height: 40px;">
                                <i class="bi bi-camera-fill text-primary d-block mt-1"></i>
                            </label>
                        </div>
                        
                        <br>
                        
                        <label class="btn btn-sm btn-outline-primary mt-2 rounded-pill px-3">
                            Ganti Foto Profil
                            <input type="file" id="upload_image" class="d-none" accept="image/*">
                        </label>

                        <input type="hidden" name="foto_cropped" id="foto_cropped">
                    </div>

                    <<div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">NIM (Nomor Induk Mahasiswa)</label>
                            <input type="text" name="nim" class="form-control" value="{{ old('nim', $user->nim) }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Jurusan</label>
                            <input type="text" name="jurusan" class="form-control" value="{{ old('jurusan', $user->jurusan) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Angkatan</label>
                            <input type="number" name="angkatan" class="form-control" value="{{ old('angkatan', $user->angkatan) }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small">Pekerjaan Saat Ini</label>
                        <input type="text" name="pekerjaan" class="form-control shadow-sm" style="border-radius: 10px;" value="{{ old('pekerjaan', $user->pekerjaan) }}" placeholder="Contoh: Software Engineer di Google">
                    </div>

                    {{-- Bio Singkat dengan tampilan Tengah & Estetik --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold small d-block text-center">Bio / Deskripsi Diri</label>
                        <textarea name="bio" 
                                  class="form-control estetik bg-light border-0 shadow-sm text-center py-3" 
                                  rows="3" 
                                  placeholder="Ceritakan singkat tentang diri atau kesibukan Anda saat ini..."
                                  style="border-radius: 15px; resize: none;">{{ old('bio', $user->bio) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small">Ganti Password (Opsional)</label>
                        <input type="password" name="password" class="form-control" placeholder="Min 8 karakter & harus ada angka">
                        <small class="text-muted">Kosongkan jika tidak ingin mengganti password.</small>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end border-top pt-3">
                        <a href="{{ route('dashboard') }}" class="btn btn-light me-md-2 fw-bold text-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 fw-bold rounded-pill">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- MODAL CROP TETAP SAMA --}}
<div class="modal fade" id="modalCrop" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Sesuaikan Foto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 text-center bg-dark">
                <div class="img-container" style="max-height: 500px;">
                    <img id="image_cropper" src="" style="max-width: 100%; display: block;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary fw-bold" id="crop_button">Potong & Simpan</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var inputImage = document.getElementById('upload_image');
    var modal = new bootstrap.Modal(document.getElementById('modalCrop'));
    var imageCropper = document.getElementById('image_cropper');
    var cropButton = document.getElementById('crop_button');
    var inputHidden = document.getElementById('foto_cropped');
    
    var avatarPreview = document.getElementById('avatar_preview');
    var avatarInitials = document.getElementById('avatar_initials');
    
    var cropper; 

    inputImage.addEventListener('change', function(e) {
        var files = e.target.files;
        var done = function(url) {
            imageCropper.src = url;
            modal.show();
        };

        if (files && files.length > 0) {
            var reader = new FileReader();
            reader.onload = function(event) {
                done(reader.result);
            };
            reader.readAsDataURL(files[0]);
        }
    });

    var modalElement = document.getElementById('modalCrop');
    modalElement.addEventListener('shown.bs.modal', function() {
        cropper = new Cropper(imageCropper, {
            aspectRatio: 1, 
            viewMode: 1,
            autoCropArea: 1,
        });
    });

    modalElement.addEventListener('hidden.bs.modal', function() {
        if(cropper) {
            cropper.destroy();
            cropper = null;
        }
        inputImage.value = ''; 
    });

    cropButton.addEventListener('click', function() {
        var canvas = cropper.getCroppedCanvas({
            width: 500,
            height: 500,
        });

        canvas.toBlob(function(blob) {
            var url = URL.createObjectURL(blob);
            
            if(avatarInitials) avatarInitials.classList.add('d-none');
            avatarPreview.src = url;
            avatarPreview.classList.remove('d-none');

            var base64data = canvas.toDataURL('image/jpeg');
            inputHidden.value = base64data; 

            modal.hide();
        });
    });
});
</script>
@endsection