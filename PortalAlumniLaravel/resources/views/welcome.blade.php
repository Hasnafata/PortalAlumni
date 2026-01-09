@extends('layouts.app')

@section('content')

<div class="position-relative text-white" style="background: linear-gradient(135deg, #005a91 0%, #003b6d 100%); padding: 100px 0;">
    <div class="container position-relative z-1">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <span class="badge bg-white bg-opacity-10 border border-white border-opacity-25 rounded-pill px-3 py-2 mb-4 fw-normal">
                    <i class="bi bi-mortarboard-fill me-2"></i> Portal Resmi Alumni UNS
                </span>
                
                <h1 class="display-4 fw-bold mb-3" style="letter-spacing: -1px;">Sinergi Alumni untuk Negeri</h1>
                <p class="lead text-white-50 mb-5 fs-5">
                    Platform digital terintegrasi untuk menghubungkan kembali ribuan alumni Universitas Sebelas Maret dari berbagai angkatan dan jurusan.
                </p>
                
                <a href="{{ route('alumni.list') }}" class="btn btn-light btn-lg rounded-pill px-5 py-3 fw-bold shadow-sm text-primary">
                    <i class="bi bi-search me-2"></i> Telusuri Alumni
                </a>
            </div>
        </div>
    </div>
    
    <div class="position-absolute bottom-0 start-0 w-100 overflow-hidden" style="height: 100px;">
        <svg viewBox="0 0 1440 320" preserveAspectRatio="none" style="height: 100%; width: 100%;">
            <path fill="#f8f9fa" fill-opacity="1" d="M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,224C672,245,768,267,864,261.3C960,256,1056,224,1152,197.3C1248,171,1344,149,1392,138.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div>
</div>

<div class="container" style="margin-top: -50px; position: relative; z-index: 10;">
    <div class="row g-4">
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 py-4 px-3 rounded-4 card-hover">
                <div class="card-body text-center">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-people-fill fs-3"></i>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark">{{ $count }}</h3>
                    <h6 class="text-uppercase text-muted fw-bold small tracking-wide">Alumni Terverifikasi</h6>
                    <p class="text-muted small mt-3 px-3">
                        Database alumni yang valid dan terus bertambah setiap harinya.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 py-4 px-3 rounded-4 card-hover">
                <div class="card-body text-center">
                    <div class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success rounded-circle mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-briefcase-fill fs-3"></i>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark">Karir</h3>
                    <h6 class="text-uppercase text-muted fw-bold small tracking-wide">Jejaring Profesional</h6>
                    <p class="text-muted small mt-3 px-3">
                        Temukan mentor, rekan kerja, atau peluang karir dari sesama alumni.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 py-4 px-3 rounded-4 card-hover">
                <div class="card-body text-center">
                    <div class="d-inline-flex align-items-center justify-content-center bg-warning bg-opacity-10 text-warning rounded-circle mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-search fs-3"></i>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark">Direktori</h3>
                    <h6 class="text-uppercase text-muted fw-bold small tracking-wide">Pencarian Mudah</h6>
                    <p class="text-muted small mt-3 px-3">
                        Filter alumni berdasarkan angkatan, jurusan, atau tempat bekerja.
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>

@guest
<div class="container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h3 class="fw-bold text-dark">Belum Terdaftar?</h3>
            <p class="text-muted">Jadilah bagian dari ekosistem digital alumni UNS. Data Anda aman dan terverifikasi.</p>
            <a href="{{ route('register') }}" class="btn btn-outline-primary rounded-pill px-4">
                Daftar Sebagai Alumni <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</div>
@endguest

<style>
    .card-hover { transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .card-hover:hover { transform: translateY(-10px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
    .tracking-wide { letter-spacing: 1px; }
</style>

@endsection