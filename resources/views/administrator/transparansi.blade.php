@extends('layouts.dashboard')

@section('title', 'Transparansi Keuangan')
@section('page-title', 'Transparansi Keuangan')

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
                <i class="bi bi-eye me-2"></i>Transparansi Keuangan
            </h2>
            <p class="text-muted mb-0">Informasi transparansi keuangan sistem koperasi</p>
        </div>
        <span class="badge bg-danger fs-6 px-3 py-2">
            <i class="bi bi-shield-check me-1"></i>Administrator
        </span>
    </div>

    <!-- Financial Overview -->
    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="icon-box me-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <i class="bi bi-people-fill text-white fs-4"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0" style="color: var(--dark-navy);">{{ \App\Models\User::where('role', 'peminjam')->count() }}</h3>
                            <p class="text-muted mb-0">Total Anggota</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="icon-box me-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                            <i class="bi bi-cash-stack text-white fs-4"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0" style="color: var(--dark-navy);">Rp 0</h3>
                            <p class="text-muted mb-0">Total Simpanan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="icon-box me-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                            <i class="bi bi-credit-card text-white fs-4"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0" style="color: var(--dark-navy);">Rp 0</h3>
                            <p class="text-muted mb-0">Total Pinjaman</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="icon-box me-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                            <i class="bi bi-graph-up text-white fs-4"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0" style="color: var(--dark-navy);">Rp 0</h3>
                            <p class="text-muted mb-0">Keuntungan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- System Information -->
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-header bg-transparent border-0 p-4">
                    <h5 class="fw-bold mb-0" style="color: var(--dark-navy);">
                        <i class="bi bi-info-circle me-2"></i>Informasi Sistem
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold text-muted">Nama Koperasi</label>
                            <p class="fw-semibold">Koperasi Amanah BPS Kota Surabaya</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">Alamat</label>
                            <p class="fw-semibold">Kota Surabaya, Jawa Timur</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">Status</label>
                            <p class="fw-semibold">
                                <span class="badge bg-success px-3 py-2">Aktif</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">Tanggal Berdiri</label>
                            <p class="fw-semibold">2025</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">Badan Hukum</label>
                            <p class="fw-semibold">Dalam Proses</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-header bg-transparent border-0 p-4">
                    <h5 class="fw-bold mb-0" style="color: var(--dark-navy);">
                        <i class="bi bi-shield-check me-2"></i>Keamanan Sistem
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold text-muted">Status Keamanan</label>
                            <p class="fw-semibold">
                                <span class="badge bg-success px-3 py-2">
                                    <i class="bi bi-shield-check me-1"></i>Aman
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">Enkripsi Data</label>
                            <p class="fw-semibold">
                                <span class="badge bg-primary px-3 py-2">Aktif</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">Backup Data</label>
                            <p class="fw-semibold">
                                <span class="badge bg-info px-3 py-2">Otomatis</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">Monitoring</label>
                            <p class="fw-semibold">
                                <span class="badge bg-warning px-3 py-2">24/7</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">Update Terakhir</label>
                            <p class="fw-semibold">{{ now()->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-4 mt-2">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-header bg-transparent border-0 p-4">
                    <h5 class="fw-bold mb-0" style="color: var(--dark-navy);">
                        <i class="bi bi-lightning-fill me-2"></i>Aksi Cepat
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="{{ route('administrator.kelola-user') }}" class="btn btn-primary w-100 py-3 rounded-pill">
                                <i class="bi bi-people me-2"></i>Kelola User
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('administrator.laporan-user') }}" class="btn btn-info w-100 py-3 rounded-pill">
                                <i class="bi bi-graph-up me-2"></i>Laporan User
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('administrator.dashboard') }}" class="btn btn-warning w-100 py-3 rounded-pill">
                                <i class="bi bi-house me-2"></i>Dashboard
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('administrator.profile') }}" class="btn btn-success w-100 py-3 rounded-pill">
                                <i class="bi bi-person-gear me-2"></i>Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
