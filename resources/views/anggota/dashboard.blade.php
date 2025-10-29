@extends('layouts.dashboard')

@section('title', 'Dashboard Anggota')
@section('page-title', 'Dashboard Anggota')

@php
    $role = 'Anggota';
    $nama = auth()->user()->name;
    $routePrefix = 'anggota';
    $showAjukan = true;
    $showRiwayat = true;

    // Data untuk simulasi dari data yang dikirim controller
    $totalPinjaman = $data['jumlah_pinjaman'] ?? 0;
    $cicilanPerBulan = !empty($data['simulasi']) ? ($data['simulasi'][0]['angsuran'] ?? 0) : 0;
    $totalTenor = !empty($data['simulasi']) ? count($data['simulasi']) : 0;
    $bulanTerbayar = 0; // Default, akan diupdate jika ada data
@endphp

@section('main-content')
    <style>
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

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0e7ff 100%);
            min-height: 100vh;
        }

        /* Welcome Banner - Compact */
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

        /* Compact Glass Cards */
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

        /* Compact Icon Circle */
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

        .icon-circle-green {
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        }

        .icon-circle-orange {
            background: linear-gradient(135deg, #f97316 0%, #fb923c 100%);
        }

        /* Compact Typography */
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
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.375rem 0.75rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .badge-blue {
            background: rgba(59, 130, 246, 0.15);
            color: #1e40af;
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

        .badge-green {
            background: rgba(16, 185, 129, 0.15);
            color: #047857;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .badge-orange {
            background: rgba(249, 115, 22, 0.15);
            color: #c2410c;
            border: 1px solid rgba(249, 115, 22, 0.3);
        }

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

        /* Compact Table Styling - FIXED */
        .modern-table {
            width: 100%;
            min-width: 800px;
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

        .month-cell {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
        }

        .month-number {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-light) 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.938rem;
            box-shadow: 0 3px 8px rgba(30, 64, 175, 0.25);
        }

        .month-label {
            font-weight: 600;
            color: var(--dark-navy);
            font-size: 0.875rem;
        }

        .amount-cell {
            font-size: 0.938rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .amount-debit {
            color: #ef4444;
        }

        .amount-credit {
            color: var(--success-green);
        }

        .amount-muted {
            color: #94a3b8;
            font-weight: 600;
        }

        .amount-icon {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
        }

        .icon-debit {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        .icon-credit {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-green);
        }

        /* Status Badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.375rem 0.75rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .status-paid {
            background: rgba(16, 185, 129, 0.15);
            color: #047857;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .status-unpaid {
            background: rgba(251, 191, 36, 0.15);
            color: #d97706;
            border: 1px solid rgba(251, 191, 36, 0.3);
        }

        /* Responsive */
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

            .welcome-icon {
                width: 48px;
                height: 48px;
            }

            .stats-card {
                padding: 1.25rem;
            }

            .stats-value {
                font-size: 1.25rem;
            }

            .icon-circle {
                width: 48px;
                height: 48px;
            }

            .table-header {
                padding: 1.25rem 1.5rem;
            }

            .modern-table {
                padding: 0 1.5rem 1.5rem;
            }

            .modern-table thead th,
            .modern-table tbody td {
                padding: 0.875rem 0.75rem;
            }

            .month-number {
                width: 32px;
                height: 32px;
                font-size: 0.875rem;
            }

            .amount-cell {
                font-size: 0.875rem;
            }
        }

        /* Scrollbar */
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
    </style>

    <!-- Welcome Banner -->
    <div class="welcome-banner">
        <div class="welcome-content">
            <div class="welcome-icon">
                <i class="bi bi-person-circle text-white" style="font-size: 1.75rem;"></i>
            </div>
            <div>
                <h2>Selamat Datang, {{ $nama }}! 👋</h2>
                <p>Kelola pinjaman Anda dengan mudah dan pantau progress pembayaran secara real-time</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-lg-4 col-md-6">
            <div class="stats-card">
                <div class="icon-circle icon-circle-blue">
                    <i class="bi bi-wallet2 text-white" style="font-size: 1.5rem;"></i>
                </div>
                <div class="stats-label">Iuran Pribadi</div>
                <div class="stats-value">Rp {{ number_format($data['kas_pribadi'] ?? 0, 0, ',', '.') }}</div>
                <div class="stats-badge badge-blue">
                    <i class="bi bi-arrow-up-circle"></i>
                    <span>{{ ($data['kas_pribadi'] ?? 0) > 0 ? 'Saldo Aktif' : 'Belum Ada Iuran' }}</span>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="stats-card">
                <div class="icon-circle icon-circle-green">
                    <i class="bi bi-cash-stack text-white" style="font-size: 1.5rem;"></i>
                </div>
                <div class="stats-label">Jumlah Pinjaman</div>
                <div class="stats-value">Rp {{ number_format($data['jumlah_pinjaman'] ?? 0, 0, ',', '.') }}</div>
                <div class="stats-badge badge-green">
                    <i class="bi bi-check-circle"></i>
                    <span>{{ ($data['jumlah_pinjaman'] ?? 0) > 0 ? 'Disetujui' : 'Belum Ada Pinjaman' }}</span>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="stats-card">
                <div class="icon-circle icon-circle-orange">
                    <i class="bi bi-hourglass-split text-white" style="font-size: 1.5rem;"></i>
                </div>
                <div class="stats-label">Sisa Pinjaman</div>
                <div class="stats-value">Rp {{ number_format($data['sisa_pinjaman'] ?? 0, 0, ',', '.') }}</div>
                <div class="stats-badge badge-orange">
                    <i class="bi bi-clock-history"></i>
                    <span>{{ ($data['sisa_pinjaman'] ?? 0) > 0 ? 'Dalam Pembayaran' : 'Tidak Ada Pinjaman' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Pembayaran Mendatang -->
    @if($pembayaranMendatang && $pembayaranMendatang->count() > 0)
    <div class="table-modern-card mb-4">
        <div class="table-header">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <h5>Pembayaran Mendatang</h5>
                    <p>Tagihan yang akan jatuh tempo dalam 7 hari ke depan</p>
                </div>
                <div class="table-header-badge" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                    <i class="bi bi-exclamation-triangle"></i>
                    <span>{{ $pembayaranMendatang->count() }} Tagihan</span>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Bulan</th>
                        <th>Nominal</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pembayaranMendatang as $pembayaran)
                        <tr>
                            <td>
                                <div class="month-cell">
                                    <div class="month-number">{{ $pembayaran->bulan_ke }}</div>
                                    <div class="month-label">Bulan ke-{{ $pembayaran->bulan_ke }}</div>
                                </div>
                            </td>
                            <td>
                                <div class="amount-cell amount-debit">
                                    <div class="amount-icon icon-debit">
                                        <i class="bi bi-arrow-down"></i>
                                    </div>
                                    <div class="amount-details">
                                        <div class="amount-value">Rp {{ number_format($pembayaran->nominal_pembayaran, 0, ',', '.') }}</div>
                                        <div class="amount-label">Cicilan</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="date-cell">
                                    <div class="date-value">{{ \Carbon\Carbon::parse($pembayaran->tanggal_jatuh_tempo)->format('d M Y') }}</div>
                                    <div class="date-label">{{ \Carbon\Carbon::parse($pembayaran->tanggal_jatuh_tempo)->diffForHumans() }}</div>
                                </div>
                            </td>
                            <td>
                                <span class="status-badge status-pending">
                                    <i class="bi bi-clock-fill"></i>
                                    Belum Bayar
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Pengingat Pembayaran Table -->
    <div class="table-modern-card">
        <div class="table-header">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <h5>Pengingat Pembayaran Bulanan</h5>
                    <p>Status pembayaran cicilan pinjaman Anda</p>
                </div>
                @if($activeLoan)
                <div class="table-header-badge">
                    <i class="bi bi-calendar-range"></i>
                    <span>{{ $activeLoan->tenor_bulan }} Bulan Periode</span>
                </div>
                @endif
            </div>
        </div>

        <div class="table-responsive">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Periode</th>
                        <th>Jatuh Tempo</th>
                        <th>Nominal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @if($activeLoan && $activeLoan->pembayarans->count() > 0)
                        @foreach($activeLoan->pembayarans->sortBy('bulan_ke') as $pembayaran)
                            <tr>
                                <td>
                                    <div class="month-cell">
                                        <div class="month-number">{{ $pembayaran->bulan_ke }}</div>
                                        <div class="month-label">Bulan ke-{{ $pembayaran->bulan_ke }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="date-cell">
                                        <i class="bi bi-calendar-event"></i>
                                        <span>{{ $pembayaran->tanggal_jatuh_tempo->format('d/m/Y') }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="amount-cell amount-debit">
                                        <div class="amount-icon icon-debit">
                                            <i class="bi bi-arrow-down-circle"></i>
                                        </div>
                                        <span>Rp {{ number_format($pembayaran->nominal_pembayaran, 0, ',', '.') }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if($pembayaran->status == 'sudah_bayar')
                                        <span class="status-badge status-paid">
                                            <i class="bi bi-check-circle"></i>
                                            <span>Sudah Terbayar</span>
                                        </span>
                                    @elseif($pembayaran->tanggal_jatuh_tempo->isPast())
                                        <span class="status-badge status-overdue">
                                            <i class="bi bi-exclamation-triangle"></i>
                                            <span>Belum Terbayar</span>
                                        </span>
                                    @else
                                        <span class="status-badge status-upcoming">
                                            <i class="bi bi-clock"></i>
                                            <span>Belum Jatuh Tempo</span>
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                <i class="bi bi-info-circle me-2"></i>
                                Belum ada data simulasi pinjaman
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
