@extends('layouts.dashboard')

@section('title', 'Dashboard Administrator')
@section('page-title', 'Dashboard Administrator')

@php
    $role = 'Administrator';
    $nama = auth()->user()->name;
    $routePrefix = 'administrator';
    $showLaporan = true;
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

    /* Welcome Banner */
    .welcome-banner {
        background: linear-gradient(135deg, #dc2626 0%, #ef4444 50%, #f87171 100%);
        border-radius: 20px;
        padding: 1.5rem 2rem;
        margin-bottom: 1.5rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(220, 38, 38, 0.2);
        animation: slideDown 0.6s ease-out;
    }

    .welcome-banner::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        opacity: 0.3;
    }

    .welcome-content {
        position: relative;
        z-index: 2;
        color: white;
    }

    .welcome-title {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .welcome-subtitle {
        font-size: 1rem;
        opacity: 0.9;
        margin-bottom: 0;
    }

    /* Stats Cards */
    .stats-card {
        background: white;
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-blue), var(--primary-light));
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }

    .stats-icon {
        width: 60px;
        height: 60px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        margin-bottom: 1rem;
    }

    .stats-number {
        font-size: 2rem;
        font-weight: 700;
        color: var(--dark-navy);
        margin-bottom: 0.25rem;
    }

    .stats-label {
        color: #64748b;
        font-size: 0.875rem;
        font-weight: 500;
    }

    /* Quick Actions */
    .quick-actions {
        background: white;
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.2);
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
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

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
    <!-- Welcome Banner -->
    <div class="welcome-banner fade-in-up">
        <div class="welcome-content">
            <h1 class="welcome-title">
                <i class="bi bi-shield-check me-2"></i>Selamat Datang, {{ $nama }}!
            </h1>
            <p class="welcome-subtitle">
                Kelola semua user dan sistem koperasi dengan mudah dan aman
            </p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="stats-card fade-in-up" style="animation-delay: 0.1s;">
                <div class="stats-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div class="stats-number">{{ $stats['total_users'] }}</div>
                <div class="stats-label">Total User</div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stats-card fade-in-up" style="animation-delay: 0.2s;">
                <div class="stats-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <i class="bi bi-person-check-fill"></i>
                </div>
                <div class="stats-number">{{ $stats['total_anggota'] }}</div>
                <div class="stats-label">Anggota</div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stats-card fade-in-up" style="animation-delay: 0.3s;">
                <div class="stats-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <i class="bi bi-person-badge-fill"></i>
                </div>
                <div class="stats-number">{{ $stats['total_admin'] }}</div>
                <div class="stats-label">Admin</div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stats-card fade-in-up" style="animation-delay: 0.4s;">
                <div class="stats-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                    <i class="bi bi-person-plus-fill"></i>
                </div>
                <div class="stats-number">{{ $stats['new_users_this_month'] }}</div>
                <div class="stats-label">User Baru Bulan Ini</div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="quick-actions fade-in-up" style="animation-delay: 0.5s;">
                <h5 class="fw-bold mb-4" style="color: var(--dark-navy);">
                    <i class="bi bi-lightning-fill me-2"></i>Aksi Cepat
                </h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <a href="{{ route('administrator.kelola-user') }}" class="action-btn w-100">
                            <i class="bi bi-people"></i>
                            <span>Kelola User</span>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('administrator.tambah-user') }}" class="action-btn w-100" style="background: linear-gradient(135deg, #10b981, #059669);">
                            <i class="bi bi-person-plus"></i>
                            <span>Tambah User</span>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('administrator.laporan-user') }}" class="action-btn w-100" style="background: linear-gradient(135deg, #06b6d4, #0891b2);">
                            <i class="bi bi-graph-up"></i>
                            <span>Laporan User</span>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('administrator.profile') }}" class="action-btn w-100" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                            <i class="bi bi-person-gear"></i>
                            <span>Profile Admin</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="stats-card fade-in-up" style="animation-delay: 0.6s;">
                <h5 class="fw-bold mb-4" style="color: var(--dark-navy);">
                    <i class="bi bi-clock-history me-2"></i>User Terbaru
                </h5>
                @if($recent_users->count() > 0)
                    @foreach($recent_users as $user)
                    <div class="d-flex align-items-center mb-3">
                        <div class="stats-icon me-3" style="width: 40px; height: 40px; font-size: 1rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0 fw-semibold" style="color: var(--dark-navy);">{{ $user->name }}</h6>
                            <small class="text-muted">{{ ucfirst(str_replace('_', ' ', $user->role)) }}</small>
                        </div>
                        <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                    </div>
                    @endforeach
                @else
                    <p class="text-muted text-center">Belum ada user</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Role Distribution -->
    <div class="row g-4">
        <div class="col-12">
            <div class="stats-card fade-in-up" style="animation-delay: 0.7s;">
                <h5 class="fw-bold mb-4" style="color: var(--dark-navy);">
                    <i class="bi bi-pie-chart me-2"></i>Distribusi Role User
                </h5>
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="text-center p-4 rounded" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px !important;">
                            <h3 class="fw-bold mb-2">{{ $stats['total_anggota'] }}</h3>
                            <p class="mb-0">Anggota</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-4 rounded" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; border-radius: 15px !important;">
                            <h3 class="fw-bold mb-2">{{ $stats['total_admin'] }}</h3>
                            <p class="mb-0">Admin</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-4 rounded" style="background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%); color: white; border-radius: 15px !important;">
                            <h3 class="fw-bold mb-2">1</h3>
                            <p class="mb-0">Administrator</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-4 rounded" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; border-radius: 15px !important;">
                            <h3 class="fw-bold mb-2">{{ $stats['total_users'] }}</h3>
                            <p class="mb-0">Total</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
