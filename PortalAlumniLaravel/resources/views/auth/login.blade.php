@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-5 col-lg-4">
            
            <div class="text-center mb-4">
                <img src="https://uns.ac.id/id/wp-content/uploads/2023/06/logo-uns-biru.png" 
                     alt="Logo UNS" width="80" class="mb-3">
                <h4 class="fw-bold text-dark">Portal Alumni</h4>
                <p class="text-muted small">Silakan masuk menggunakan akun terdaftar.</p>
            </div>

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4 p-md-5">
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show small" role="alert">
                            <i class="bi bi-exclamation-circle-fill me-1"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger small">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ url('/login') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">EMAIL</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input type="email" name="email" class="form-control bg-light border-start-0 py-2 ps-1" 
                                       placeholder="nama@email.com" required value="{{ old('email') }}">
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between">
                                <label class="form-label small fw-bold text-muted">PASSWORD</label>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted">
                                    <i class="bi bi-lock-fill"></i>
                                </span>
                                <input type="password" name="password" class="form-control bg-light border-start-0 py-2 ps-1" 
                                       placeholder="••••••••" required>
                            </div>
                        </div>

                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-primary rounded-pill py-2 fw-bold shadow-sm">
                                MASUK PORTAL <i class="bi bi-box-arrow-in-right ms-1"></i>
                            </button>
                        </div>

                        <div class="text-center">
                            <p class="text-muted small mb-0">Belum memiliki akun alumni?</p>
                            <a href="{{ route('register') }}" class="text-primary fw-bold text-decoration-none">
                                Daftar Alumni Baru
                            </a>
                        </div>

                    </form>
                </div>
            </div>

            <div class="text-center mt-4 text-muted opacity-50 small">
                &copy; {{ date('Y') }} Universitas Sebelas Maret
            </div>

        </div>
    </div>
</div>

<style>
    /* Fokus Input biar warnanya biru UNS */
    .form-control:focus {
        border-color: #0076bd;
        box-shadow: none; /* Hilangkan shadow default bootstrap biar bersih */
    }
    .input-group-text {
        border-color: #ced4da;
    }
    /* Biar border input nyatu sama icon pas di klik */
    .form-control:focus + .input-group-text, 
    .form-control:focus ~ .input-group-text {
        border-color: #0076bd;
    }
    /* Trik CSS biar border input dan icon terlihat menyatu */
    .input-group:focus-within .form-control, 
    .input-group:focus-within .input-group-text {
        border-color: #0076bd; 
        background-color: #fff;
    }
</style>
@endsection