@extends('layouts.dashboard')

@section('title', 'Laporan Pinjaman')
@section('page-title', 'Laporan Pinjaman')

@php
    $role = 'Bendahara Koperasi';
    $nama = 'Siti Nurhaliza';
    $routePrefix = 'bendahara_koperasi';
    $showLaporan = true;
@endphp

@section('main-content')
    <style>
        .laporan-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .laporan-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(149, 157, 165, 0.15);
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }
        .card-header {
            background: linear-gradient(145deg, #f8fafc, #f1f5f9);
            padding: 1.25rem;
            border-bottom: 1px solid #e2e8f0;
        }
        .card-header h5 {
            color: #1e293b;
            font-weight: 600;
            margin: 0;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .table-container {
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
        }
        .table {
            margin-bottom: 0;
        }
        .table thead {
            background: linear-gradient(145deg, #f1f5f9 0%, #f8fafc 100%);
        }
        .table thead th {
            padding: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            color: #475569;
            border: none;
        }
        .table td {
            padding: 1rem;
            vertical-align: middle;
            border: none;
            font-size: 0.875rem;
        }
        .table tbody tr {
            transition: all 0.2s ease;
            border-bottom: 1px solid #f1f5f9;
        }
        .table tbody tr:hover {
            background: rgba(59, 130, 246, 0.05);
            transform: translateY(-1px);
        }
        .table tbody tr:last-child {
            border-bottom: none;
        }
        .btn-primary {
            background: linear-gradient(145deg, #3b82f6, #2563eb);
            border: none;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
            transition: all 0.2s ease;
            color: white;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.25);
            color: white;
        }
        .btn-secondary {
            background: linear-gradient(145deg, #94a3b8, #64748b);
            border: none;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(100, 116, 139, 0.15);
            transition: all 0.2s ease;
            color: white;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-secondary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(100, 116, 139, 0.25);
            color: white;
        }
        .badge {
            padding: 0.5rem 1rem;
            border-radius: 100px;
            font-weight: 500;
            font-size: 0.75rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .badge::before {
            content: '';
            display: inline-block;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
            opacity: 0.8;
        }
        .badge.bg-success {
            background: linear-gradient(145deg, #dcfce7 0%, #bbf7d0 100%) !important;
            color: #166534 !important;
            border: 1px solid rgba(22, 101, 52, 0.1);
        }
        .badge.bg-warning {
            background: linear-gradient(145deg, #fef9c3 0%, #fef08a 100%) !important;
            color: #854d0e !important;
            border: 1px solid rgba(133, 77, 14, 0.1);
        }
    </style>

    <div class="laporan-container">
        <div class="laporan-card">
            <div class="card-header">
                <h5><i class="bi bi-file-text me-2"></i>Laporan Pinjaman yang Sudah Diverifikasi</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Peminjam</th>
                                <th>Jumlah Pinjaman</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($laporan as $l)
                                <tr>
                                    <td>{{ $l['nama'] }}</td>
                                    <td>Rp {{ number_format($l['jumlah'], 0, ',', '.') }}</td>
                                    <td>
                                        @if ($l['status'] == 'Diverifikasi')
                                            <span class="badge bg-success">{{ $l['status'] }}</span>
                                        @else
                                            <span class="badge bg-warning">{{ $l['status'] }}</span>
                                        @endif
                                    </td>
                                    <td>{{ date('d/m/Y', strtotime($l['tanggal'])) }}</td>
                                    <td>
                                        @if ($l['status'] == 'Diverifikasi')
                                            <a href="{{ $l['link_pdf'] }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-file-pdf"></i> Unduh PDF
                                            </a>
                                        @else
                                            <button class="btn btn-sm btn-secondary" disabled>
                                                <i class="bi bi-file-pdf"></i> Belum Tersedia
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
