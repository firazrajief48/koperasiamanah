@extends('layouts.dashboard')

@section('title', 'Dashboard Bendahara Koperasi')
@section('page-title', 'Dashboard Bendahara Koperasi')

@php
    $role = 'Bendahara Koperasi';
    $nama = 'Siti Nurhaliza';
    $routePrefix = 'bendahara_koperasi';
    $showLaporan = true;
@endphp

@section('main-content')
    <style>
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .dashboard-card {
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
        .badge.bg-warning {
            background: linear-gradient(145deg, #fef9c3 0%, #fef08a 100%) !important;
            color: #854d0e !important;
            border: 1px solid rgba(133, 77, 14, 0.1);
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
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.25);
        }
    </style>

    <div class="dashboard-container">
        <div class="dashboard-card">
            <div class="card-header">
                <h5><i class="bi bi-file-earmark-text me-2"></i>Daftar Pinjaman Masuk</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover">
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
                                <td>{{ $p['id'] }}</td>
                                <td>{{ $p['nama'] }}</td>
                                <td>Rp {{ number_format($p['jumlah'], 0, ',', '.') }}</td>
                                <td>{{ date('d/m/Y', strtotime($p['tanggal'])) }}</td>
                                <td>
                                    <span class="badge bg-warning">{{ $p['status'] }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('bendahara_koperasi.detail', $p['id']) }}" class="btn btn-sm btn-primary">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
