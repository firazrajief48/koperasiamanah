@extends('layouts.dashboard')

@section('title', 'Laporan Pinjaman')
@section('page-title', 'Laporan Pinjaman')

@php
    $role = 'Bendahara Koperasi';
    $nama = auth()->user()->name;
    $routePrefix = 'bendahara_koperasi';
    $showLaporan = true;
@endphp

@section('main-content')
    {{-- ==================== CSS STYLES ==================== --}}
    <style>
        /* ========== Variabel Warna ========== */
        :root {
            --primary-blue: #1e40af;
            --primary-light: #3b82f6;
            --accent-orange: #f97316;
            --dark-navy: #0f172a;
            --success-green: #10b981;
            --danger-red: #ef4444;
            --warning-orange: #f59e0b;
        }

        /* ========== Global Styles ========== */
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0e7ff 100%);
            min-height: 100vh;
        }

        /* ========== Page Header ========== */
        .page-header {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #6366f1 100%);
            border-radius: 20px;
            padding: 1.5rem 2rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 10px 30px rgba(30, 64, 175, 0.2);
            animation: slideDown 0.6s ease-out;
            position: relative;
            z-index: 2;
        }

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

        /* ========== Filter Container ========== */
        .filter-container {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(30px);
            border-radius: 20px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 8px 30px rgba(30, 64, 175, 0.08);
            border: 2px solid rgba(255, 255, 255, 0.6);
            animation: fadeInUp 0.6s ease-out 0.2s both;
        }

        .filter-tabs {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .filter-tab {
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            border: 2px solid transparent;
            background: rgba(226, 232, 240, 0.5);
            color: #64748b;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-tab:hover {
            background: rgba(226, 232, 240, 0.8);
            transform: translateY(-2px);
        }

        .filter-tab.active {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            border-color: #1e40af;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .filter-tab .badge {
            background: rgba(255, 255, 255, 0.3);
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .filter-tab.active .badge {
            background: rgba(255, 255, 255, 0.25);
        }

        /* ========== Table Card ========== */
        .table-modern-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(30px);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(30, 64, 175, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.6);
            animation: fadeInUp 0.6s ease-out 0.4s both;
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

        /* ========== Modern Table ========== */
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

        /* ========== Table Cell Styles ========== */
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

        /* ========== Status Badges ========== */
        .status-column {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.375rem;
            justify-content: center;
        }

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

        .status-menunggu {
            background: rgba(251, 191, 36, 0.15);
            color: #d97706;
            border: 1px solid rgba(251, 191, 36, 0.3);
        }

        .status-verified {
            background: rgba(16, 185, 129, 0.15);
            color: #047857;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .status-rejected {
            background: rgba(239, 68, 68, 0.15);
            color: #dc2626;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .status-sub {
            font-size: 0.688rem;
            color: #94a3b8;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .status-sub i {
            font-size: 0.75rem;
        }

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

        /* ========== Action Buttons ========== */
        .actions-cell {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-download, .btn-detail {
            border: none;
            padding: 0.5rem 1.25rem;
            font-size: 0.813rem;
            font-weight: 600;
            border-radius: 10px;
            color: white;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            text-decoration: none;
            white-space: nowrap;
            width: 100%;
            min-width: 140px;
        }

        .btn-detail {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .btn-detail:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
            color: white;
        }

        .btn-download {
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.2);
        }

        .btn-download:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(139, 92, 246, 0.3);
            color: white;
        }

        .btn-disabled {
            background: linear-gradient(135deg, #e2e8f0, #cbd5e1);
            color: #94a3b8;
            cursor: not-allowed;
            box-shadow: none;
        }

        .btn-disabled:hover {
            transform: none;
            box-shadow: none;
        }

        /* ========== Modal Styles ========== */
        .modal-backdrop {
            background-color: rgba(15, 23, 42, 0.6);
            z-index: 1050;
        }

        .modal-open {
            overflow: hidden !important;
            padding-right: 0 !important;
        }

        .modal {
            overflow-y: auto !important;
            z-index: 1060;
        }

        .modal-dialog {
            margin: 1.75rem auto;
        }

        .modal-content {
            border-radius: 20px;
            border: none;
            overflow: visible;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .modal-header {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #6366f1 100%);
            color: white;
            border: none;
            padding: 1.5rem 2rem;
        }

        .modal-header h5 {
            font-weight: 700;
            font-size: 1.25rem;
        }

        .modal-header .btn-close {
            filter: brightness(0) invert(1);
            opacity: 0.8;
        }

        .modal-body {
            padding: 2rem;
            max-height: 65vh;
            overflow-y: auto;
        }

        .modal-body::-webkit-scrollbar {
            width: 6px;
        }

        .modal-body::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--primary-blue), var(--accent-orange));
            border-radius: 50px;
        }

        /* ========== Detail Section ========== */
        .detail-section {
            background: rgba(248, 250, 252, 0.8);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 2px solid rgba(226, 232, 240, 0.8);
        }

        .detail-section-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--dark-navy);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(226, 232, 240, 0.5);
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: #64748b;
            font-size: 0.875rem;
        }

        .detail-value {
            font-weight: 700;
            color: var(--dark-navy);
            font-size: 0.875rem;
            text-align: right;
        }

        /* ========== Angsuran Table ========== */
        .angsuran-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .angsuran-table thead th {
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.1) 0%, rgba(99, 102, 241, 0.1) 100%);
            padding: 0.75rem;
            font-size: 0.75rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            text-align: center;
            border-bottom: 2px solid rgba(30, 64, 175, 0.2);
        }

        .angsuran-table tbody td {
            padding: 0.75rem;
            text-align: center;
            font-size: 0.875rem;
            border-bottom: 1px solid rgba(226, 232, 240, 0.5);
        }

        .angsuran-table tbody tr:last-child td {
            border-bottom: none;
        }

        .angsuran-table tbody tr:hover {
            background: rgba(59, 130, 246, 0.05);
        }

        /* ========== Histori Info ========== */
        .histori-info {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            border-left: 4px solid var(--primary-blue);
            margin-bottom: 1rem;
        }

        .histori-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid rgba(226, 232, 240, 0.5);
        }

        .histori-title {
            font-size: 0.938rem;
            font-weight: 700;
            color: var(--dark-navy);
        }

        .histori-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.813rem;
            font-weight: 600;
        }

        .histori-badge.approved {
            background: rgba(16, 185, 129, 0.15);
            color: #047857;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .histori-badge.rejected {
            background: rgba(239, 68, 68, 0.15);
            color: #dc2626;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .histori-badge.pending {
            background: rgba(251, 191, 36, 0.15);
            color: #d97706;
            border: 1px solid rgba(251, 191, 36, 0.3);
        }

        .histori-meta {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 1rem;
            font-size: 0.813rem;
            color: #64748b;
        }

        .histori-meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .histori-data {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .histori-data-item {
            background: rgba(248, 250, 252, 0.8);
            border-radius: 8px;
            padding: 0.875rem;
        }

        .histori-data-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.375rem;
        }

        .histori-data-value {
            font-size: 0.938rem;
            font-weight: 700;
            color: var(--dark-navy);
        }

        /* ========== Catatan Box ========== */
        .catatan-box {
            background: rgba(248, 250, 252, 0.8);
            border-left: 4px solid var(--primary-blue);
            border-radius: 8px;
            padding: 1rem;
            margin-top: 1rem;
        }

        .catatan-box .label {
            font-size: 0.75rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .catatan-box .text {
            font-size: 0.875rem;
            color: var(--dark-navy);
            line-height: 1.6;
        }

        /* ========== Empty State ========== */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #94a3b8;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        /* ========== Table Responsive ========== */
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

        /* ========== Responsive Design ========== */
        @media (max-width: 768px) {
            .page-header {
                padding: 1.25rem 1.5rem;
            }

            .filter-container {
                padding: 1.25rem;
            }

            .filter-tabs {
                gap: 0.5rem;
            }

            .filter-tab {
                padding: 0.625rem 1rem;
                font-size: 0.813rem;
            }

            .table-header {
                padding: 1.25rem 1.5rem;
            }

            .modern-table {
                padding: 0 1.5rem 1.5rem;
            }

            .modal-body {
                padding: 1.5rem;
            }

            .detail-row {
                flex-direction: column;
                gap: 0.25rem;
            }

            .detail-value {
                text-align: left;
            }

            .histori-data {
                grid-template-columns: 1fr;
            }
        }
    </style>

    {{-- ==================== HTML CONTENT ==================== --}}

    {{-- Header Halaman --}}
    <div class="page-header">
        <h4>📊 Laporan Pinjaman</h4>
        <p>Daftar pinjaman yang telah diverifikasi dan dapat diunduh dalam format PDF</p>
    </div>

    {{-- Filter Container --}}
    <div class="filter-container">
        <div class="filter-tabs">
            <button class="filter-tab active" data-filter="all">
                <i class="bi bi-grid-fill"></i>
                <span>Semua</span>
                <span class="badge">{{ count($laporan) }}</span>
            </button>
            <button class="filter-tab" data-filter="Disetujui">
                <i class="bi bi-check-circle-fill"></i>
                <span>Disetujui</span>
                <span class="badge">{{ collect($laporan)->where('status', 'Disetujui')->count() }}</span>
            </button>
            <button class="filter-tab" data-filter="Ditolak">
                <i class="bi bi-x-circle-fill"></i>
                <span>Ditolak</span>
                <span class="badge">{{ collect($laporan)->where('status', 'Ditolak')->count() }}</span>
            </button>
            <button class="filter-tab" data-filter="Menunggu">
                <i class="bi bi-clock-history"></i>
                <span>Menunggu Verifikasi</span>
                <span class="badge">{{ collect($laporan)->filter(function($l) { return strpos($l['status'], 'Sedang') !== false; })->count() }}</span>
            </button>
        </div>
    </div>

    {{-- Tabel Laporan --}}
    <div class="table-modern-card">
        <div class="table-header">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <h5>Daftar Laporan Pinjaman</h5>
                    <p>Klik "Detail" untuk melihat informasi lengkap atau "Unduh PDF" untuk laporan yang sudah diverifikasi</p>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Nama Peminjam</th>
                        <th>Jumlah Pinjaman</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @foreach ($laporan as $index => $l)
                        @php
                            $verifier = 'Proses Verifikasi';
                            if (strpos($l['status'], 'Ketua') !== false) {
                                $verifier = 'Ketua Koperasi';
                            } elseif (strpos($l['status'], 'Kepala') !== false || strpos($l['status'], 'BPS') !== false) {
                                $verifier = 'Kepala BPS Kota Surabaya';
                            } elseif ($l['status'] == 'Disetujui' || $l['status'] == 'Ditolak') {
                                $verifier = 'Bendahara Koperasi';
                            }
                        @endphp
                        <tr data-status="{{ $l['status'] }}" data-verifier="{{ $verifier }}">
                            <td>
                                <div class="name-cell">
                                    <div class="name-avatar">
                                        {{ strtoupper(substr($l['nama'], 0, 1)) }}
                                    </div>
                                    <div class="name-info">
                                        <div class="name-primary">{{ $l['nama'] }}</div>
                                        <div class="name-secondary">Anggota Koperasi</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="amount-cell">
                                    <div class="amount-icon">
                                        <i class="bi bi-cash"></i>
                                    </div>
                                    <span>Rp {{ number_format($l['jumlah'], 0, ',', '.') }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="status-column">
                                @if ($l['status'] == 'Disetujui')
                                    <span class="status-badge status-verified">
                                        <i class="bi bi-check-circle-fill"></i>
                                        <span>Disetujui</span>
                                    </span>
                                @elseif ($l['status'] == 'Ditolak')
                                    <span class="status-badge status-rejected">
                                        <i class="bi bi-x-circle-fill"></i>
                                        <span>Ditolak</span>
                                    </span>
                                    <div class="status-sub">
                                        <i class="bi bi-arrow-right-short"></i>
                                        <span>{{ $verifier }}</span>
                                    </div>
                                @else
                                    <span class="status-badge status-menunggu">
                                        <i class="bi bi-clock"></i>
                                        <span>Menunggu Verifikasi</span>
                                    </span>
                                    <div class="status-sub">
                                        <i class="bi bi-arrow-right-short"></i>
                                        <span>{{ $verifier }}</span>
                                    </div>
                                @endif
                                </div>
                            </td>
                            <td>
                                <div class="date-badge">
                                    <i class="bi bi-calendar-event"></i>
                                    <span>{{ date('d/m/Y', strtotime($l['tanggal'])) }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="actions-cell">
                                    <button class="btn-detail" onclick="showDetailModal({{ $index }})">
                                        <i class="bi bi-eye"></i>
                                        <span>Detail</span>
                                    </button>
                                    @if ($l['status'] == 'Diverifikasi')
                                        <a href="{{ $l['link_pdf'] }}" class="btn-download" target="_blank" rel="noopener">
                                            <i class="bi bi-file-earmark-pdf"></i>
                                            <span>Unduh PDF</span>
                                        </a>
                                    @else
                                        <button class="btn-download btn-disabled" disabled>
                                            <i class="bi bi-file-earmark-x"></i>
                                            <span>Belum Tersedia</span>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div id="emptyState" class="empty-state" style="display: none;">
                <i class="bi bi-inbox"></i>
                <p>Tidak ada data yang sesuai dengan filter</p>
            </div>
        </div>
    </div>

    {{-- Modal Detail --}}
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">
                        <i class="bi bi-file-text me-2"></i>Detail Laporan Pinjaman
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- Section Data Peminjam --}}
                    <div class="detail-section">
                        <div class="detail-section-title">
                            🧍 Data Peminjam
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Nama Lengkap</span>
                            <span class="detail-value" id="modalNama">-</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">NIP</span>
                            <span class="detail-value" id="modalNip">-</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Jabatan</span>
                            <span class="detail-value" id="modalJabatan">-</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Golongan</span>
                            <span class="detail-value" id="modalGolongan">-</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">No. HP</span>
                            <span class="detail-value" id="modalNoHp">-</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Email</span>
                            <span class="detail-value" id="modalEmail">-</span>
                        </div>
                    </div>

                    {{-- Section Detail Pinjaman --}}
                    <div class="detail-section">
                        <div class="detail-section-title">
                            💰 Detail Pinjaman
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Jumlah Pinjaman</span>
                            <span class="detail-value" id="modalJumlahPinjaman">-</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Tenor / Angsuran</span>
                            <span class="detail-value" id="modalTenor">-</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Metode Pembayaran</span>
                            <span class="detail-value" id="modalMetodePembayaran">-</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Tanggal Pengajuan</span>
                            <span class="detail-value" id="modalTanggalPengajuan">-</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Tujuan Peminjaman</span>
                            <span class="detail-value" id="modalTujuan">-</span>
                        </div>
                    </div>

                    {{-- Section Riwayat Angsuran --}}
                    <div class="detail-section">
                        <div class="detail-section-title">
                            📊 Riwayat Angsuran yang Dipilih
                        </div>
                        <div class="table-responsive">
                            <table class="angsuran-table">
                                <thead>
                                    <tr>
                                        <th>Bulan Ke-</th>
                                        <th>Nominal Angsuran</th>
                                        <th>Sisa Pinjaman</th>
                                    </tr>
                                </thead>
                                <tbody id="angsuranTableBody">
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Section Verifikasi (Dynamic) --}}
                    <div class="detail-section" id="verifikasiSection">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ==================== JAVASCRIPT ==================== --}}
    <script>
        /* ========== Data Detail Laporan ========== */
        const detailData = [
            @foreach ($laporan as $index => $l)
            {
                nama: "{{ $l['nama'] }}",
                nip: "{{ $l['nip'] }}",
                jabatan: "{{ $l['jabatan'] }}",
                golongan: "{{ $l['golongan'] }}",
                no_hp: "{{ $l['no_hp'] }}",
                email: "{{ $l['email'] }}",
                jumlah_pinjaman: {{ $l['jumlah'] }},
                tenor: "{{ $l['tenor'] }} Bulan",
                metode_pembayaran: "{{ $l['metode_pembayaran'] }}",
                tanggal_pengajuan: "{{ $l['tanggal'] }}",
                tujuan: "{{ $l['tujuan'] }}",
                status: "{{ $l['status'] }}",
                verifier_name: "{{ $l['verifier_name'] ?? '' }}",
                verifier: "{{
                    strpos($l['status'], 'Ketua') !== false ? 'Ketua Koperasi' :
                    (strpos($l['status'], 'Kepala') !== false || strpos($l['status'], 'BPS') !== false ? 'Kepala BPS Kota Surabaya' :
                    ($l['status'] == 'Disetujui' || $l['status'] == 'Ditolak' ? 'Bendahara Koperasi' : 'Proses Verifikasi'))
                }}",
                gaji_pokok: {{ $l['gaji_pokok'] ?? 'null' }},
                sisa_gaji: {{ $l['sisa_gaji'] ?? 'null' }},
                catatan_verifikasi: "{{ $l['catatan_verifikasi'] ?? '' }}",
                tanggal_verifikasi: "{{ $l['tanggal_verifikasi'] ?? '' }}",
                angsuran: [
                    @php
                        $tenor = (int) $l['tenor'];
                        $jumlah = (int) $l['jumlah'];
                        $angsuranPerBulan = $tenor > 0 ? round($jumlah / $tenor) : 0;
                    @endphp
                    @for ($i = 1; $i <= max(1,$tenor); $i++)
                    {
                        bulan: {{ $i }},
                        nominal: {{ $angsuranPerBulan }},
                        sisa: {{ max(0, $jumlah - ($angsuranPerBulan * $i)) }}
                    }{{ $i < $tenor ? ',' : '' }}
                    @endfor
                ]
            }{{ $index < count($laporan) - 1 ? ',' : '' }}
            @endforeach
        ];

        /* ========== Event Listener untuk Filter Tab ========== */
        document.querySelectorAll('.filter-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));

                this.classList.add('active');

                const filter = this.getAttribute('data-filter');
                const rows = document.querySelectorAll('#tableBody tr');
                let visibleCount = 0;

                rows.forEach(row => {
                    const status = row.getAttribute('data-status');

                    if (filter === 'all') {
                        row.style.display = '';
                        visibleCount++;
                    } else if (filter === 'Menunggu') {
                        if (status.includes('Sedang') || status.includes('Ketua') || status.includes('Kepala') || status.includes('BPS')) {
                            row.style.display = '';
                            visibleCount++;
                        } else {
                            row.style.display = 'none';
                        }
                    } else {
                        if (status === filter) {
                            row.style.display = '';
                            visibleCount++;
                        } else {
                            row.style.display = 'none';
                        }
                    }
                });

                document.getElementById('emptyState').style.display = visibleCount === 0 ? 'block' : 'none';
            });
        });

        /* ========== Fungsi untuk Menampilkan Modal Detail ========== */
        function showDetailModal(index) {
            const data = detailData[index];

            document.getElementById('modalNama').textContent = data.nama;
            document.getElementById('modalNip').textContent = data.nip;
            document.getElementById('modalJabatan').textContent = data.jabatan;
            document.getElementById('modalGolongan').textContent = data.golongan;
            document.getElementById('modalNoHp').textContent = data.no_hp;
            document.getElementById('modalEmail').textContent = data.email;

            document.getElementById('modalJumlahPinjaman').textContent = 'Rp ' + data.jumlah_pinjaman.toLocaleString('id-ID');
            document.getElementById('modalTenor').textContent = data.tenor;
            document.getElementById('modalMetodePembayaran').textContent = data.metode_pembayaran;
            document.getElementById('modalTanggalPengajuan').textContent = new Date(data.tanggal_pengajuan).toLocaleDateString('id-ID');
            document.getElementById('modalTujuan').textContent = data.tujuan;

            const angsuranTableBody = document.getElementById('angsuranTableBody');
            angsuranTableBody.innerHTML = '';
            data.angsuran.forEach(item => {
                const row = `
                    <tr>
                        <td><strong>Bulan ${item.bulan}</strong></td>
                        <td>Rp ${item.nominal.toLocaleString('id-ID')}</td>
                        <td>Rp ${item.sisa.toLocaleString('id-ID')}</td>
                    </tr>
                `;
                angsuranTableBody.innerHTML += row;
            });

            loadVerifikasiSection(data);

            const modalElement = document.getElementById('detailModal');
            const bsModal = new bootstrap.Modal(modalElement);
            bsModal.show();
        }

        /* ========== Fungsi untuk Load Section Verifikasi ========== */
        function loadVerifikasiSection(data) {
            const verifikasiSection = document.getElementById('verifikasiSection');

            if (data.status === 'Diverifikasi' || data.status === 'Ditolak') {
                const formatCurrency = (value) => {
                    if (value === null || value === undefined || value === '') {
                        return '-';
                    }
                    const num = Number(value);
                    if (Number.isNaN(num)) {
                        return '-';
                    }
                    return 'Rp ' + num.toLocaleString('id-ID');
                };

                const tanggalVerifikasi = (data.tanggal_verifikasi && data.tanggal_verifikasi !== '')
                    ? data.tanggal_verifikasi
                    : '-';

                verifikasiSection.innerHTML = `
                    <div class="detail-section-title">
                        📋 Histori Verifikasi
                    </div>
                    <div class="histori-info">
                        <div class="histori-header">
                            <div class="histori-title">
                                <i class="bi bi-person-check me-2"></i>${data.verifier_name ? data.verifier_name + ' - Bendahara Koperasi' : 'Bendahara Koperasi'}
                            </div>
                            <span class="histori-badge ${data.status === 'Diverifikasi' ? 'approved' : 'rejected'}">
                                <i class="bi bi-${data.status === 'Diverifikasi' ? 'check' : 'x'}-circle"></i>
                                <span>${data.status}</span>
                            </span>
                        </div>

                        <div class="histori-meta">
                            <div class="histori-meta-item">
                                <i class="bi bi-clock"></i>
                                <span>${tanggalVerifikasi}</span>
                            </div>
                        </div>

                        <div class="histori-data">
                            <div class="histori-data-item">
                                <div class="histori-data-label">Gaji Pokok</div>
                                <div class="histori-data-value">${formatCurrency(data.gaji_pokok)}</div>
                            </div>
                            <div class="histori-data-item">
                                <div class="histori-data-label">Sisa Gaji</div>
                                <div class="histori-data-value">${formatCurrency(data.sisa_gaji)}</div>
                            </div>
                        </div>

                        ${data.catatan_verifikasi ? `
                        <div class="catatan-box">
                            <div class="label">
                                <i class="bi bi-chat-left-quote"></i>
                                <span>Catatan</span>
                            </div>
                            <div class="text">${data.catatan_verifikasi}</div>
                        </div>
                        ` : ''}
                    </div>
                `;
            } else {
                verifikasiSection.innerHTML = `
                    <div class="detail-section-title">
                        📋 Status Verifikasi
                    </div>
                    <div class="histori-info">
                        <div class="histori-header">
                            <div class="histori-title">
                                <i class="bi bi-hourglass-split me-2"></i>Menunggu Proses Verifikasi
                            </div>
                            <span class="histori-badge pending">
                                <i class="bi bi-clock"></i>
                                <span>Sedang Diproses</span>
                            </span>
                        </div>

                        <div class="histori-meta">
                            <div class="histori-meta-item">
                                <i class="bi bi-info-circle"></i>
                                <span>Pinjaman sedang dalam proses verifikasi oleh ${data.verifier}</span>
                            </div>
                        </div>

                        <div class="catatan-box">
                            <div class="label">
                                <i class="bi bi-lightbulb"></i>
                                <span>Informasi</span>
                            </div>
                            <div class="text">Pinjaman ini masih menunggu untuk diverifikasi. Status akan diperbarui setelah proses verifikasi selesai.</div>
                        </div>
                    </div>
                `;
            }
        }
    </script>
@endsection
