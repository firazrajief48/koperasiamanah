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
    <style>
        :root {
            --primary-blue: #1e40af;
            --primary-light: #3b82f6;
            --dark-navy: #0f172a;
        }

        .page-header-modern {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #6366f1 100%);
            border-radius: 20px;
            padding: 1.25rem 1.5rem;
            margin-bottom: 1.25rem;
            color: white;
            box-shadow: 0 10px 30px rgba(30, 64, 175, 0.15);
        }

        .icon-box {
            width: 80px; height: 80px;
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            display: flex; align-items: center; justify-content: center;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(59, 130, 246, .25);
        }

        .card[style*="border-radius"] { border-radius: 20px !important; }
        .card-header { background: linear-gradient(135deg, rgba(30,64,175,.06), rgba(99,102,241,.06)); border: none; }
        .badge { border-radius: 999px; font-weight: 600; }
        .btn-gradient {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            color: #fff; border: none;
        }
        .btn-gradient:hover { filter: brightness(1.05); }
    </style>
    <!-- Header -->
    <div class="page-header-modern d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <div class="icon-box" style="width:48px;height:48px;border-radius:12px;">
                <i class="bi bi-person text-white"></i>
            </div>
            <div>
                <h2 class="fw-bold mb-0">Detail User</h2>
                <small class="opacity-75">Informasi lengkap user {{ $user->name }}</small>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('administrator.edit-user', $user->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-1"></i>Edit
            </a>
            <a href="{{ route('administrator.kelola-user') }}" class="btn btn-outline-light">
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
                    <div class="icon-box mx-auto mb-3">
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

    <!-- Actions removed as requested -->
</div>
@endsection
