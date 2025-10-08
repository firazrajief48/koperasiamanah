@extends('layouts.dashboard')

@section('title', 'Laporan Pinjaman')
@section('page-title', 'Laporan Pinjaman')

@php
    $role = 'Bendahara Kantor';
    $nama = 'Ahmad Rizki';
    $routePrefix = 'bendahara_kantor';
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
        .btn-info {
            background: linear-gradient(145deg, #0ea5e9, #0284c7);
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
        }
        .btn-info:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(2, 132, 199, 0.2);
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
        .modal-content {
            border-radius: 16px;
            border: none;
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.1);
        }
        .modal-header {
            background: linear-gradient(145deg, #f8fafc, #f1f5f9);
            border-bottom: 1px solid #e2e8f0;
            padding: 1.25rem;
        }
        .modal-body {
            padding: 1.5rem;
        }
        .modal-body h6 {
            color: #1e293b;
            font-size: 1rem;
            margin-bottom: 1rem;
        }
        .table-sm td {
            padding: 0.75rem 1rem;
            color: #475569;
        }
        .table-sm td strong {
            color: #1e293b;
        }
        .table-bordered {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
        }
        .table-bordered td {
            border-color: #e2e8f0;
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
                            <th>NIP</th>
                            <th>Jumlah Pinjaman</th>
                            <th>Tanggal Verifikasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($laporan as $l)
                            <tr>
                                <td>{{ $l['nama'] }}</td>
                                <td>{{ $l['nip'] }}</td>
                                <td>Rp {{ number_format($l['jumlah'], 0, ',', '.') }}</td>
                                <td>{{ date('d/m/Y', strtotime($l['tanggal_verifikasi'])) }}</td>
                                <td>
                                    <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal{{ $l['id'] }}">
                                        <i class="bi bi-eye"></i> Detail
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @foreach ($laporan as $l)
        <div class="modal fade" id="detailModal{{ $l['id'] }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Riwayat Verifikasi - {{ $l['nama'] }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <h6 class="fw-bold mb-3">Informasi Peminjam</h6>
                        <table class="table table-sm mb-0">
                            <tr>
                                <td width="200"><strong>Nama</strong></td>
                                <td>: {{ $l['nama'] }}</td>
                            </tr>
                            <tr>
                                <td><strong>NIP</strong></td>
                                <td>: {{ $l['nip'] }}</td>
                            </tr>
                            <tr>
                                <td><strong>Jumlah Pinjaman</strong></td>
                                <td>: Rp {{ number_format($l['jumlah'], 0, ',', '.') }}</td>
                            </tr>
                        </table>

                        <hr>

                        <h6 class="fw-bold mb-3">Riwayat Verifikasi</h6>
                        <table class="table table-bordered">
                            <tr>
                                <td width="200"><strong>Diverifikasi oleh</strong></td>
                                <td>{{ $l['verifikator'] ?? 'Ahmad Rizki (Bendahara Kantor)' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Verifikasi</strong></td>
                                <td>{{ date('d/m/Y H:i', strtotime($l['tanggal_verifikasi'])) }}</td>
                            </tr>
                            <tr>
                                <td><strong>Status</strong></td>
                                <td><span class="badge bg-success">Diverifikasi</span></td>
                            </tr>
                            <tr>
                                <td><strong>Gaji Pokok</strong></td>
                                <td>Rp {{ number_format($l['gaji_pokok'] ?? 8000000, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Sisa Gaji</strong></td>
                                <td>Rp {{ number_format($l['sisa_gaji'] ?? 5500000, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Catatan</strong></td>
                                <td>{{ $l['catatan'] ?? 'Pengajuan telah diverifikasi dan memenuhi syarat.' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
