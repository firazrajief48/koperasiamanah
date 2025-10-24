@extends('layouts.dashboard')

@section('title', 'Dashboard Bendahara Koperasi')
@section('page-title', 'Dashboard Bendahara Koperasi')

@php
    $role = 'Bendahara Koperasi';
    $nama = auth()->user()->name;
    $routePrefix = 'bendahara_koperasi';
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

        /* ==================== ANIMASI ==================== */
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
                opacity: 1;
                transform: translateY(0);
            }
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

        /* ==================== BANNER SELAMAT DATANG ==================== */
        .welcome-banner {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #6366f1 100%);
            border-radius: 20px;
            padding: 1.5rem 2rem;
            margin-bottom: 1.5rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(30, 64, 175, 0.2);
            animation: slideDown 0.6s ease-out;
        }

        .welcome-banner::before {
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

        .welcome-content {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }

        .welcome-icon {
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

        .welcome-banner h2 {
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .welcome-banner p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.875rem;
            margin-bottom: 0;
        }

        /* ==================== KARTU STATISTIK ==================== */
        .stats-card {
            background: rgba(255, 255, 255, 0.7) !important;
            backdrop-filter: blur(30px) !important;
            border: 2px solid rgba(255, 255, 255, 0.5) !important;
            border-radius: 20px !important;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 8px 30px rgba(30, 64, 175, 0.08);
            animation: fadeInUp 0.6s ease-out both;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.5) 0%, transparent 100%);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .stats-card:hover::before {
            opacity: 1;
        }

        .stats-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 15px 45px rgba(30, 64, 175, 0.15);
            border-color: rgba(255, 255, 255, 0.8) !important;
        }

        .stats-card:nth-child(1) { animation-delay: 0.1s; }
        .stats-card:nth-child(2) { animation-delay: 0.2s; }
        .stats-card:nth-child(3) { animation-delay: 0.3s; }

        .icon-circle {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            position: relative;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .stats-card:hover .icon-circle {
            transform: rotate(8deg) scale(1.1);
        }

        .icon-circle::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 16px;
            background: inherit;
            filter: blur(12px);
            opacity: 0.5;
            z-index: -1;
        }

        .icon-circle-blue {
            background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%);
        }

        .icon-circle-orange {
            background: linear-gradient(135deg, #f97316 0%, #fb923c 100%);
        }

        .icon-circle-purple {
            background: linear-gradient(135deg, #8b5cf6 0%, #a78bfa 100%);
        }

        .stats-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .stats-value {
            font-size: 1.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--dark-navy) 0%, var(--primary-blue) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.75rem;
            line-height: 1.2;
        }

        .stats-badge {
            display: none;
        }

        /* ==================== KARTU TABEL ==================== */
        .table-modern-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(30px);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(30, 64, 175, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.6);
            animation: fadeInUp 0.6s ease-out 0.4s both;
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

        .table-header-badge {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(99, 102, 241, 0.15) 100%);
            color: var(--primary-blue);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.813rem;
            border: 2px solid rgba(59, 130, 246, 0.2);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* ==================== TABEL MODERN ==================== */
        .modern-table {
            width: 100%;
            min-width: 900px;
            border-collapse: collapse;
            padding: 0 2rem 2rem;
        }

        .modern-table thead th {
            background: transparent;
            border: none;
            padding: 0.875rem 1rem;
            font-size: 0.75rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-align: center;
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
            text-align: center;
            position: relative;
            font-size: 0.875rem;
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

        /* ==================== BADGE ID ==================== */
        .id-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-light) 100%);
            color: white;
            font-weight: 700;
            font-size: 0.875rem;
            box-shadow: 0 3px 8px rgba(30, 64, 175, 0.25);
        }

        /* ==================== SEL NAMA ==================== */
        .name-cell {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            justify-content: center;
        }

        .name-avatar {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, #f97316 0%, #fb923c 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 0.875rem;
            flex-shrink: 0;
        }

        .name-info {
            text-align: left;
        }

        .name-primary {
            font-weight: 700;
            color: var(--dark-navy);
            font-size: 0.875rem;
            margin-bottom: 0.125rem;
        }

        .name-secondary {
            font-size: 0.75rem;
            color: #64748b;
        }

        /* ==================== SEL JUMLAH ==================== */
        .amount-cell {
            font-size: 0.938rem;
            font-weight: 700;
            color: var(--dark-navy);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .amount-icon {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-green);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
        }

        /* ==================== BADGE TANGGAL ==================== */
        .date-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0.875rem;
            border-radius: 10px;
            background: rgba(99, 102, 241, 0.1);
            color: #4f46e5;
            font-weight: 600;
            font-size: 0.813rem;
        }

        /* ==================== BADGE STATUS ==================== */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .status-pending {
            background: rgba(251, 191, 36, 0.15);
            color: #d97706;
            border: 1px solid rgba(251, 191, 36, 0.3);
        }

        /* ==================== TOMBOL AKSI ==================== */
        .btn-detail {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border: none;
            padding: 0.5rem 1.25rem;
            font-size: 0.813rem;
            font-weight: 600;
            border-radius: 10px;
            color: white;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-detail:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
            color: white;
        }

        /* ==================== SCROLLBAR ==================== */
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

        /* ==================== RESPONSIVE ==================== */
        @media (max-width: 768px) {
            .welcome-banner {
                padding: 1.25rem 1.5rem;
                margin-bottom: 1.25rem;
            }

            .welcome-content {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.75rem;
            }

            .welcome-banner h2 {
                font-size: 1.25rem;
            }

            .stats-card {
                padding: 1.25rem;
            }

            .stats-value {
                font-size: 1.25rem;
            }

            .table-header {
                padding: 1.25rem 1.5rem;
            }

            .modern-table {
                padding: 0 1.5rem 1.5rem;
            }
        }
    </style>

    <div class="welcome-banner">
        <div class="welcome-content">
            <div class="welcome-icon">
                <i class="bi bi-person-badge text-white" style="font-size: 1.75rem;"></i>
            </div>
            <div>
                <h2>Selamat Datang, {{ $nama }}! 👋</h2>
                <p>Kelola pengajuan pinjaman dan verifikasi pembayaran dengan mudah dan efisien</p>
            </div>
        </div>
    </div>

    <div class="table-modern-card">
        <div class="table-header">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <h5>Daftar Pinjaman Masuk</h5>
                    <p>Kelola dan verifikasi pengajuan pinjaman dari anggota koperasi</p>
                </div>
                <div class="table-header-badge">
                    <i class="bi bi-list-check"></i>
                    <span>{{ count($pengajuan) }} Pengajuan</span>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Peminjam</th>
                        <th>Jumlah Pinjaman</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengajuan as $p)
                        <tr>
                            <td>
                                <div class="id-badge">{{ $p['id'] }}</div>
                            </td>
                            <td>
                                <div class="name-cell">
                                    <div class="name-avatar">
                                        {{ strtoupper(substr($p['nama'], 0, 1)) }}
                                    </div>
                                    <div class="name-info">
                                        <div class="name-primary">{{ $p['nama'] }}</div>
                                        <div class="name-secondary">Anggota Koperasi</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="amount-cell">
                                    <div class="amount-icon">
                                        <i class="bi bi-cash"></i>
                                    </div>
                                    <span>Rp {{ number_format($p['jumlah'], 0, ',', '.') }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="date-badge">
                                    <i class="bi bi-calendar-event"></i>
                                    <span>{{ date('d/m/Y', strtotime($p['tanggal'])) }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="status-badge status-pending">
                                    <i class="bi bi-clock"></i>
                                    <span>Menunggu</span>
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('bendahara_koperasi.detail', $p['id']) }}" class="btn-detail">
                                    <i class="bi bi-eye"></i>
                                    <span>Detail</span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
