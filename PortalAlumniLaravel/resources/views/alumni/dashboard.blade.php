@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow border-0">
            <div class="card-body text-center p-5">
                
                @if($user->foto)
                    <img src="{{ asset('storage/' . $user->foto) }}" 
                         alt="Foto Profil" 
                         class="rounded-circle shadow mb-3" 
                         style="width: 150px; height: 150px; object-fit: cover; border: 4px solid white;">
                @else
                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3 shadow" 
                         style="width: 150px; height: 150px; font-size: 4rem; color: white;">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                @endif

                <h2 class="fw-bold mb-1">{{ $user->name }}</h2>
                <p class="text-muted fs-5 mb-2">{{ $user->pekerjaan ?? 'Belum mengisi pekerjaan' }}</p>

                <div class="mb-3">
                    @if($user->status == 'verified')
                        <span class="badge bg-success rounded-pill px-3">✔ Terverifikasi</span>
                    @elseif($user->status == 'rejected')
                        <span class="badge bg-danger rounded-pill px-3">✖ Ditolak Admin</span>
                    @else
                        <span class="badge bg-warning text-dark rounded-pill px-3">⏳ Menunggu Verifikasi</span>
                    @endif
                </div>

                @if($user->status == 'verified')
                <div class="mt-3">
                    <a href="{{ route('alumni.list') }}" class="btn btn-uns rounded-pill px-4 shadow-sm">
                        <i class="bi bi-people-fill me-2"></i>Lihat Daftar Alumni
                    </a>
                </div>
                @endif
                
                <div class="mt-4 px-4">
                    <p class="fst-italic text-secondary">"{{ $user->bio ?? 'Tidak ada deskripsi diri.' }}"</p>
                </div>
            </div>

            <div class="card-footer bg-light p-4">
                <div class="row text-center">
                    <div class="col-md-4 mb-3">
                        <small class="text-muted d-block fw-bold">NIM</small>
                        <span>{{ $user->nim }}</span>
                    </div>
                    <div class="col-md-4 mb-3">
                        <small class="text-muted d-block fw-bold">JURUSAN</small>
                        <span>{{ $user->jurusan }}</span>
                    </div>
                    <div class="col-md-4 mb-3">
                        <small class="text-muted d-block fw-bold">ANGKATAN</small>
                        <span>{{ $user->angkatan }}</span>
                    </div>
                </div>
                <div class="text-center mt-2">
                     <small class="text-muted d-block fw-bold">EMAIL</small>
                     <span>{{ $user->email }}</span>
                </div>
            </div>

            @if($user->status == 'pending')
                <div class="alert alert-info m-3 text-center">
                    <i class="bi bi-info-circle me-2"></i> Data Anda sedang diperiksa oleh Admin. Mohon tunggu 1x24 jam.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection