@extends('layouts.dashboard')

@section('title', 'Detail User')
@section('page-title', 'Detail User')

@php
    $role = 'Administrator';
    $nama = auth()->user()->name;
    $routePrefix = 'administrator';
    $showLaporan = true;
@endphp

@section('main-content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: var(--dark-navy);">
                <i class="bi bi-person me-2"></i>Detail User
            </h2>
            <p class="text-muted mb-0">Informasi lengkap user {{ $user->name }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('administrator.edit-user', $user->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-1"></i>Edit
            </a>
            <a href="{{ route('administrator.kelola-user') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>

    <div class="row g-4">
        <!-- User Info -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-header bg-transparent border-0 p-4">
                    <h5 class="fw-bold mb-0" style="color: var(--dark-navy);">
                        <i class="bi bi-person-circle me-2"></i>Informasi User
                    </h5>
                </div>
                <div class="card-body p-4 text-center">
                    <div class="icon-box mx-auto mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-person-fill text-white fs-2"></i>
                    </div>
                    <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                    <p class="text-muted mb-3">{{ $user->email }}</p>
                    @php
                        $roleColors = [
                            'peminjam' => 'bg-primary',
                            'kepala_bps' => 'bg-info',
                            'bendahara_koperasi' => 'bg-success',
                            'ketua_koperasi' => 'bg-warning',
                            'administrator' => 'bg-danger'
                        ];
                    @endphp
                    <span class="badge {{ $roleColors[$user->role] ?? 'bg-secondary' }} px-3 py-2">
                        {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- User Details -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-header bg-transparent border-0 p-4">
                    <h5 class="fw-bold mb-0" style="color: var(--dark-navy);">
                        <i class="bi bi-info-circle me-2"></i>Detail Lengkap
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">ID User</label>
                            <p class="fw-semibold">{{ $user->id }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">Email</label>
                            <p class="fw-semibold">{{ $user->email }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">Nama Lengkap</label>
                            <p class="fw-semibold">{{ $user->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">Role</label>
                            <p class="fw-semibold">
                                <span class="badge {{ $roleColors[$user->role] ?? 'bg-secondary' }} px-3 py-2">
                                    {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">NIP</label>
                            <p class="fw-semibold">{{ $user->nip ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">Golongan</label>
                            <p class="fw-semibold">{{ $user->golongan ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">Jabatan</label>
                            <p class="fw-semibold">{{ $user->jabatan ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">No HP</label>
                            <p class="fw-semibold">{{ $user->phone ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">Bergabung</label>
                            <p class="fw-semibold">{{ $user->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">Terakhir Update</label>
                            <p class="fw-semibold">{{ $user->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="row g-4 mt-2">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-header bg-transparent border-0 p-4">
                    <h5 class="fw-bold mb-0" style="color: var(--dark-navy);">
                        <i class="bi bi-gear me-2"></i>Aksi
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex gap-3">
                        <a href="{{ route('administrator.edit-user', $user->id) }}" class="btn btn-warning px-4 py-2">
                            <i class="bi bi-pencil me-1"></i>Edit User
                        </a>
                        @if($user->id !== auth()->id())
                        <form action="{{ route('administrator.delete-user', $user->id) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin hapus user {{ $user->name }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger px-4 py-2">
                                <i class="bi bi-trash me-1"></i>Hapus User
                            </button>
                        </form>
                        @endif
                        <a href="{{ route('administrator.kelola-user') }}" class="btn btn-outline-secondary px-4 py-2">
                            <i class="bi bi-arrow-left me-1"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
