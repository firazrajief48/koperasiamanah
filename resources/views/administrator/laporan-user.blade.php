@extends('layouts.dashboard')

@section('title', 'Laporan User')
@section('page-title', 'Laporan User')

@php
    $role = 'Administrator';
    $nama = auth()->user()->name;
    $routePrefix = 'administrator';
    $showLaporan = true;
@endphp

@section('main-content')
<style>
    .stats-card {
        background: white;
        border-radius: 20px;
        border: 1px solid rgba(37, 99, 235, 0.08);
        box-shadow: 0 10px 40px rgba(37, 99, 235, 0.08);
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        height: 100%;
    }

    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #2563eb, #60a5fa);
        background-size: 300% 100%;
        animation: gradientShift 3s ease infinite;
    }

    .stats-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 60px rgba(37, 99, 235, 0.15);
        border-color: rgba(37, 99, 235, 0.2);
    }

    @keyframes gradientShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    .stats-icon {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
    }

    .stats-icon::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.6s ease;
    }

    .stats-icon:hover::before {
        left: 100%;
    }

    .stats-card:hover .stats-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .stats-number {
        font-size: 2rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0;
        line-height: 1;
    }

    .stats-label {
        color: #64748b;
        font-size: 0.9rem;
        font-weight: 500;
        margin-bottom: 0;
        margin-top: 0.5rem;
    }

    .admin-card {
        background: white;
        border-radius: 24px;
        border: 1px solid rgba(37, 99, 235, 0.08);
        box-shadow: 0 10px 40px rgba(37, 99, 235, 0.08);
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        backdrop-filter: blur(10px);
        height: 100%;
    }

    .admin-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #2563eb, #60a5fa, #f59e0b, #10b981);
        background-size: 300% 100%;
        animation: gradientShift 3s ease infinite;
    }

    .admin-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 60px rgba(37, 99, 235, 0.15);
        border-color: rgba(37, 99, 235, 0.2);
    }

    .admin-card-header {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-bottom: 1px solid rgba(37, 99, 235, 0.1);
        border-radius: 24px 24px 0 0;
        padding: 1.5rem 2rem;
    }

    .admin-card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }

    .admin-card-body {
        padding: 2rem;
    }

    .role-item {
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.03) 0%, rgba(96, 165, 250, 0.03) 100%);
        border-radius: 16px;
        padding: 1rem 1.5rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
        border: 1px solid rgba(37, 99, 235, 0.08);
        animation: fadeInUp 0.6s ease-out both;
    }

    .role-item:hover {
        transform: translateX(10px) scale(1.02);
        box-shadow: 0 8px 24px rgba(37, 99, 235, 0.12);
        border-color: rgba(37, 99, 235, 0.15);
    }

    .role-item:nth-child(1) { animation-delay: 0.1s; }
    .role-item:nth-child(2) { animation-delay: 0.2s; }
    .role-item:nth-child(3) { animation-delay: 0.3s; }
    .role-item:nth-child(4) { animation-delay: 0.4s; }
    .role-item:nth-child(5) { animation-delay: 0.5s; }

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

    .badge-role {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
        border: 1px solid;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .badge-role::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }

    .badge-role:hover::before {
        left: 100%;
    }

    .badge-role:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
    }

    .badge-role.bg-primary {
        background: linear-gradient(135deg, #2563eb 0%, #60a5fa 100%);
        color: white;
        border-color: rgba(37, 99, 235, 0.3);
    }

    .badge-role.bg-info {
        background: linear-gradient(135deg, #06b6d4 0%, #67e8f9 100%);
        color: white;
        border-color: rgba(6, 182, 212, 0.3);
    }

    .badge-role.bg-success {
        background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        color: white;
        border-color: rgba(16, 185, 129, 0.3);
    }

    .badge-role.bg-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
        color: white;
        border-color: rgba(245, 158, 11, 0.3);
    }

    .badge-role.bg-danger {
        background: linear-gradient(135deg, #ef4444 0%, #f87171 100%);
        color: white;
        border-color: rgba(239, 68, 68, 0.3);
    }

    .month-item {
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.03) 0%, rgba(96, 165, 250, 0.03) 100%);
        border-radius: 16px;
        padding: 1rem 1.5rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
        border: 1px solid rgba(37, 99, 235, 0.08);
        animation: fadeInUp 0.6s ease-out both;
    }

    .month-item:hover {
        transform: translateX(10px) scale(1.02);
        box-shadow: 0 8px 24px rgba(37, 99, 235, 0.12);
        border-color: rgba(37, 99, 235, 0.15);
    }

    .detail-stat-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        text-align: center;
        transition: all 0.4s ease;
        border: 2px solid transparent;
        position: relative;
        overflow: hidden;
        animation: fadeInUp 0.6s ease-out both;
    }

    .detail-stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(96, 165, 250, 0.1) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .detail-stat-card:hover::before {
        opacity: 1;
    }

    .detail-stat-card:hover {
        transform: translateY(-10px) scale(1.05);
        box-shadow: 0 20px 40px rgba(37, 99, 235, 0.2);
        border-color: rgba(37, 99, 235, 0.3);
    }

    .detail-stat-card:nth-child(1) { animation-delay: 0.1s; }
    .detail-stat-card:nth-child(2) { animation-delay: 0.2s; }
    .detail-stat-card:nth-child(3) { animation-delay: 0.3s; }
    .detail-stat-card:nth-child(4) { animation-delay: 0.4s; }
    .detail-stat-card:nth-child(5) { animation-delay: 0.5s; }

    .detail-stat-number {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 1rem;
        background: linear-gradient(135deg, #2563eb 0%, #60a5fa 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        line-height: 1;
        position: relative;
        z-index: 1;
    }

    .detail-stat-label {
        font-size: 1rem;
        font-weight: 600;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        position: relative;
        z-index: 1;
    }

    .btn-back-admin {
        background: linear-gradient(135deg, #64748b 0%, #94a3b8 100%);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border-radius: 16px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 6px 20px rgba(100, 116, 139, 0.3);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        position: relative;
        overflow: hidden;
    }

    .btn-back-admin::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.6s ease;
    }

    .btn-back-admin:hover::before {
        left: 100%;
    }

    .btn-back-admin:hover {
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 12px 32px rgba(100, 116, 139, 0.5);
        background: linear-gradient(135deg, #94a3b8 0%, #64748b 100%);
        color: white;
    }

    .page-header {
        margin-bottom: 2rem;
        animation: slideInDown 0.6s ease-out;
    }

    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .page-title {
        font-size: 2rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 0.5rem;
    }

    .page-subtitle {
        color: #64748b;
        font-size: 1rem;
        margin-bottom: 0;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: #64748b;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        color: #cbd5e1;
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    .empty-state h5 {
        color: #475569;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }

    .empty-state p {
        margin-bottom: 0;
        color: #64748b;
    }

    @media (max-width: 768px) {
        .stats-icon {
            width: 50px;
            height: 50px;
            font-size: 1.25rem;
        }

        .stats-number {
            font-size: 1.5rem;
        }

        .stats-label {
            font-size: 0.8rem;
        }

        .admin-card-body {
            padding: 1rem;
        }

        .role-item,
        .month-item {
            padding: 0.75rem 1rem;
        }

        .detail-stat-card {
            padding: 1.5rem 1rem;
        }

        .detail-stat-number {
            font-size: 2rem;
        }

        .detail-stat-label {
            font-size: 0.85rem;
        }

        .page-title {
            font-size: 1.5rem;
        }
    }
</style>

<div class="container-fluid">
    <!-- Header -->
    <div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
        <div>
            <h2 class="page-title">
                <i class="bi bi-graph-up me-2"></i>Laporan User
            </h2>
            <p class="page-subtitle">Statistik dan analisis data user sistem koperasi</p>
        </div>
        <a href="{{ route('administrator.kelola-user') }}" class="btn-back-admin">
            <i class="bi bi-arrow-left"></i>Kembali
        </a>
    </div>

    <!-- Stats Overview -->
    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stats-icon" style="background: linear-gradient(135deg, #2563eb 0%, #60a5fa 100%);">
                            <i class="bi bi-people-fill text-white"></i>
                        </div>
                        <div>
                            <h3 class="stats-number">{{ $users_by_role->sum('total') }}</h3>
                            <p class="stats-label">Total User</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stats-icon" style="background: linear-gradient(135deg, #8b5cf6 0%, #ec4899 100%);">
                            <i class="bi bi-person-check-fill text-white"></i>
                        </div>
                        <div>
                            <h3 class="stats-number">{{ $users_by_role->where('role', 'peminjam')->first()->total ?? 0 }}</h3>
                            <p class="stats-label">Anggota</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stats-icon" style="background: linear-gradient(135deg, #06b6d4 0%, #67e8f9 100%);">
                            <i class="bi bi-person-badge-fill text-white"></i>
                        </div>
                        <div>
                            <h3 class="stats-number">{{ $users_by_role->whereIn('role', ['kepala_bps', 'bendahara_koperasi', 'ketua_koperasi'])->sum('total') }}</h3>
                            <p class="stats-label">Admin</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stats-icon" style="background: linear-gradient(135deg, #10b981 0%, #34d399 100%);">
                            <i class="bi bi-shield-check text-white"></i>
                        </div>
                        <div>
                            <h3 class="stats-number">{{ $users_by_role->where('role', 'administrator')->first()->total ?? 0 }}</h3>
                            <p class="stats-label">Administrator</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Role Distribution & Monthly Registration -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h5 class="admin-card-title">
                        <i class="bi bi-pie-chart me-2"></i>Distribusi Role
                    </h5>
                </div>
                <div class="admin-card-body">
                    @foreach($users_by_role as $roleData)
                    <div class="role-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                @php
                                    $roleColors = [
                                        'peminjam' => 'bg-primary',
                                        'kepala_bps' => 'bg-info',
                                        'bendahara_koperasi' => 'bg-success',
                                        'ketua_koperasi' => 'bg-warning',
                                        'administrator' => 'bg-danger'
                                    ];
                                @endphp
                                <span class="badge-role {{ $roleColors[$roleData->role] ?? 'bg-secondary' }}">
                                    {{ ucfirst(str_replace('_', ' ', $roleData->role)) }}
                                </span>
                            </div>
                            <div class="text-end">
                                <h4 class="fw-bold mb-0" style="color: #0f172a;">{{ $roleData->total }}</h4>
                                <small class="text-muted">user</small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h5 class="admin-card-title">
                        <i class="bi bi-calendar me-2"></i>Registrasi Bulanan
                    </h5>
                </div>
                <div class="admin-card-body">
                    @if($users_by_month->count() > 0)
                        @foreach($users_by_month as $month)
                        <div class="month-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="fw-semibold mb-0" style="color: #0f172a;">
                                        {{ \Carbon\Carbon::create()->month($month->month)->format('F') }} {{ $month->year }}
                                    </h6>
                                </div>
                                <div class="text-end">
                                    <h4 class="fw-bold mb-0" style="color: #0f172a;">{{ $month->total }}</h4>
                                    <small class="text-muted">user baru</small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <i class="bi bi-inbox"></i>
                            <h5>Belum ada data</h5>
                            <p>Belum ada data registrasi bulanan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Statistics -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h5 class="admin-card-title">
                <i class="bi bi-bar-chart me-2"></i>Statistik Detail
            </h5>
        </div>
        <div class="admin-card-body">
            <div class="row g-4">
                @foreach($users_by_role as $roleData)
                <div class="col-lg-4 col-md-6">
                    <div class="detail-stat-card">
                        <h2 class="detail-stat-number">{{ $roleData->total }}</h2>
                        <h6 class="detail-stat-label">{{ ucfirst(str_replace('_', ' ', $roleData->role)) }}</h6>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
