    @extends('layouts.app')

    @section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                
                <div class="text-center mb-4">
                    <img src="https://uns.ac.id/id/wp-content/uploads/2023/06/logo-uns-biru.png" 
                        alt="Logo UNS" width="70" class="mb-3">
                    <h3 class="fw-bold text-dark">Registrasi Alumni</h3>
                    <p class="text-muted">Lengkapi data diri Anda untuk bergabung ke dalam portal.</p>
                </div>

                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-4 p-md-5">

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show small mb-4" role="alert">
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <h6 class="text-uppercase text-muted fw-bold small mb-3"><i class="bi bi-person-badge me-1"></i> Data Pribadi</h6>
                            
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-person"></i></span>
                                    <input type="text" name="name" class="form-control bg-light border-start-0" value="{{ old('name') }}" required placeholder="Sesuai Ijazah">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label class="form-label small fw-bold">NIM <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-card-heading"></i></span>
                                        <input type="text" name="nim" class="form-control bg-light border-start-0" value="{{ old('nim') }}" required placeholder="Nomor Induk">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Email <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                                        <input type="email" name="email" class="form-control bg-light border-start-0" value="{{ old('email') }}" required placeholder="Email Aktif">
                                    </div>
                                </div>
                            </div>

                            <h6 class="text-uppercase text-muted fw-bold small mb-3 mt-4"><i class="bi bi-mortarboard me-1"></i> Data Akademik</h6>
                            
                            <div class="row mb-3">
                                <div class="col-md-8 mb-3 mb-md-0">
                                    <label class="form-label small fw-bold">Jurusan <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-book"></i></span>
                                        <input type="text" name="jurusan" class="form-control bg-light border-start-0" value="{{ old('jurusan') }}" required placeholder="Contoh: Informatika">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Angkatan <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-calendar-event"></i></span>
                                        <input type="number" name="angkatan" class="form-control bg-light border-start-0" value="{{ old('angkatan') }}" required placeholder="Tahun">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-bold">Foto Profil <span class="text-danger">*</span></label>
                                
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-image"></i></span>
                                    <input type="file" id="upload_image" class="form-control bg-light border-start-0" accept="image/*">
                                </div>
                                
                                <div class="form-text text-muted small mb-2"><i class="bi bi-info-circle me-1"></i> Pilih foto lalu sesuaikan posisi wajah.</div>

                                <input type="hidden" name="foto_cropped" id="foto_cropped">

                                <div id="preview_container" class="d-none text-center p-3 bg-light rounded border border-dashed mt-2">
                                    <p class="small fw-bold text-muted mb-2">Hasil Foto Anda:</p>
                                    <img id="preview_result" class="rounded-circle shadow-sm border border-3 border-white" 
                                        style="width: 120px; height: 120px; object-fit: cover;">
                                </div>
                            </div>
                            <div class="mb-3 mt-4">
                                <label class="form-label small fw-bold">Pekerjaan Saat Ini <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-briefcase"></i></span>
                                    <input type="text" name="pekerjaan" class="form-control bg-light border-start-0" 
                                        value="{{ old('pekerjaan') }}" required placeholder="Contoh: Software Engineer di Tech Corp">
                                </div>
                                <div class="form-text text-muted small"><i class="bi bi-info-circle me-1"></i> Isi 'Belum Bekerja' jika saat ini belum bekerja.</div>
                            </div>
                            {{-- Input Deskripsi Diri --}}
                            <div class="mb-3 mt-4">
                                <label class="form-label small fw-bold d-block text-center">Deskripsi Diri <span class="text-danger">*</span></label>
                                
                                {{-- UBAH name="description" menjadi name="bio" --}}
                                <textarea name="bio" 
                                        class="form-control bg-light border-0 shadow-sm text-center py-3" 
                                        rows="3" 
                                        required 
                                        placeholder="Ceritakan singkat tentang diri atau kesibukan Anda saat ini..."
                                        style="border-radius: 15px; resize: none;">{{ old('bio') }}</textarea>
                                
                                <div class="form-text text-muted small text-center mt-2">
                                    <i class="bi bi-info-circle me-1"></i> Deskripsi ini akan tampil di profil publik Anda.
                                </div>
                            </div>
                            <h6 class="text-uppercase text-muted fw-bold small mb-3 mt-4"><i class="bi bi-shield-lock me-1"></i> Keamanan Akun</h6>

                            <div class="row mb-4">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label class="form-label small fw-bold">Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-lock"></i></span>
                                        <input type="password" name="password" class="form-control bg-light border-start-0" required placeholder="Min 8 Karakter">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Ulangi Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-check2-circle"></i></span>
                                        <input type="password" name="password_confirmation" class="form-control bg-light border-start-0" required placeholder="Konfirmasi">
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 mt-5">
                                <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm fw-bold">
                                    <i class="bi bi-send-check me-2"></i> KIRIM REGISTRASI
                                </button>
                                <a href="{{ route('login') }}" class="btn btn-light btn-lg rounded-pill text-primary fw-bold">
                                    Sudah punya akun? Login
                                </a>
                            </div>
                        </form>

                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <p class="small text-muted mb-0">Dengan mendaftar, Anda menyetujui kebijakan privasi kampus.</p>
                </div>
            </div>
        </div>
    </div>

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
        var previewResult = document.getElementById('preview_result');
        var previewContainer = document.getElementById('preview_container');
        var inputHidden = document.getElementById('foto_cropped');
        
        var cropper; 

        // Saat user pilih file
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

        // Saat modal muncul
        var modalElement = document.getElementById('modalCrop');
        modalElement.addEventListener('shown.bs.modal', function() {
            cropper = new Cropper(imageCropper, {
                aspectRatio: 1,       // Wajib Persegi
                viewMode: 1,
                autoCropArea: 1,
            });
        });

        // Saat modal ditutup
        modalElement.addEventListener('hidden.bs.modal', function() {
            cropper.destroy();
            cropper = null;
            inputImage.value = ''; 
        });

        // Saat tombol Potong diklik
        cropButton.addEventListener('click', function() {
            var canvas = cropper.getCroppedCanvas({
                width: 500,
                height: 500,
            });

            canvas.toBlob(function(blob) {
                var url = URL.createObjectURL(blob);
                previewResult.src = url;
                previewContainer.classList.remove('d-none');
                
                // Masukkan data Base64 ke input hidden biar kebaca Controller
                var base64data = canvas.toDataURL('image/jpeg');
                inputHidden.value = base64data; 

                modal.hide();
            });
        });
    });
    </script>

    <style>
        /* Styling khusus Input Group agar border menyatu */
        .form-control:focus {
            border-color: #0076bd;
            box-shadow: none;
            background-color: #fff !important;
        }
        .input-group-text {
            border-color: #ced4da;
        }
        .form-control:focus + .input-group-text, 
        .form-control:focus ~ .input-group-text {
            border-color: #0076bd;
        }
        .input-group:focus-within .form-control, 
        .input-group:focus-within .input-group-text {
            border-color: #0076bd; 
            background-color: #fff !important;
        }
        
        /* Styling Preview Container */
        #preview_container {
            border-color: #dee2e6 !important;
            border-style: dashed !important;
        }
    </style>
    @endsection