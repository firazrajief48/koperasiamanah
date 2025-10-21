@extends('layouts.dashboard')

@section('title', 'Profile Administrator')
@section('page-title', 'Profile Administrator')

@php
    $role = 'Administrator';
    $nama = auth()->user()->name;
    $routePrefix = 'administrator';
@endphp

@section('main-content')
<style>
    /* ==================== VARIABEL WARNA ==================== */
    :root {
        --primary-blue: #1e40af;
        --primary-light: #3b82f6;
        --accent-orange: #f97316;
        --accent-yellow: #fbbf24;
        --dark-navy: #0f172a;
        --gray-100: #f1f5f9;
        --gray-200: #e2e8f0;
        --success-green: #10b981;
        --purple: #8b5cf6;
        --pink: #ec4899;
    }

    /* ==================== STYLING DASAR ==================== */
    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        background: linear-gradient(135deg, #f0f9ff 0%, #e0e7ff 100%);
        min-height: 100vh;
    }

    /* Profile Cards */
    .profile-card {
        background: white;
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .profile-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #dc2626, #ef4444);
    }

    .profile-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }

    .profile-avatar {
        width: 80px;
        height: 80px;
        border-radius: 20px;
        background: linear-gradient(135deg, #dc2626, #ef4444);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
        margin: 0 auto 1rem;
    }

    .action-btn {
        background: linear-gradient(135deg, var(--primary-blue), var(--primary-light));
        border: none;
        border-radius: 15px;
        padding: 1rem 1.5rem;
        color: white;
        font-weight: 600;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(30, 64, 175, 0.3);
    }

    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(30, 64, 175, 0.4);
        color: white;
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in-up {
        animation: fadeInUp 0.6s ease-out;
    }
</style>

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: var(--dark-navy);">
                <i class="bi bi-person-gear me-2"></i>Profile Administrator
            </h2>
            <p class="text-muted mb-0">Kelola informasi profile administrator</p>
        </div>
        <span class="badge bg-danger fs-6 px-3 py-2">
            <i class="bi bi-shield-check me-1"></i>Administrator
        </span>
    </div>

    <div class="row g-4">
    <!-- Profile Info -->
    <div class="col-lg-4">
        <div class="profile-card fade-in-up" style="animation-delay: 0.1s;">
            <div class="text-center">
                <div class="profile-avatar">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h4 class="fw-bold mb-1" style="color: var(--dark-navy);">{{ auth()->user()->name }}</h4>
                <p class="text-muted mb-3">{{ auth()->user()->email }}</p>
                <span class="badge bg-danger px-3 py-2">
                    <i class="bi bi-shield-check me-1"></i>Administrator
                </span>
            </div>
        </div>
    </div>

        <!-- Profile Details -->
        <div class="col-lg-8">
            <div class="profile-card fade-in-up" style="animation-delay: 0.2s;">
                <h5 class="fw-bold mb-4" style="color: var(--dark-navy);">
                    <i class="bi bi-info-circle me-2"></i>Detail Profile
                </h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">Nama Lengkap</label>
                            <p class="fw-semibold">{{ auth()->user()->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">Email</label>
                            <p class="fw-semibold">{{ auth()->user()->email }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">Role</label>
                            <p class="fw-semibold">
                                <span class="badge bg-danger px-3 py-2">
                                    <i class="bi bi-shield-check me-1"></i>Administrator
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">NIP</label>
                            <p class="fw-semibold">{{ auth()->user()->nip ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">Golongan</label>
                            <p class="fw-semibold">{{ auth()->user()->golongan ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">Jabatan</label>
                            <p class="fw-semibold">{{ auth()->user()->jabatan ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">No HP</label>
                            <p class="fw-semibold">{{ auth()->user()->phone ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">Bergabung</label>
                            <p class="fw-semibold">{{ auth()->user()->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-4 mt-2">
        <div class="col-12">
            <div class="profile-card fade-in-up" style="animation-delay: 0.3s;">
                <h5 class="fw-bold mb-4" style="color: var(--dark-navy);">
                    <i class="bi bi-lightning-fill me-2"></i>Aksi Cepat
                </h5>
                <div class="row g-3">
                    <div class="col-md-3">
                        <a href="{{ route('administrator.kelola-user') }}" class="action-btn w-100">
                            <i class="bi bi-people"></i>
                            <span>Kelola User</span>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('administrator.tambah-user') }}" class="action-btn w-100" style="background: linear-gradient(135deg, #10b981, #059669);">
                            <i class="bi bi-person-plus"></i>
                            <span>Tambah User</span>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('administrator.laporan-user') }}" class="action-btn w-100" style="background: linear-gradient(135deg, #06b6d4, #0891b2);">
                            <i class="bi bi-graph-up"></i>
                            <span>Laporan User</span>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('administrator.dashboard') }}" class="action-btn w-100" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                            <i class="bi bi-house"></i>
                            <span>Dashboard</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
