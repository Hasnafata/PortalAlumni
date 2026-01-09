@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow border-0">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0 fw-bold">➕ Tambah Alumni Baru</h5>
            </div>
            <div class="card-body p-4">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>⚠ {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="fw-bold">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="fw-bold">NIM</label>
                            <input type="text" name="nim" class="form-control" value="{{ old('nim') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="fw-bold">Jurusan</label>
                            <input type="text" name="jurusan" class="form-control" value="{{ old('jurusan') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold">Angkatan</label>
                            <input type="number" name="angkatan" class="form-control" value="{{ old('angkatan') }}" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="fw-bold">Password Default</label>
                        <input type="password" name="password" class="form-control" required placeholder="Min 8 karakter & ada angka">
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Batal</a>
                        <button class="btn btn-success px-4">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection