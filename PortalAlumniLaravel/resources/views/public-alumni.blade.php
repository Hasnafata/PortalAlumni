@extends('layouts.app')

@section('content')
<div class="container py-5">
    
    <div class="row justify-content-center mb-5">
        <div class="col-lg-8 text-center">
            <h2 class="fw-bold text-dark mb-2">Direktori Alumni</h2>
            <p class="text-muted mb-4">Temukan rekan seangkatan dan perluas jaringan profesionalmu.</p>
            
            <form action="{{ route('alumni.list') }}" method="GET">
                <div class="input-group shadow-sm border rounded-pill overflow-hidden bg-white p-1">
                    <span class="input-group-text border-0 bg-white ps-4">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-0 shadow-none ps-2" 
                           placeholder="Cari berdasarkan Nama, Jurusan, atau Angkatan..." 
                           value="{{ request('search') }}" style="font-size: 1rem;">
                    <button class="btn btn-primary rounded-pill px-4 fw-bold">Cari Alumni</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-4">
        @forelse($alumni as $user)
        <div class="col-md-6 col-lg-3">
            
            <div class="card h-100 border-0 shadow-sm rounded-4 text-center alumni-card position-relative bg-white" 
                 data-bs-toggle="modal" data-bs-target="#alumniModal-{{ $user->id }}">
                
                <div class="card-body p-4 d-flex flex-column align-items-center">
                    
                    <div class="mb-3">
                        @if($user->foto)
                            <img src="{{ asset('storage/' . $user->foto) }}" class="rounded-circle shadow-sm border border-3 border-light" 
                                 style="width: 110px; height: 110px; object-fit: cover;">
                        @else
                            <div class="avatar-placeholder rounded-circle shadow-sm d-flex align-items-center justify-content-center text-primary fw-bold fs-2 border border-3 border-light" 
                                 style="width: 110px; height: 110px; background-color: #eef5fa;">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                    </div>

                    <h5 class="fw-bold text-dark mb-1 text-truncate w-100" title="{{ $user->name }}">
                        {{ $user->name }}
                        <i class="bi bi-patch-check-fill text-primary small ms-1" style="font-size: 0.8rem;" title="Terverifikasi"></i>
                    </h5>
                    
                    <p class="text-muted small mb-3 fst-italic text-truncate w-100">
                        <i class="bi bi-briefcase me-1"></i> {{ $user->pekerjaan ?? '-' }}
                    </p>

                    <div class="w-25 border-top border-2 border-primary opacity-25 mb-3"></div>

                    <div class="mt-auto w-100">
                        <span class="badge bg-light text-primary border border-primary border-opacity-10 rounded-pill px-3 py-2 mb-2 d-block text-truncate">
                            <i class="bi bi-mortarboard-fill me-1"></i> {{ $user->jurusan }}
                        </span>
                        <span class="badge bg-white text-secondary border rounded-pill px-3 py-1 small">
                            Angkatan {{ $user->angkatan }}
                        </span>
                    </div>
                </div>
                
                <div class="card-footer bg-transparent border-0 pb-3 pt-0 text-primary opacity-0 hover-show transition-all">
                    <small class="fw-bold">Lihat Profil <i class="bi bi-arrow-right"></i></small>
                </div>
            </div>

            <div class="modal fade" id="alumniModal-{{ $user->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content border-0 shadow rounded-4 overflow-hidden">
                        <div class="modal-header bg-primary text-white border-0 px-4 py-3">
                            <h5 class="modal-title fw-bold"><i class="bi bi-person-lines-fill me-2"></i> Detail Alumni</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-0">
                            <div class="row g-0">
                                <div class="col-md-5 bg-light p-4 text-center border-end">
                                    @if($user->foto)
                                        <img src="{{ asset('storage/' . $user->foto) }}" class="rounded-circle shadow mb-3" 
                                             style="width: 150px; height: 150px; object-fit: cover;">
                                    @else
                                        <div class="rounded-circle bg-white shadow mb-3 d-flex align-items-center justify-content-center mx-auto text-primary fw-bold" 
                                             style="width: 150px; height: 150px; font-size: 4rem;">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                    @endif
                                    
                                    <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                                    <span class="badge bg-success mb-3"><i class="bi bi-check-circle-fill me-1"></i> Alumni Terverifikasi</span>
                                    
                                    <div class="d-grid gap-2 mt-3">
                                        <a href="mailto:{{ $user->email }}" class="btn btn-outline-primary btn-sm rounded-pill">
                                            <i class="bi bi-envelope-fill me-2"></i> Kirim Email
                                        </a>
                                    </div>
                                </div>

                                <div class="col-md-7 p-4">
                                    <h6 class="text-uppercase text-muted fw-bold small mb-3">Informasi Akademik</h6>
                                    <div class="row mb-4">
                                        <div class="col-6">
                                            <small class="text-muted d-block">Jurusan</small>
                                            <span class="fw-bold text-dark">{{ $user->jurusan }}</span>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted d-block">Angkatan</small>
                                            <span class="fw-bold text-dark">{{ $user->angkatan }}</span>
                                        </div>
                                    </div>

                                    <h6 class="text-uppercase text-muted fw-bold small mb-3">Informasi Karir</h6>
                                    <div class="mb-4">
                                        <small class="text-muted d-block">Pekerjaan Saat Ini</small>
                                        <span class="fw-bold text-dark fs-5">{{ $user->pekerjaan ?? '-' }}</span>
                                    </div>

                                    <h6 class="text-uppercase text-muted fw-bold small mb-2">Tentang Saya</h6>
                                    <div class="p-3 bg-light rounded border border-light">
                                        <p class="text-secondary fst-italic mb-0 small">
                                            "{{ $user->bio ?? 'Alumni ini belum menuliskan deskripsi diri.' }}"
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="mb-3">
                <i class="bi bi-search text-muted opacity-25" style="font-size: 5rem;"></i>
            </div>
            <h4 class="text-dark fw-bold">Alumni tidak ditemukan</h4>
            <p class="text-muted">Coba gunakan kata kunci pencarian yang lain.</p>
            <a href="{{ route('alumni.list') }}" class="btn btn-outline-primary rounded-pill mt-2">Reset Pencarian</a>
        </div>
        @endforelse
    </div>

</div>

<style>
    .alumni-card {
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .alumni-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.08) !important;
        border-color: rgba(0,118,189, 0.2) !important;
    }

    .alumni-card:hover .hover-show {
        opacity: 1 !important;
    }
    
    .avatar-placeholder {
        background: linear-gradient(135deg, #f0f4f8 0%, #d9e2ec 100%);
    }
</style>
@endsection