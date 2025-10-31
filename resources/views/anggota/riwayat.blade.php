@extends('layouts.dashboard')

@section('title', 'Riwayat Pinjaman')
@section('page-title', 'Riwayat Pinjaman')

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
                opacity: 1;
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

        /* Table Styling */
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

        .modern-table thead th:first-child {
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
            padding: 1.25rem 1rem;
            vertical-align: middle;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 12px rgba(30, 64, 175, 0.06);
            position: relative;
            text-align: center;
        }

        .modern-table tbody td:first-child {
            text-align: center;
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
            padding-top: calc(1.25rem + 12px);
        }

        .modern-table tbody tr:first-child td {
            padding-top: 1.25rem;
        }

        /* ID Badge */
        .id-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-light) 100%);
            color: white;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.938rem;
            box-shadow: 0 3px 8px rgba(30, 64, 175, 0.25);
        }

        /* Date Cell */
        .date-cell {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            color: #475569;
            font-size: 0.875rem;
        }

        .date-icon {
            width: 36px;
            height: 36px;
            background: rgba(59, 130, 246, 0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-blue);
            flex-shrink: 0;
        }

        /* Amount Cell */
        .amount-cell {
            font-weight: 700;
            color: var(--dark-navy);
            font-size: 0.938rem;
        }

        /* Tenor Badge */
        .tenor-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.5rem 0.875rem;
            background: rgba(139, 92, 246, 0.1);
            border: 1px solid rgba(139, 92, 246, 0.3);
            border-radius: 50px;
            color: #6d28d9;
            font-weight: 600;
            font-size: 0.813rem;
        }

        /* Status Badge with Details */
        .status-container {
            display: flex;
            flex-direction: column;
            gap: 0.375rem;
            align-items: center;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.813rem;
            font-weight: 600;
            white-space: nowrap;
            width: fit-content;
        }

        .status-badge i {
            font-size: 0.875rem;
        }

        .status-disetujui {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(52, 211, 153, 0.15) 100%);
            color: #047857;
            border: 2px solid rgba(16, 185, 129, 0.3);
        }

        .status-lunas {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(99, 102, 241, 0.15) 100%);
            color: #1e40af;
            border: 2px solid rgba(59, 130, 246, 0.3);
        }

        .status-menunggu {
            background: linear-gradient(135deg, rgba(251, 191, 36, 0.15) 0%, rgba(252, 211, 77, 0.15) 100%);
            color: #d97706;
            border: 2px solid rgba(251, 191, 36, 0.3);
        }

        .status-ditolak {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(248, 113, 113, 0.15) 100%);
            color: #dc2626;
            border: 2px solid rgba(239, 68, 68, 0.3);
        }

        .status-verifikasi {
            background: linear-gradient(135deg, rgba(168, 85, 247, 0.15) 0%, rgba(192, 132, 252, 0.15) 100%);
            color: #7c3aed;
            border: 2px solid rgba(168, 85, 247, 0.3);
        }

        .status-detail {
            font-size: 0.75rem;
            color: #64748b;
            padding-left: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }

        .status-detail i {
            font-size: 0.688rem;
        }

        /* Sisa Pinjaman Cell */
        .sisa-cell {
            display: inline-flex;
            flex-direction: column;
            gap: 0.5rem;
            align-items: center;
            min-width: 140px;
        }

        .sisa-amount {
            font-weight: 700;
            color: var(--dark-navy);
            font-size: 0.938rem;
        }

        .sisa-progress {
            width: 120px;
            height: 6px;
            background: #e2e8f0;
            border-radius: 50px;
            overflow: hidden;
        }

        .sisa-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--success-green), #34d399);
            border-radius: 50px;
            transition: width 0.3s ease;
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
            margin-bottom: 1.5rem;
        }

        /* Button Primary */
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%);
            border: none;
            color: white;
            padding: 0.75rem 1.75rem;
            border-radius: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
            text-decoration: none;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
            color: white;
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

            .table-header {
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

            .id-badge {
                width: 40px;
                height: 40px;
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

        /* Detail Button */
        .btn-detail {
            border: none;
            padding: 0.5rem 1.25rem;
            font-size: 0.813rem;
            font-weight: 600;
            border-radius: 10px;
            color: white;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-detail:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
            color: white;
        }
    </style>

    <!-- Success Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px; border: none; background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(52, 211, 153, 0.1) 100%); border-left: 4px solid #10b981; color: #047857; font-weight: 500; margin-bottom: 1.5rem;">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Page Header -->
    <div class="page-header-modern">
        <div class="d-flex align-items-center gap-3">
            <div class="icon-box"><i class="bi bi-clock-history text-white"></i></div>
            <div>
                <h2>Riwayat Pinjaman 📋</h2>
                <small>Pantau status dan progress semua pengajuan pinjaman Anda</small>
            </div>
        </div>
        @if(count($pinjamans) > 0)
        <div class="badge bg-light text-dark px-3 py-2">
            <i class="bi bi-list-check me-1"></i>{{ count($pinjamans) }} Pengajuan
        </div>
        @endif
    </div>

    <!-- Table Card -->
    <div class="table-modern-card">
        <div class="table-header">
            <h5>Daftar Pengajuan Pinjaman</h5>
            <p>Berikut adalah seluruh riwayat pengajuan pinjaman Anda (diurutkan dari pengajuan terbaru ke terlama)</p>
        </div>

        <div class="table-responsive">
            @if(count($pinjamans) > 0)
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Tenor</th>
                            <th>Status</th>
                            <th>Sisa Pinjaman</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pinjamans as $pinjaman)
                            <tr>
                                <td>
                                    <div class="id-badge">{{ $pinjaman->id }}</div>
                                </td>
                                <td>
                                    <div class="date-cell">
                                        <div class="date-icon">
                                            <i class="bi bi-calendar-event"></i>
                                        </div>
                                        <span>{{ $pinjaman->created_at->format('d/m/Y') }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="amount-cell">
                                        Rp {{ number_format($pinjaman->jumlah_pinjaman, 0, ',', '.') }}
                                    </div>
                                </td>
                                <td>
                                    <span class="tenor-badge">
                                        <i class="bi bi-hourglass-split"></i>
                                        {{ $pinjaman->tenor_bulan }} Bulan
                                    </span>
                                </td>
                                <td>
                                    <div class="status-container">
                                        @if ($pinjaman->status == 'disetujui')
                                            <span class="status-badge status-disetujui">
                                                <i class="bi bi-check-circle-fill"></i>
                                                Disetujui
                                            </span>
                                        @elseif($pinjaman->status == 'lunas')
                                            <span class="status-badge status-lunas">
                                                <i class="bi bi-patch-check-fill"></i>
                                                Lunas
                                            </span>
                                        @elseif($pinjaman->status_detail == 'ditolak')
                                            <span class="status-badge status-ditolak">
                                                <i class="bi bi-x-circle-fill"></i>
                                                Ditolak
                                            </span>
                                            <span class="status-detail">
                                                <i class="bi bi-arrow-right-circle-fill"></i>
                                                Bendahara Koperasi
                                            </span>
                                        @elseif($pinjaman->status_detail == 'menunggu_persetujuan_bendahara')
                                            <span class="status-badge status-menunggu">
                                                <i class="bi bi-clock-fill"></i>
                                                Menunggu Verifikasi
                                            </span>
                                            <span class="status-detail">
                                                <i class="bi bi-arrow-right-circle-fill"></i>
                                                Bendahara Koperasi
                                            </span>
                                        @elseif($pinjaman->status_detail == 'menunggu_persetujuan_ketua')
                                            <span class="status-badge status-menunggu">
                                                <i class="bi bi-clock-fill"></i>
                                                Menunggu Verifikasi
                                            </span>
                                            <span class="status-detail">
                                                <i class="bi bi-arrow-right-circle-fill"></i>
                                                Ketua Koperasi
                                            </span>
                                        @elseif($pinjaman->status_detail == 'menunggu_persetujuan_kepala')
                                            <span class="status-badge status-menunggu">
                                                <i class="bi bi-clock-fill"></i>
                                                Menunggu Verifikasi
                                            </span>
                                            <span class="status-detail">
                                                <i class="bi bi-arrow-right-circle-fill"></i>
                                                Kepala BPS
                                            </span>
                                        @else
                                            <span class="status-badge status-menunggu">
                                                <i class="bi bi-hourglass-split"></i>
                                                {{ ucfirst($pinjaman->status) }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="sisa-amount">
                                        Rp {{ number_format($pinjaman->sisa_pinjaman, 0, ',', '.') }}
                                    </div>
                                </td>
                                <td>
                                    <button
                                        class="btn-detail"
                                        onclick="openDetailModal({
                                            id: {{ $pinjaman->id }},
                                            tanggal: '{{ $pinjaman->created_at->format('Y-m-d') }}',
                                            jumlah: {{ (int) $pinjaman->jumlah_pinjaman }},
                                            tenor: {{ (int) $pinjaman->tenor_bulan }},
                                            status: '{{ $pinjaman->status }}',
                                            status_detail: '{{ $pinjaman->status_detail }}',
                                            alasan: `{{ addslashes($pinjaman->alasan_penolakan ?? '') }}`,
                                            pejabat: `{{ $pinjaman->disetujui_oleh ?? '' }}`
                                        })">
                                        <i class="bi bi-eye"></i>
                                        Detail
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox me-2"></i>
                                    Belum ada riwayat pinjaman
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="bi bi-inbox"></i>
                    </div>
                    <h5>Belum Ada Riwayat Pinjaman</h5>
                    <p>Anda belum mengajukan pinjaman. Klik tombol di bawah untuk memulai pengajuan.</p>
                    <a href="{{ route('anggota.ajukan') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i>
                        Ajukan Pinjaman
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Detail Pinjaman -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; overflow: hidden;">
                <div class="modal-header" style="background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #6366f1 100%); color: white;">
                    <h5 class="modal-title"><i class="bi bi-file-text me-2"></i>Detail Pengajuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 1.25rem 1.25rem;">
                    <div class="mb-2 d-flex justify-content-between">
                        <span class="text-muted">Tanggal Pengajuan</span>
                        <span id="d_tanggal" class="fw-semibold">-</span>
                    </div>
                    <div class="mb-2 d-flex justify-content-between">
                        <span class="text-muted">Jumlah Pinjaman</span>
                        <span id="d_jumlah" class="fw-semibold">-</span>
                    </div>
                    <div class="mb-2 d-flex justify-content-between">
                        <span class="text-muted">Tenor</span>
                        <span id="d_tenor" class="fw-semibold">-</span>
                    </div>
                    <div class="mb-3 d-flex justify-content-between">
                        <span class="text-muted">Status</span>
                        <span id="d_status" class="fw-semibold">-</span>
                    </div>

                    <div id="d_penolakan" style="display:none;">
                        <div class="fw-semibold text-muted mb-1">Alasan Penolakan</div>
                        <div id="d_alasan" class="p-3" style="background:#f8fafc;border-left:4px solid #ef4444;border-radius:8px;">-</div>
                        <div class="mt-2 d-flex align-items-center gap-2 text-muted" style="font-size:0.9rem;">
                            <i class="bi bi-person-badge"></i>
                            <span>Ditolak oleh <span id="d_pejabat">-</span></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function openDetailModal(data) {
                const rupiah = (n) => 'Rp ' + Number(n || 0).toLocaleString('id-ID');
                const statusMap = {
                    'disetujui': 'Disetujui',
                    'lunas': 'Lunas',
                    'menunggu': 'Menunggu Verifikasi'
                };
                const statusDetailMap = {
                    'menunggu_persetujuan_bendahara': 'Menunggu Verifikasi - Bendahara Koperasi',
                    'menunggu_persetujuan_ketua': 'Menunggu Verifikasi - Ketua Koperasi',
                    'menunggu_persetujuan_kepala': 'Menunggu Verifikasi - Kepala BPS',
                    'ditolak': 'Ditolak'
                };
                const roleByStage = {
                    'menunggu_persetujuan_bendahara': 'Bendahara Koperasi',
                    'menunggu_persetujuan_ketua': 'Ketua Koperasi',
                    'menunggu_persetujuan_kepala': 'Kepala BPS',
                    'ditolak': 'Bendahara Koperasi'
                };

                document.getElementById('d_tanggal').textContent = new Date(data.tanggal).toLocaleDateString('id-ID');
                document.getElementById('d_jumlah').textContent = rupiah(data.jumlah);
                document.getElementById('d_tenor').textContent = (data.tenor || 0) + ' Bulan';
                const statusText = statusDetailMap[data.status_detail] || statusMap[data.status] || '-';
                document.getElementById('d_status').textContent = statusText;

                const penolakan = document.getElementById('d_penolakan');
                if (data.status_detail === 'ditolak') {
                    penolakan.style.display = '';
                    document.getElementById('d_alasan').textContent = data.alasan || '-';
                    // Tampilkan nama bendahara dari database + jabatannya
                    const approverName = (data.pejabat || '').trim();
                    const approverRole = roleByStage[data.status_detail] || 'Bendahara Koperasi';
                    document.getElementById('d_pejabat').textContent = (approverName ? approverName + ' - ' : '') + approverRole;
                } else {
                    penolakan.style.display = 'none';
                }

                const modalEl = document.getElementById('detailModal');
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            }
        </script>
    @endpush
@endsection
