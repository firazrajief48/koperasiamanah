@extends('layouts.dashboard')

@section('title', 'Transparansi Keuangan')
@section('page-title', 'Transparansi Keuangan')

@php
    $role = 'Peminjam';
    $nama = auth()->user()->name;
    $routePrefix = 'peminjam';
    $showAjukan = true;
    $showRiwayat = true;
@endphp

@section('main-content')
    <style>
        .transparency-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(149, 157, 165, 0.15);
            border: 1px solid #e5e7eb;
            overflow: hidden;
            max-width: 1200px;
            margin: 0 auto;
        }
        .card-body {
            padding: 1.5rem;
        }
        .search-container {
            margin-bottom: 1.5rem;
            position: relative;
        }
        .search-container i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }
        .search-input {
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border-radius: 100px;
            border: 2px solid #e2e8f0;
            width: 100%;
            max-width: 400px;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            background: #f8fafc;
        }
        .search-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            outline: none;
        }
        .table-container {
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
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
        .bg-success {
            background: linear-gradient(145deg, #dcfce7 0%, #bbf7d0 100%) !important;
            color: #166534 !important;
            border: 1px solid rgba(22, 101, 52, 0.1);
        }
        .bg-warning {
            background: linear-gradient(145deg, #fef9c3 0%, #fef08a 100%) !important;
            color: #854d0e !important;
            border: 1px solid rgba(133, 77, 14, 0.1);
        }
    </style>
    <div class="transparency-card">
        <div class="card-body">
            <div class="search-container">
                <i class="bi bi-search"></i>
                <input type="text" class="search-input" placeholder="Cari berdasarkan nama..." id="searchInput">
            </div>
            <div class="table-container">
                <table class="table" id="dataTable">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>NIP</th>
                            <th>Jumlah Pinjaman</th>
                            <th>Sisa Pinjaman</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pinjaman as $p)
                            <tr data-nama="{{ strtolower($p['nama']) }}">
                                <td>{{ $p['nama'] }}</td>
                                <td>{{ $p['nip'] }}</td>
                                <td>Rp {{ number_format($p['jumlah'], 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($p['sisa'], 0, ',', '.') }}</td>
                                <td>
                                    @if ($p['status'] == 'Lunas')
                                        <span class="badge bg-success">{{ $p['status'] }}</span>
                                    @else
                                        <span class="badge bg-warning">{{ $p['status'] }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('searchInput').addEventListener('keyup', function() {
                const value = this.value.toLowerCase();
                const rows = document.querySelectorAll('#dataTable tbody tr');
                rows.forEach(row => {
                    const nama = row.getAttribute('data-nama');
                    row.style.display = nama.includes(value) ? '' : 'none';
                });
            });
        </script>
    @endpush
@endsection
