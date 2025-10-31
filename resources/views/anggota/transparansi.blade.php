@extends('layouts.dashboard')

@section('title', 'Transparansi Keuangan')
@section('page-title', 'Transparansi Keuangan')

@php
    $role = 'Anggota';
    $nama = auth()->user()->name;
    $routePrefix = 'anggota';
    $showAjukan = true;
    $showRiwayat = true;
@endphp

@section('main-content')
    <style>
        :root {
            --primary-blue: #1e40af;
            --primary-light: #3b82f6;
            --accent-orange: #f97316;
            --dark-navy: #0f172a;
            --success-green: #10b981;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0e7ff 100%);
            min-height: 100vh;
        }

        /* Page Header Banner */
        .page-header-banner {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #6366f1 100%);
            border-radius: 20px;
            padding: 1.5rem 2rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(30, 64, 175, 0.2);
            animation: slideDown 0.6s ease-out;
        }

        .page-header-banner::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.08) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 20s infinite ease-in-out;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(20px, -20px) rotate(3deg); }
            66% { transform: translate(-15px, 15px) rotate(-3deg); }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 👍;
                transform: translateY(0);
            }
        }

        .header-content {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .header-icon {
            width: 56px;
            height: 56px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .page-header-banner h2 {
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .page-header-banner p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.875rem;
            margin-bottom: 0;
        }

        .header-badge {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 0.625rem 1.25rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Table Card */
        .table-modern-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(30px);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(30, 64, 175, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.6);
            animation: fadeInUp 0.6s ease-out 0.2s both;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .table-header {
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.08) 0%, rgba(99, 102, 241, 0.08) 100%);
            padding: 1.5rem 2rem;
            border-bottom: 2px solid rgba(30, 64, 175, 0.1);
        }

        .table-header h5 {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--dark-navy);
            margin-bottom: 0.25rem;
        }

        .table-header p {
            color: #64748b;
            margin-bottom: 0;
            font-size: 0.813rem;
        }

        /* Search Bar */
        .search-container {
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.08) 0%, rgba(99, 102, 241, 0.08) 100%);
            padding: 1.5rem 2rem;
            border-bottom: 2px solid rgba(30, 64, 175, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .search-wrapper {
            position: relative;
            flex: 1;
            max-width: 400px;
        }

        .search-wrapper i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1rem;
        }

        .search-input {
            padding: 0.75rem 1rem 0.75rem 2.75rem;
            border-radius: 50px;
            border: 2px solid rgba(30, 64, 175, 0.1);
            width: 100%;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            background: white;
        }

        .search-input:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            outline: none;
        }

        .total-badge {
            background: white;
            padding: 0.5rem 1.25rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--primary-blue);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 2px 8px rgba(30, 64, 175, 0.1);
        }

        /* Table Styling */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table-responsive::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--primary-blue), var(--accent-orange));
            border-radius: 50px;
        }

        .table-responsive::-webkit-scrollbar-track {
            background: rgba(226, 232, 240, 0.3);
            border-radius: 50px;
        }

        .modern-table {
            width: 100%;
            min-width: 900px;
            border-collapse: collapse;
            padding: 0 2rem 2rem;
        }

        .modern-table thead th {
            background: transparent;
            border: none;
            padding: 1rem;
            font-size: 0.75rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-align: center;
        }

        .modern-table thead th:first-child {
            text-align: left;
        }

        .modern-table tbody tr {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .modern-table tbody tr::after {
            content: '';
            position: absolute;
            left: 0;
            right: 0;
            bottom: -6px;
            height: 12px;
            background: transparent;
            pointer-events: none;
        }

        .modern-table tbody tr:hover {
            transform: translateX(6px) translateY(-2px);
        }

        .modern-table tbody td {
            border: none;
            padding: 1rem;
            vertical-align: middle;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 12px rgba(30, 64, 175, 0.06);
            position: relative;
            text-align: center;
        }

        .modern-table tbody td:first-child {
            text-align: left;
        }

        .modern-table tbody tr:hover td {
            box-shadow: 0 8px 24px rgba(30, 64, 175, 0.12);
            background: white;
        }

        .modern-table tbody td:first-child {
            border-radius: 14px 0 0 14px;
            padding-left: 1.5rem;
        }

        .modern-table tbody td:first-child::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--accent-orange) 100%);
            border-radius: 14px 0 0 14px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .modern-table tbody tr:hover td:first-child::before {
            opacity: 1;
        }

        .modern-table tbody td:last-child {
            border-radius: 0 14px 14px 0;
            padding-right: 1.5rem;
        }

        .modern-table tbody tr + tr td {
            padding-top: calc(1rem + 12px);
        }

        .modern-table tbody tr:first-child td {
            padding-top: 1rem;
        }

        /* Name Cell */
        .name-cell {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 600;
            color: var(--dark-navy);
            font-size: 0.938rem;
        }

        .name-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-light) 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 0.875rem;
            flex-shrink: 0;
        }

        .nip-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.375rem 0.75rem;
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.3);
            border-radius: 50px;
            color: #1e40af;
            font-weight: 500;
            font-size: 0.75rem;
        }

        /* Amount Cell */
        .amount-cell {
            font-weight: 700;
            color: var(--dark-navy);
            font-size: 0.938rem;
        }

        /* Status Badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.813rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .status-badge i {
            font-size: 0.875rem;
        }

        .status-berjalan {
            background: linear-gradient(135deg, rgba(251, 191, 36, 0.15) 0%, rgba(252, 211, 77, 0.15) 100%);
            color: #d97706;
            border: 2px solid rgba(251, 191, 36, 0.3);
        }

        .status-lunas {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(52, 211, 153, 0.15) 100%);
            color: #047857;
            border: 2px solid rgba(16, 185, 129, 0.3);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 1.5rem;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(99, 102, 241, 0.1) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: var(--primary-blue);
        }

        .empty-state h5 {
            color: var(--dark-navy);
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: #64748b;
            margin-bottom: 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-header-banner {
                padding: 1.25rem 1.5rem;
            }

            .header-content {
                flex-direction: column;
                align-items: flex-start;
            }

            .table-header,
            .search-container {
                padding: 1.25rem 1.5rem;
            }

            .modern-table {
                padding: 0 1.5rem 1.5rem;
            }

            .modern-table thead th,
            .modern-table tbody td {
                padding: 0.875rem 0.75rem;
                font-size: 0.813rem;
            }
        }
    </style>

    <!-- Page Header -->
    <div class="page-header-modern">
        <div class="d-flex align-items-center gap-3">
            <div class="icon-box"><i class="bi bi-eye text-white"></i></div>
            <div>
                <h2>Transparansi Keuangan 👁️</h2>
                <small>Lihat data kumulatif keuangan koperasi secara transparan</small>
            </div>
        </div>
        @if(isset($dataKumulatif['pinjaman_aktif']))
        <div class="badge bg-light text-dark px-3 py-2">
            <i class="bi bi-people me-1"></i>{{ $dataKumulatif['pinjaman_aktif'] }} Pinjaman Aktif
        </div>
        @endif
    </div>

    <!-- Table Card -->
    <div class="table-modern-card">
        <div class="table-header">
            <h5>Transparansi Keuangan Koperasi</h5>
            <p>Data kumulatif keuangan koperasi untuk semua anggota</p>
        </div>

        <div class="table-responsive">
            <!-- Financial Overview Cards -->
            <div class="row g-4 mb-4">
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <div class="icon-box me-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    <i class="bi bi-cash-stack text-white fs-4"></i>
                                </div>
                                <div>
                                    <h3 class="fw-bold mb-0" style="color: var(--dark-navy);">Rp {{ number_format($dataKumulatif['total_pinjaman_disalurkan'], 0, ',', '.') }}</h3>
                                    <p class="text-muted mb-0">Total Pinjaman Disalurkan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <div class="icon-box me-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                                    <i class="bi bi-check-circle text-white fs-4"></i>
                                </div>
                                <div>
                                    <h3 class="fw-bold mb-0" style="color: var(--dark-navy);">Rp {{ number_format($dataKumulatif['total_pinjaman_dilunasi'], 0, ',', '.') }}</h3>
                                    <p class="text-muted mb-0">Total Pinjaman Dilunasi</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <div class="icon-box me-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                                    <i class="bi bi-clock-history text-white fs-4"></i>
                                </div>
                                <div>
                                    <h3 class="fw-bold mb-0" style="color: var(--dark-navy);">Rp {{ number_format($dataKumulatif['saldo_pinjaman_berjalan'], 0, ',', '.') }}</h3>
                                    <p class="text-muted mb-0">Saldo Pinjaman Berjalan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row g-4 mb-4">
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <div class="icon-box me-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                                    <i class="bi bi-people-fill text-white fs-4"></i>
                                </div>
                                <div>
                                    <h3 class="fw-bold mb-0" style="color: var(--dark-navy);">{{ $dataKumulatif['total_anggota'] }}</h3>
                                    <p class="text-muted mb-0">Total Anggota</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <div class="icon-box me-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);">
                                    <i class="bi bi-hourglass-split text-white fs-4"></i>
                                </div>
                                <div>
                                    <h3 class="fw-bold mb-0" style="color: var(--dark-navy);">{{ $dataKumulatif['pinjaman_aktif'] }}</h3>
                                    <p class="text-muted mb-0">Pinjaman Aktif</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <div class="icon-box me-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                                    <i class="bi bi-check2-circle text-white fs-4"></i>
                                </div>
                                <div>
                                    <h3 class="fw-bold mb-0" style="color: var(--dark-navy);">{{ $dataKumulatif['pinjaman_lunas'] }}</h3>
                                    <p class="text-muted mb-0">Pinjaman Lunas</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Information Card -->
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-header bg-transparent border-0 p-4">
                    <h5 class="fw-bold mb-0" style="color: var(--dark-navy);">
                        <i class="bi bi-info-circle me-2"></i>Informasi Transparansi Keuangan
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <p class="text-muted mb-3">Halaman ini menampilkan data kumulatif keuangan koperasi secara transparan untuk semua anggota.</p>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-cash-stack text-primary me-2"></i>
                                <span class="fw-semibold">Total Pinjaman Disalurkan:</span>
                            </div>
                            <p class="text-muted small ms-4">Jumlah total pinjaman yang telah disalurkan kepada anggota</p>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <span class="fw-semibold">Total Pinjaman Dilunasi:</span>
                            </div>
                            <p class="text-muted small ms-4">Jumlah total pinjaman yang telah dilunasi oleh anggota</p>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-clock-history text-warning me-2"></i>
                                <span class="fw-semibold">Saldo Pinjaman Berjalan:</span>
                            </div>
                            <p class="text-muted small ms-4">Jumlah sisa pinjaman yang masih berjalan</p>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-people-fill text-info me-2"></i>
                                <span class="fw-semibold">Total Anggota:</span>
                            </div>
                            <p class="text-muted small ms-4">Jumlah total anggota koperasi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // No search functionality needed for cumulative data
        </script>
    @endpush
@endsection
