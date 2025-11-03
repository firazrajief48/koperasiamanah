@extends('layouts.dashboard')

@section('title', 'Transparansi Keuangan')
@section('page-title', 'Transparansi Keuangan')

@php
    $role = 'Bendahara Koperasi';
    $nama = auth()->user()->name;
    $routePrefix = 'bendahara_koperasi';
    $showLaporan = true;
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

        /* Page Header */
        .page-header {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #6366f1 100%);
            border-radius: 20px;
            padding: 1.5rem 2rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 10px 30px rgba(30, 64, 175, 0.2);
            animation: slideDown 0.6s ease-out;
            /* ensure header sits above decorative background pseudo-elements */
            position: relative;
            z-index: 2;
        }

        /* Defensive: hide accidental pseudo-elements on header */
        .page-header::before,
        .page-header::after {
            content: none !important;
            display: none !important;
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

        .page-header h4 {
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .page-header p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.875rem;
            margin-bottom: 0;
        }

        /* Search Box */
        .search-container {
            position: relative;
            max-width: 500px;
            margin-bottom: 1.5rem;
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

        .search-input {
            padding: 0.875rem 1.25rem 0.875rem 3.5rem;
            border-radius: 50px;
            border: 2px solid rgba(255, 255, 255, 0.5);
            width: 100%;
            font-size: 0.875rem;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 16px rgba(30, 64, 175, 0.1);
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-blue);
            background: white;
            box-shadow: 0 6px 24px rgba(30, 64, 175, 0.15);
        }

        .search-icon {
            position: absolute;
            left: 1.25rem;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            pointer-events: none;
            font-size: 1.125rem;
        }

        /* Table Card */
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

        /* Table Wrapper */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            padding: 0.5 rem 1rem 2rem 1.5rem;
        }

        /* Modern Table - COMPACT */
        .modern-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 12px;
        }

        .modern-table thead th {
            background: transparent;
            border: none;
            padding: 0.75rem 1rem;
            font-size: 0.75rem; /* dashboard */
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-align: center;
            white-space: nowrap;
        }

        .modern-table thead th:nth-child(3),
        .modern-table thead th:nth-child(4),
        .modern-table thead th:nth-child(5) {
            text-align: right;
        }

        .modern-table thead th:nth-child(6),
        .modern-table thead th:nth-child(7) {
            text-align: center;
        }

        .modern-table tbody tr {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .modern-table tbody tr:hover {
            transform: translateX(4px) translateY(-2px);
        }

        .modern-table tbody td {
            border: none;
            padding: 1.25rem 1rem;
            vertical-align: middle;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 12px rgba(30, 64, 175, 0.06);
            font-size: 0.875rem; /* dashboard body */
            text-align: left;
        }

        .modern-table tbody tr:hover td {
            box-shadow: 0 8px 24px rgba(30, 64, 175, 0.12);
            background: white;
        }

        .modern-table tbody td:first-child {
            border-radius: 14px 0 0 14px;
            padding-left: 1.5rem;
            position: relative;
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

        /* Align columns */
        .modern-table tbody td:nth-child(3),
        .modern-table tbody td:nth-child(4),
        .modern-table tbody td:nth-child(5) {
            text-align: right;
        }

        .modern-table tbody td:nth-child(6),
        .modern-table tbody td:nth-child(7) {
            text-align: center;
        }

        /* Name Cell */
        .name-cell {
            display: flex;
            align-items: center;
            gap: 0.75rem;
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
            font-size: 0.875rem; /* dashboard */
            flex-shrink: 0;
        }

        .name-info {
            text-align: left;
        }

        .name-primary {
            font-weight: 700;
            color: var(--dark-navy);
            font-size: 0.875rem; /* dashboard */
            display: block;
        }

        .name-secondary {
            font-size: 0.75rem; /* dashboard */
            color: #64748b;
            display: block;
            margin-top: 0.125rem;
        }

        /* Amount Cell */
        .amount-cell {
            font-size: 0.938rem; /* dashboard */
            font-weight: 700;
            color: var(--dark-navy);
            white-space: nowrap;
        }

        /* Status Badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.375rem;
            padding: 0.5rem 1rem; /* slightly smaller to match dashboard */
            border-radius: 50px;
            font-size: 0.75rem; /* dashboard */
            font-weight: 600;
            white-space: nowrap;
        }

        .status-lunas {
            background: rgba(16, 185, 129, 0.15);
            color: #047857;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .status-berjalan {
            background: rgba(251, 191, 36, 0.15);
            color: #d97706;
            border: 1px solid rgba(251, 191, 36, 0.3);
        }

        /* Action Button */
        .btn-edit {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border: none;
            padding: 0.625rem 1.25rem;
            font-size: 0.875rem; /* dashboard */
            font-weight: 600;
            border-radius: 10px;
            color: white;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }

        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
            color: white;
        }

        /* Modal Styling - COMPACT */
        .modal-dialog {
            max-width: 760px !important;
        }

        .modal-content {
            border-radius: 12px;
            border: none;
            box-shadow: 0 12px 30px rgba(30, 64, 175, 0.18);
            overflow: visible;
        }

        .modal-header {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #6366f1 100%);
            border: none;
            padding: 1.25rem 1.5rem;
            border-radius: 12px 12px 0 0;
        }

        .modal-header .modal-title {
            color: white;
            font-weight: 700;
            font-size: 1.125rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .modal-header .btn-close {
            filter: brightness(0) invert(1);
            opacity: 0.85;
        }

        .modal-header .btn-close:hover {
            opacity: 1;
        }

        .modal-body {
            padding: 1.25rem 1.5rem;
            background: white;
        }

        /* Payment Mode Toggle - COMPACT */
        .payment-mode-toggle {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1rem;
            background: rgba(241, 245, 249, 0.85);
            padding: 0.35rem;
            border-radius: 10px;
        }

        .mode-btn {
            flex: 1;
            padding: 0.55rem 0.6rem;
            border: 2px solid transparent;
            background: transparent;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.18s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            color: #64748b;
        }

        .mode-btn.active {
            background: white;
            border-color: var(--primary-blue);
            color: var(--primary-blue);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
        }

        .mode-btn:not(.active):hover {
            background: rgba(255, 255, 255, 0.6);
        }

        .mode-btn i {
            font-size: 0.95rem;
        }

        /* Payment Section */
        .payment-section {
            display: none;
        }

        .payment-section.active {
            display: block;
        }

        /* Info Card - COMPACT */
        .info-card {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.06) 0%, rgba(99, 102, 241, 0.06) 100%);
            border-radius: 12px;
            padding: 0.9rem 1rem;
            margin-bottom: 1rem;
            border: 1px solid rgba(59, 130, 246, 0.14);
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.6rem;
        }

        .info-row:last-child {
            margin-bottom: 0;
        }

        .info-label {
            font-size: 0.813rem;
            color: #64748b;
            font-weight: 600;
        }

        .info-value {
            font-size: 1rem;
            font-weight: 700;
            color: var(--dark-navy);
        }

        /* Angsuran Table - LARGER */
        .angsuran-table-wrapper {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #eef2f7;
            margin-bottom: 1rem;
        }

        .angsuran-table {
            width: 100%;
            border-collapse: collapse;
        }

        .angsuran-table thead {
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.06) 0%, rgba(99, 102, 241, 0.06) 100%);
        }

        .angsuran-table thead th {
            padding: 0.75rem 0.9rem;
            font-size: 0.75rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            border-bottom: 1px solid #f1f5f9;
            text-align: center;
        }

        .angsuran-table tbody tr {
            border-bottom: 1px solid #fbfdff;
            transition: all 0.18s ease;
        }

        .angsuran-table tbody tr:hover:not(.paid-row) {
            background: rgba(59, 130, 246, 0.02);
        }

        .angsuran-table tbody tr.paid-row {
            background: rgba(16, 185, 129, 0.04);
            opacity: 0.9;
        }

        .angsuran-table tbody td {
            padding: 0.6rem 0.9rem;
            font-size: 0.813rem;
            color: var(--dark-navy);
        }

        /* Make nominal angsuran and sisa pinjaman left-aligned for readability */
        .angsuran-table tbody td:nth-child(2),
        .angsuran-table tbody td:nth-child(3) {
            text-align: left;
            padding-left: 1rem;
        }

        .angsuran-nominal {
            font-weight: 700;
            color: var(--primary-blue);
            font-size: 0.875rem;
        }

        .sisa-nominal {
            font-weight: 600;
            color: #64748b;
            font-size: 0.813rem;
        }

        .btn-bayar {
            background: linear-gradient(135deg, #10b981, #059669);
            border: none;
            padding: 0.45rem 0.9rem;
            font-size: 0.813rem;
            font-weight: 700;
            border-radius: 8px;
            color: white;
            box-shadow: 0 3px 8px rgba(16, 185, 129, 0.18);
            transition: all 0.18s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            cursor: pointer;
        }

        .btn-bayar:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 12px rgba(16, 185, 129, 0.22);
        }

        .badge-paid {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            border-radius: 50px;
            font-size: 0.813rem;
            font-weight: 600;
            background: rgba(16, 185, 129, 0.15);
            color: #047857;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        /* Manual Input - LARGER */
        .manual-input-group {
            margin-bottom: 2rem;
        }

        .manual-input-group label {
            display: block;
            font-size: 0.938rem;
            font-weight: 600;
            color: var(--dark-navy);
            margin-bottom: 0.75rem;
        }

        .manual-input-group input {
            width: 100%;
            padding: 0.6rem 0.9rem;
            border: 2px solid #e6edf6;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 600;
            transition: all 0.18s ease;
        }

        .manual-input-group input:focus {
            outline: none;
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        /* Summary Card - LARGER */
        .summary-card {
            background: linear-gradient(135deg, #f7fff7 0%, #ecfff0 100%);
            border-radius: 12px;
            padding: 0.9rem 1rem;
            margin-bottom: 1rem;
            border: 1px solid rgba(16, 185, 129, 0.12);
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.6rem;
        }

        .summary-row:last-child {
            margin-bottom: 0;
            padding-top: 0.6rem;
            border-top: 1px dashed rgba(16, 185, 129, 0.18);
        }

        .summary-label {
            font-size: 0.813rem;
            color: #047857;
            font-weight: 600;
        }

        .summary-value {
            font-size: 0.95rem;
            font-weight: 700;
            color: #047857;
        }

        /* Pay Button - LARGER */
        .btn-pay {
            width: 100%;
            background: linear-gradient(135deg, #10b981, #059669);
            border: none;
            padding: 0.7rem;
            font-size: 0.95rem;
            font-weight: 700;
            border-radius: 10px;
            color: white;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.22);
            transition: all 0.18s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            cursor: pointer;
        }

        .btn-pay:hover:not(:disabled) {
            transform: translateY(-1px);
            box-shadow: 0 8px 18px rgba(16, 185, 129, 0.3);
        }

        .btn-pay:disabled {
            background: #eef2f7;
            color: #94a3b8;
            cursor: not-allowed;
            box-shadow: none;
        }

        .btn-pay i {
            font-size: 1rem;
        }

        /* Alert - LARGER */
        .alert-info {
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.2);
            border-radius: 12px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.875rem;
        }

        .alert-info i {
            color: var(--primary-blue);
            font-size: 1.125rem;
            flex-shrink: 0;
        }

        .alert-info-text {
            font-size: 0.875rem;
            color: #1e40af;
            line-height: 1.5;
            flex: 1;
        }

        /* Scrollbar */
        .table-responsive::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--primary-blue), var(--accent-orange));
            border-radius: 50px;
        }

        .table-responsive::-webkit-scrollbar-track {
            background: rgba(226, 232, 240, 0.3);
            border-radius: 50px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .payment-mode-toggle {
                flex-direction: column;
            }
        }
    </style>

    <!-- Page Header -->
    <div class="page-header-modern">
        <div class="d-flex align-items-center gap-3">
            <div class="icon-box"><i class="bi bi-eye text-white"></i></div>
            <div>
                <h2>💰 Transparansi Keuangan</h2>
                <small>Koperasi Amanah BPS Kota Surabaya - Kelola pembayaran pinjaman anggota</small>
            </div>
        </div>
    </div>

    <!-- Search -->
    <div class="search-container">
        <input type="text" class="search-input" placeholder="Cari berdasarkan nama" id="searchInput">
        <i class="fas fa-search search-icon"></i>
    </div>

    <!-- Table -->
    <div class="table-modern-card">
        <div class="table-header">
            <h5>Daftar Pinjaman Anggota</h5>
            <p>Pantau dan kelola status pembayaran pinjaman anggota koperasi</p>
        </div>

        <div class="table-responsive">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>NAMA</th>
                        <th>NIP</th>
                        <th>JUMLAH PINJAMAN</th>
                        <th>JUMLAH DIBAYAR</th>
                        <th>SISA PINJAMAN</th>
                        <th>STATUS</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @if(count($pinjaman) > 0)
                        @foreach ($pinjaman as $p)
                            <tr data-nama="{{ strtolower($p['nama']) }}" data-nip="{{ $p['nip'] }}">
                                <td>
                                    <div class="name-cell">
                                        <div class="name-avatar">
                                            {{ strtoupper(substr($p['nama'], 0, 1)) }}
                                        </div>
                                        <div class="name-info">
                                            <span class="name-primary">{{ $p['nama'] }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="name-secondary">{{ $p['nip'] }}</span>
                                </td>
                                <td>
                                    <span class="amount-cell">Rp {{ number_format($p['jumlah'], 0, ',', '.') }}</span>
                                </td>
                                <td>
                                    <span class="amount-cell" id="totalBayar{{ $p['id'] }}">Rp {{ number_format($p['total_bayar'] ?? 0, 0, ',', '.') }}</span>
                                </td>
                                <td>
                                    <span class="amount-cell" id="sisaPinjaman{{ $p['id'] }}">Rp {{ number_format($p['sisa'], 0, ',', '.') }}</span>
                                </td>
                                <td>
                                    @if ($p['status'] == 'Lunas')
                                        <span class="status-badge status-lunas" id="status{{ $p['id'] }}">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Lunas</span>
                                        </span>
                                    @else
                                        <span class="status-badge status-berjalan" id="status{{ $p['id'] }}">
                                            <i class="bi bi-clock-history"></i>
                                            <span>Berjalan</span>
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn-edit" data-bs-toggle="modal" data-bs-target="#editModal{{ $p['id'] }}">
                                        <i class="bi bi-pencil-square"></i>
                                        <span>Edit</span>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 3rem 1rem; color: #64748b;">
                                <i class="bi bi-inbox" style="font-size: 3rem; opacity: 0.3; display: block; margin-bottom: 1rem;"></i>
                                <p style="margin: 0; font-size: 0.938rem; font-weight: 600;">Belum ada pinjaman yang aktif atau lunas</p>
                                <p style="margin: 0.5rem 0 0 0; font-size: 0.813rem; opacity: 0.7;">Pinjaman akan muncul di sini setelah melewati semua persetujuan (Bendahara, Ketua, Kepala)</p>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modals -->
    @if(count($pinjaman) > 0)
        @foreach ($pinjaman as $p)
        <div class="modal fade" id="editModal{{ $p['id'] }}" tabindex="-1" aria-labelledby="modalLabel{{ $p['id'] }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel{{ $p['id'] }}">
                            <i class="bi bi-cash-coin"></i>
                            Pembayaran - {{ $p['nama'] }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Info Card -->
                        <div class="info-card">
                            <div class="info-row">
                                <span class="info-label">Jumlah Pinjaman</span>
                                <span class="info-value">Rp {{ number_format($p['jumlah'], 0, ',', '.') }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Total Sudah Dibayar</span>
                                <span class="info-value" id="modalTotalBayar{{ $p['id'] }}">Rp {{ number_format($p['total_bayar'] ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Sisa Pinjaman</span>
                                <span class="info-value" id="modalSisa{{ $p['id'] }}">Rp {{ number_format($p['sisa'], 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- Payment Mode Toggle -->
                        <div class="payment-mode-toggle">
                            <button type="button" class="mode-btn active" onclick="switchMode('otomatis', {{ $p['id'] }})">
                                <i class="bi bi-lightning-fill"></i>
                                Otomatis
                            </button>
                            <button type="button" class="mode-btn" onclick="switchMode('manual', {{ $p['id'] }})">
                                <i class="bi bi-pencil-fill"></i>
                                Manual
                            </button>
                        </div>

                        <!-- Otomatis Section -->
                        <div class="payment-section active" id="otomatis{{ $p['id'] }}">
                            <div class="alert-info">
                                <i class="bi bi-info-circle-fill"></i>
                                <div class="alert-info-text">
                                    Pilih bulan angsuran yang ingin dibayar
                                </div>
                            </div>

                            @php
                                $jumlahPinjaman = $p['jumlah'];
                                $totalBayar = $p['total_bayar'] ?? 0;
                                $sisaPinjaman = $p['sisa'];
                                $nominalAngsuran = $jumlahPinjaman / 5;
                            @endphp

                            <!-- Tabel Angsuran -->
                            <div class="angsuran-table-wrapper">
                                <table class="angsuran-table">
                                    <thead>
                                        <tr>
                                            <th>BULAN KE-</th>
                                            <th>NOMINAL ANGSURAN</th>
                                            <th>SISA PINJAMAN</th>
                                            <th>AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for ($bulan = 1; $bulan <= 5; $bulan++)
                                            @php
                                                $sisaBulanIni = $jumlahPinjaman - ($nominalAngsuran * $bulan);
                                                $sudahBayar = $totalBayar >= ($nominalAngsuran * $bulan);
                                            @endphp
                                            <tr class="{{ $sudahBayar ? 'paid-row' : '' }}">
                                                <td class="text-center">
                                                    <strong>Bulan {{ $bulan }}</strong>
                                                </td>
                                                <td class="text-end">
                                                    <span class="angsuran-nominal">Rp {{ number_format($nominalAngsuran, 0, ',', '.') }}</span>
                                                </td>
                                                <td class="text-end">
                                                    <span class="sisa-nominal">Rp {{ number_format($sisaBulanIni, 0, ',', '.') }}</span>
                                                </td>
                                                <td class="text-center">
                                                    @if ($sudahBayar)
                                                        <span class="badge-paid">
                                                            <i class="bi bi-check-circle-fill"></i> Lunas
                                                        </span>
                                                    @else
                                                        <button type="button"
                                                                class="btn-bayar"
                                                                onclick="bayarAngsuran({{ $p['id'] }}, {{ $bulan }}, {{ $nominalAngsuran }}, {{ $sisaBulanIni }})">
                                                            <i class="bi bi-cash-coin"></i> Bayar
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Manual Section -->
                        <div class="payment-section" id="manual{{ $p['id'] }}">
                            <div class="alert-info">
                                <i class="bi bi-info-circle-fill"></i>
                                <div class="alert-info-text">
                                    Masukkan nominal pembayaran sesuai keinginan (maks: Rp {{ number_format($p['sisa'], 0, ',', '.') }})
                                </div>
                            </div>

                            <div class="manual-input-group">
                                <label>Nominal Pembayaran</label>
                                <input type="number"
                                       class="manual-input"
                                       id="manualInput{{ $p['id'] }}"
                                       placeholder="Masukkan nominal..."
                                       max="{{ $p['sisa'] }}"
                                       oninput="calculateManual({{ $p['id'] }}, {{ $p['total_bayar'] ?? 0 }}, {{ $p['jumlah'] }}, {{ $p['sisa'] }})">
                            </div>

                            <div class="summary-card" id="summaryManual{{ $p['id'] }}" style="display: none;">
                                <div class="summary-row">
                                    <span class="summary-label">Nominal Input</span>
                                    <span class="summary-value" id="nominalInput{{ $p['id'] }}">-</span>
                                </div>
                                <div class="summary-row">
                                    <span class="summary-label">Total Bayar Baru</span>
                                    <span class="summary-value" id="totalBaruManual{{ $p['id'] }}">-</span>
                                </div>
                                <div class="summary-row">
                                    <span class="summary-label">Sisa Pinjaman Baru</span>
                                    <span class="summary-value" id="sisaBaruManual{{ $p['id'] }}">-</span>
                                </div>
                            </div>

                            <button type="button" class="btn-pay" id="btnPayManual{{ $p['id'] }}" onclick="processPayment({{ $p['id'] }}, 'manual')" disabled>
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Konfirmasi Pembayaran</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    @endif

    @push('scripts')
        <script>
            // Store selected amounts for otomatis mode
            const selectedAmounts = {};

            // Bayar angsuran (otomatis mode)
            function bayarAngsuran(id, bulan, nominal, sisaBulanIni) {
                // Get current values
                const totalBayarLama = parseFloat(document.getElementById('modalTotalBayar' + id).textContent.replace(/[^0-9]/g, ''));

                // Calculate new values
                const totalBayarBaru = totalBayarLama + nominal;
                const sisaBaru = sisaBulanIni;

                // Confirm payment
                const konfirmasi = confirm(
                    `Konfirmasi Pembayaran Bulan ${bulan}\n\n` +
                    `Nominal Angsuran: Rp ${nominal.toLocaleString('id-ID')}\n` +
                    `Total Bayar Baru: Rp ${totalBayarBaru.toLocaleString('id-ID')}\n` +
                    `Sisa Pinjaman: Rp ${sisaBaru.toLocaleString('id-ID')}\n\n` +
                    `Lanjutkan pembayaran?`
                );

                if (!konfirmasi) return;

                // Update modal values
                document.getElementById('modalTotalBayar' + id).textContent = 'Rp ' + totalBayarBaru.toLocaleString('id-ID');
                document.getElementById('modalSisa' + id).textContent = 'Rp ' + sisaBaru.toLocaleString('id-ID');

                // Update table values
                document.getElementById('totalBayar' + id).textContent = 'Rp ' + totalBayarBaru.toLocaleString('id-ID');
                document.getElementById('sisaPinjaman' + id).textContent = 'Rp ' + sisaBaru.toLocaleString('id-ID');

                // Update status if lunas
                if (sisaBaru === 0) {
                    const statusBadge = document.getElementById('status' + id);
                    statusBadge.className = 'status-badge status-lunas';
                    statusBadge.innerHTML = '<i class="bi bi-check-circle-fill"></i><span>Lunas</span>';
                }

                // Show success message
                alert('✅ Pembayaran Berhasil!\n\n' +
                      `Bulan ${bulan} - Rp ${nominal.toLocaleString('id-ID')}\n` +
                      'Total Bayar: Rp ' + totalBayarBaru.toLocaleString('id-ID') + '\n' +
                      'Sisa Pinjaman: Rp ' + sisaBaru.toLocaleString('id-ID') +
                      (sisaBaru === 0 ? '\n\n🎉 Status: LUNAS' : ''));

                // Close modal and reload to update table
                const modalEl = document.getElementById('editModal' + id);
                const modal = bootstrap.Modal.getInstance(modalEl);
                modal.hide();

                // Reload page to update angsuran table
                setTimeout(() => {
                    location.reload();
                }, 300);
            }

            // Switch payment mode
            function switchMode(mode, id) {
                // Update toggle buttons
                const modal = document.getElementById('editModal' + id);
                const buttons = modal.querySelectorAll('.mode-btn');
                buttons.forEach(btn => btn.classList.remove('active'));

                // Find and activate the clicked button
                if (mode === 'otomatis') {
                    buttons[0].classList.add('active');
                } else {
                    buttons[1].classList.add('active');
                }

                // Hide all sections
                document.getElementById('otomatis' + id).classList.remove('active');
                document.getElementById('manual' + id).classList.remove('active');

                // Show selected section
                document.getElementById(mode + id).classList.add('active');

                // Reset summaries
                document.getElementById('summaryManual' + id).style.display = 'none';
                document.getElementById('btnPayManual' + id).disabled = true;
                document.getElementById('manualInput' + id).value = '';
                delete selectedAmounts[id];
            }

            // Calculate manual payment
            function calculateManual(id, totalBayarLama, jumlahPinjaman, sisaLama) {
                const input = document.getElementById('manualInput' + id);
                const nominal = parseFloat(input.value) || 0;

                if (nominal > sisaLama) {
                    input.value = sisaLama;
                    return calculateManual(id, totalBayarLama, jumlahPinjaman, sisaLama);
                }

                if (nominal > 0) {
                    const totalBayarBaru = totalBayarLama + nominal;
                    const sisaBaru = sisaLama - nominal;

                    document.getElementById('nominalInput' + id).textContent = 'Rp ' + nominal.toLocaleString('id-ID');
                    document.getElementById('totalBaruManual' + id).textContent = 'Rp ' + totalBayarBaru.toLocaleString('id-ID');
                    document.getElementById('sisaBaruManual' + id).textContent = 'Rp ' + sisaBaru.toLocaleString('id-ID');

                    document.getElementById('summaryManual' + id).style.display = 'block';
                    document.getElementById('btnPayManual' + id).disabled = false;
                } else {
                    document.getElementById('summaryManual' + id).style.display = 'none';
                    document.getElementById('btnPayManual' + id).disabled = true;
                }
            }

            // Process payment (manual mode only now)
            function processPayment(id, mode) {
                let nominal = parseFloat(document.getElementById('manualInput' + id).value) || 0;

                if (!nominal || nominal <= 0) {
                    alert('Masukkan nominal pembayaran terlebih dahulu!');
                    return;
                }

                // Get current values
                const totalBayarLama = parseFloat(document.getElementById('modalTotalBayar' + id).textContent.replace(/[^0-9]/g, ''));
                const sisaLama = parseFloat(document.getElementById('modalSisa' + id).textContent.replace(/[^0-9]/g, ''));

                // Calculate new values
                const totalBayarBaru = totalBayarLama + nominal;
                const sisaBaru = sisaLama - nominal;

                // Update modal values
                document.getElementById('modalTotalBayar' + id).textContent = 'Rp ' + totalBayarBaru.toLocaleString('id-ID');
                document.getElementById('modalSisa' + id).textContent = 'Rp ' + sisaBaru.toLocaleString('id-ID');

                // Update table values
                document.getElementById('totalBayar' + id).textContent = 'Rp ' + totalBayarBaru.toLocaleString('id-ID');
                document.getElementById('sisaPinjaman' + id).textContent = 'Rp ' + sisaBaru.toLocaleString('id-ID');

                // Update status if lunas
                if (sisaBaru === 0) {
                    const statusBadge = document.getElementById('status' + id);
                    statusBadge.className = 'status-badge status-lunas';
                    statusBadge.innerHTML = '<i class="bi bi-check-circle-fill"></i><span>Lunas</span>';
                }

                // Show success message
                alert('✅ Pembayaran Manual Berhasil!\n\n' +
                      'Nominal: Rp ' + nominal.toLocaleString('id-ID') + '\n' +
                      'Total Bayar: Rp ' + totalBayarBaru.toLocaleString('id-ID') + '\n' +
                      'Sisa Pinjaman: Rp ' + sisaBaru.toLocaleString('id-ID') +
                      (sisaBaru === 0 ? '\n\n🎉 Status: LUNAS' : ''));

                // Close modal
                const modalEl = document.getElementById('editModal' + id);
                const modal = bootstrap.Modal.getInstance(modalEl);
                modal.hide();

                // Reset form after modal is hidden
                modalEl.addEventListener('hidden.bs.modal', function resetForm() {
                    document.getElementById('summaryManual' + id).style.display = 'none';
                    document.getElementById('btnPayManual' + id).disabled = true;
                    document.getElementById('manualInput' + id).value = '';

                    // Reset mode to otomatis
                    const buttons = modalEl.querySelectorAll('.mode-btn');
                    buttons[0].classList.add('active');
                    buttons[1].classList.remove('active');
                    document.getElementById('otomatis' + id).classList.add('active');
                    document.getElementById('manual' + id).classList.remove('active');

                    // Remove this event listener
                    modalEl.removeEventListener('hidden.bs.modal', resetForm);
                }, { once: true });

                // Reload to update angsuran table
                setTimeout(() => {
                    location.reload();
                }, 300);
            }

            // Search functionality
            document.getElementById('searchInput').addEventListener('input', function() {
                const searchText = this.value.toLowerCase();
                const rows = document.querySelectorAll('#tableBody tr');

                rows.forEach(row => {
                    const nama = row.getAttribute('data-nama');
                    const nip = row.getAttribute('data-nip').toLowerCase();

                    if (nama.includes(searchText) || nip.includes(searchText)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        </script>
    @endpush
@endsection
