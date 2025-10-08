@extends('layouts.dashboard')

@section('title', 'Transparansi Keuangan')
@section('page-title', 'Transparansi Keuangan')
@section('page-subtitle', 'Koperasi Amanah BPS Kota Surabaya')

@php
    $role = 'Bendahara Kantor';
    $nama = 'Ahmad Rizki';
    $routePrefix = 'bendahara_kantor';
    $showLaporan = true;
@endphp

@section('main-content')
    <div class="mb-4">
        <div class="search-container">
            <input type="text" class="form-control search-input" placeholder="Cari berdasarkan nama..." id="searchInput">
            <i class="fas fa-search search-icon"></i>
        </div>
    </div>

    <style>
        .search-container {
            position: relative;
            max-width: 500px;
        }
        .search-input {
            padding: 0.75rem 1rem;
            padding-left: 3rem;
            border-radius: 100px;
            border: 1px solid #e5e7eb;
            width: 100%;
            font-size: 0.875rem;
            line-height: 1.25rem;
            background: #ffffff;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            transition: all 0.2s;
        }
        .search-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
            pointer-events: none;
        }
        .transparansi-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .transparansi-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(149, 157, 165, 0.15);
            border: 1px solid #e5e7eb;
            overflow: hidden;
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
            white-space: nowrap;
        }
        .table td {
            padding: 1rem;
            vertical-align: middle;
            border: none;
            font-size: 0.875rem;
            color: #1e293b;
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
        .badge.bg-success {
            background: #E7F6EC !important;
            color: #0E4F2C !important;
        }
        .badge.bg-warning {
            background: #FEF5E7 !important;
            color: #976312 !important;
        }
        td:nth-child(3),
        td:nth-child(4) {
            font-family: 'DM Sans', sans-serif;
            font-weight: 500;
        }
        td:first-child {
            font-weight: 500;
            color: #3b82f6;
        }
    </style>

    <div class="transparansi-container">
        <div class="transparansi-card">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-muted">NAMA</th>
                            <th class="text-muted">NIP</th>
                            <th class="text-muted text-end">JUMLAH PINJAMAN</th>
                            <th class="text-muted text-end">SISA PINJAMAN</th>
                            <th class="text-muted text-center">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pinjaman as $p)
                            <tr>
                                <td class="align-middle">{{ $p['nama'] }}</td>
                                <td class="align-middle">{{ $p['nip'] }}</td>
                                <td class="align-middle text-end">Rp {{ number_format($p['jumlah'], 0, ',', '.') }}</td>
                                <td class="align-middle text-end">Rp {{ number_format($p['sisa'], 0, ',', '.') }}</td>
                                <td class="align-middle text-center">
                                    @if ($p['status'] == 'Lunas')
                                        <span class="badge bg-success">Lunas</span>
                                    @else
                                        <span class="badge bg-warning">Berjalan</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
