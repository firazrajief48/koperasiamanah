@extends('layouts.dashboard')

@section('title', 'Transparansi Keuangan')
@section('page-title', 'Transparansi Keuangan')

@php
    $role = 'Ketua Koperasi';
    $nama = auth()->user()->name;
    $routePrefix = 'ketua_koperasi';
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

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            padding: 0 0 2rem 0;
        }

        .modern-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 12px;
        }

        .modern-table thead th {
            background: transparent;
            border: none;
            padding: 0.75rem 1rem;
            font-size: 0.75rem;
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

        .modern-table thead th:nth-child(6) {
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
            padding: 1.25rem 2rem;
            vertical-align: middle;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 12px rgba(30, 64, 175, 0.06);
            font-size: 0.875rem;
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

        .modern-table tbody td:nth-child(3),
        .modern-table tbody td:nth-child(4),
        .modern-table tbody td:nth-child(5) {
            text-align: right;
        }

        .modern-table tbody td:nth-child(6) {
            text-align: center;
        }

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
            display: block;
        }

        .name-secondary {
            font-size: 0.75rem;
            color: #64748b;
            display: block;
            margin-top: 0.125rem;
        }

        .amount-cell {
            font-size: 0.938rem;
            font-weight: 700;
            color: var(--dark-navy);
            white-space: nowrap;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.375rem;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.75rem;
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

        @media (max-width: 768px) {
            .page-header {
                padding: 1.25rem 1.5rem;
            }

            .table-header {
                padding: 1.25rem 1.5rem;
            }

            .table-responsive {
                padding: 0 1.5rem 1.5rem;
            }
        }
    </style>

    <div class="page-header">
        <h4>💰 Transparansi Keuangan</h4>
        <p>Koperasi Amanah BPS Kota Surabaya - Pantau status pembayaran pinjaman anggota</p>
    </div>

    <div class="search-container">
        <input type="text" class="search-input" placeholder="Cari berdasarkan nama" id="searchInput">
        <i class="fas fa-search search-icon"></i>
    </div>

    <div class="table-modern-card">
        <div class="table-header">
            <h5>Daftar Pinjaman Anggota</h5>
            <p>Pantau status pembayaran pinjaman anggota koperasi secara transparan</p>
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
                    </tr>
                </thead>
                <tbody id="tableBody">
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
                                <span class="amount-cell">Rp {{ number_format($p['total_bayar'] ?? 0, 0, ',', '.') }}</span>
                            </td>
                            <td>
                                <span class="amount-cell">Rp {{ number_format($p['sisa'], 0, ',', '.') }}</span>
                            </td>
                            <td>
                                @if ($p['status'] == 'Lunas')
                                    <span class="status-badge status-lunas">
                                        <i class="bi bi-check-circle-fill"></i>
                                        <span>Lunas</span>
                                    </span>
                                @else
                                    <span class="status-badge status-berjalan">
                                        <i class="bi bi-clock-history"></i>
                                        <span>Berjalan</span>
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
        <script>
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
