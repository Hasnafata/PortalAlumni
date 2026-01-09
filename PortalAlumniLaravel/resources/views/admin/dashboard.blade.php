@extends('layouts.app')

@section('content')
<div class="container-fluid pb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Admin Dashboard</h2>
            <p class="text-muted mb-0">Kelola database alumni dan verifikasi pendaftaran akun baru.</p>
        </div>
        <div class="d-none d-md-block">
            <span class="text-muted small">Hari ini: <strong>{{ date('d M Y') }}</strong></span>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                        <i class="bi bi-people-fill text-primary fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Total Alumni</small>
                        <h4 class="fw-bold mb-0">{{ $alumni->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3">
                <div class="d-flex align-items-center">
                    <div class="bg-warning bg-opacity-10 p-3 rounded-3 me-3">
                        <i class="bi bi-hourglass-split text-warning fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Menunggu Verif</small>
                        <h4 class="fw-bold mb-0 text-warning">{{ $pending->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <ul class="nav nav-pills mb-4 bg-white p-2 rounded shadow-sm d-inline-flex" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active px-4 fw-600" id="verif-tab" data-bs-toggle="tab" data-bs-target="#verif" type="button" role="tab">
                <i class="bi bi-shield-check me-2"></i>Verifikasi & History
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link px-4 fw-600" id="master-tab" data-bs-toggle="tab" data-bs-target="#master" type="button" role="tab">
                <i class="bi bi-database me-2"></i>Master Data Alumni
            </button>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="verif" role="tabpanel">
            <div class="row">
                <div class="col-lg-8 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-clock-history me-2 text-warning"></i>Permintaan Pending</h5>
                            <span class="badge bg-warning text-dark">{{ $pending->count() }} Akun</span>
                        </div>
                        <div class="card-body p-0">
                            @if($pending->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="ps-4 border-0">User</th>
                                            <th class="border-0">NIM / Jurusan</th>
                                            <th class="border-0 text-end pe-4">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pending as $p)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center py-2">
                                                    @if($p->foto)
                                                        <img src="{{ asset('storage/' . $p->foto) }}" class="rounded-circle me-3" width="45" height="45" style="object-fit: cover; border: 2px solid #eee;">
                                                    @else
                                                        <div class="bg-light rounded-circle me-3 d-flex align-items-center justify-content-center text-muted" style="width: 45px; height: 45px;">
                                                            <i class="bi bi-person"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-0 fw-bold">{{ $p->name }}</h6>
                                                        <small class="text-muted">{{ $p->email }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark border fw-normal">{{ $p->nim }}</span>
                                                <div class="small text-muted mt-1">{{ $p->jurusan }}</div>
                                            </td>
                                            <td class="text-end pe-4">
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.edit', $p->id) }}" class="btn btn-sm btn-outline-secondary" title="Detail"><i class="bi bi-eye"></i></a>
                                                    <a href="{{ route('admin.status', [$p->id, 'verified']) }}" class="btn btn-sm btn-success" onclick="return confirm('ACC user ini?')" title="Setujui"><i class="bi bi-check-lg"></i></a>
                                                    <a href="{{ route('admin.status', [$p->id, 'rejected']) }}" class="btn btn-sm btn-danger" onclick="return confirm('Tolak user ini?')" title="Tolak"><i class="bi bi-x-lg"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="bi bi-check2-circle fs-1 text-muted"></i>
                                    <p class="text-muted mt-2">Tidak ada permintaan baru hari ini.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 fw-bold text-dark">📜 History Terbaru</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                @forelse($history as $h)
                                <div class="list-group-item py-3">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1 fw-bold">{{ Str::limit($h->name, 20) }}</h6>
                                        <small class="text-muted" style="font-size: 10px;">{{ $h->updated_at->diffForHumans() }}</small>
                                    </div>
                                    <div class="d-flex align-items-center mt-1">
                                        @if($h->status == 'verified')
                                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill small">Diterima</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill small">Ditolak</span>
                                        @endif
                                        <small class="text-muted ms-2">{{ $h->nim }}</small>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-4">
                                    <small class="text-muted">Belum ada riwayat aktivitas.</small>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="master" role="tabpanel">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="row g-3 mb-4 align-items-center">
                        <div class="col-md-4">
                            <a href="{{ route('admin.create') }}" class="btn btn-primary px-4"><i class="bi bi-plus-lg me-2"></i>Tambah Alumni</a>
                        </div>
                        <div class="col-md-8">
                            <form action="" method="GET">
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                                    <input type="text" name="search" class="form-control border-start-0" placeholder="Cari berdasarkan nama, NIM, atau jurusan..." value="{{ request('search') }}">
                                    <button class="btn btn-outline-primary px-4">Cari Data</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle border-top">
                            <thead class="bg-light text-muted small text-uppercase">
                                <tr>
                                    <th class="ps-3">Alumni</th>
                                    <th>Identitas</th>
                                    <th>Status Akun</th>
                                    <th class="text-end pe-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($alumni as $user)
                                <tr>
                                    <td class="ps-3">
                                        <div class="d-flex align-items-center">
                                            @if($user->foto)
                                                <img src="{{ asset('storage/' . $user->foto) }}" class="rounded me-3 shadow-sm" width="40" height="40" style="object-fit: cover;">
                                            @else
                                                <div class="bg-secondary bg-opacity-10 rounded me-3 d-flex align-items-center justify-content-center text-secondary" style="width: 40px; height: 40px;">
                                                    <i class="bi bi-person-fill"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-bold">{{ $user->name }}</div>
                                                <small class="text-muted">{{ $user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $user->nim }}</div>
                                        <div class="small text-secondary">{{ $user->jurusan }}</div>
                                    </td>
                                    <td>
                                        @if($user->status == 'verified') 
                                            <span class="badge bg-success rounded-pill px-3">Verified</span>
                                        @elseif($user->status == 'rejected') 
                                            <span class="badge bg-danger rounded-pill px-3">Rejected</span>
                                        @else 
                                            <span class="badge bg-warning text-dark rounded-pill px-3">Pending</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-3">
                                        <a href="{{ route('admin.edit', $user->id) }}" class="btn btn-light btn-sm text-warning" title="Edit"><i class="bi bi-pencil-square"></i></a>
                                        <a href="{{ route('admin.delete', $user->id) }}" class="btn btn-light btn-sm text-danger" onclick="return confirm('Hapus permanen?')" title="Hapus"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="bi bi-search fs-1 d-block mb-2"></i>
                                        Data alumni tidak ditemukan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .fw-600 { font-weight: 600; }
    .nav-pills .nav-link { color: #6c757d; border-radius: 8px; transition: all 0.3s; }
    .nav-pills .nav-link.active { background-color: #0d6efd; color: white; }
    .table thead th { font-weight: 600; font-size: 0.8rem; }
    .card { transition: transform 0.2s; }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Cek apakah ada parameter 'search' di URL
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('search')) {
            // Paksa pindah ke tab Master Data kalau lagi nyari
            var masterTab = new bootstrap.Tab(document.querySelector('#master-tab'));
            masterTab.show();
        }
    });
</script>
@endsection