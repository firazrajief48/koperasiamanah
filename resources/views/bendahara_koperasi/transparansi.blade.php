@extends('layouts.dashboard')

@section('title', 'Transparansi Keuangan')
@section('page-title', 'Transparansi Keuangan')
@section('page-subtitle', 'Koperasi Amanah BPS Kota Surabaya')

@php
    $role = 'Bendahara Koperasi';
    $nama = 'Siti Nurhaliza';
    $routePrefix = 'bendahara_koperasi';
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
        td:nth-child(3),
        td:nth-child(4),
        td:nth-child(5),
        td:nth-child(6) {
            font-family: 'DM Sans', sans-serif;
            font-weight: 500;
        }
        td:first-child {
            font-weight: 500;
            color: #3b82f6;
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
                            <th class="text-muted text-end">TOTAL BAYAR</th>
                            <th class="text-muted text-end">JUMLAH BAYAR</th>
                            <th class="text-muted text-end">SISA PINJAMAN</th>
                            <th class="text-muted text-center">STATUS</th>
                            <th class="text-muted text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pinjaman as $p)
                            <tr>
                                <td class="align-middle">{{ $p['nama'] }}</td>
                                <td class="align-middle">{{ $p['nip'] }}</td>
                                <td class="align-middle text-end">Rp {{ number_format($p['jumlah'], 0, ',', '.') }}</td>
                                <td class="align-middle text-end">Rp {{ number_format($p['total_bayar'] ?? 0, 0, ',', '.') }}</td>
                                <td class="align-middle text-end">Rp {{ number_format($p['jumlah_bayar'] ?? 0, 0, ',', '.') }}</td>
                                <td class="align-middle text-end">Rp {{ number_format($p['sisa'], 0, ',', '.') }}</td>
                                <td class="align-middle text-center">
                                    @if ($p['status'] == 'Lunas')
                                        <span class="badge bg-success">Lunas</span>
                                    @else
                                        <span class="badge bg-warning">Berjalan</span>
                                    @endif
                                </td>
                                <td class="align-middle text-center">
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $p['id'] }}">
                                        <i class="bi bi-pencil"></i> Edit
                                    </button>
                                </td>
                            </tr>

                            <div class="modal fade" id="editModal{{ $p['id'] }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Pembayaran - {{ $p['nama'] }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="formEdit{{ $p['id'] }}">
                                                <div class="mb-3">
                                                    <label class="form-label">Jumlah Pinjaman</label>
                                                    <input type="text" class="form-control" value="Rp {{ number_format($p['jumlah'], 0, ',', '.') }}"
                                                        readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Total Bayar (Otomatis)</label>
                                                    <input type="text" class="form-control total-bayar-display" id="totalDisplay{{ $p['id'] }}"
                                                        value="Rp {{ number_format($p['total_bayar'] ?? 0, 0, ',', '.') }}" readonly>
                                                    <input type="hidden" class="total-bayar-hidden" id="totalHidden{{ $p['id'] }}"
                                                        value="{{ $p['total_bayar'] ?? 0 }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Jumlah Bayar Hari Ini</label>
                                                    <input type="number" class="form-control jumlah-bayar" data-id="{{ $p['id'] }}"
                                                        data-pinjaman="{{ $p['jumlah'] }}" placeholder="0">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Sisa Pinjaman (Otomatis)</label>
                                                    <input type="text" class="form-control sisa-pinjaman" id="sisa{{ $p['id'] }}"
                                                        value="Rp {{ number_format($p['sisa'], 0, ',', '.') }}" readonly>
                                                </div>
                                                <div class="alert alert-info">
                                                    <small><i class="bi bi-info-circle"></i> Total Bayar akan bertambah otomatis setelah Jumlah Bayar
                                                        disimpan.</small>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.querySelectorAll('.jumlah-bayar').forEach(input => {
                input.addEventListener('input', function() {
                    const id = this.getAttribute('data-id');
                    const jumlahBayar = parseFloat(this.value) || 0;
                    const totalBayarSebelum = parseFloat(document.getElementById(`totalHidden${id}`).value) || 0;
                    const jumlahPinjaman = parseFloat(this.getAttribute('data-pinjaman'));

                    const totalBayarBaru = totalBayarSebelum + jumlahBayar;
                    const sisa = jumlahPinjaman - totalBayarBaru;

                    document.getElementById(`sisa${id}`).value = 'Rp ' + sisa.toLocaleString('id-ID');
                });
            });

            document.querySelectorAll('[id^="formEdit"]').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formId = this.id.replace('formEdit', '');
                    const jumlahBayar = parseFloat(document.querySelector(`.jumlah-bayar[data-id="${formId}"]`).value) || 0;
                    const totalBayarSebelum = parseFloat(document.getElementById(`totalHidden${formId}`).value) || 0;

                    if (jumlahBayar === 0) {
                        alert('Masukkan jumlah pembayaran terlebih dahulu!');
                        return;
                    }

                    const totalBayarBaru = totalBayarSebelum + jumlahBayar;

                    alert('Data pembayaran berhasil diperbarui!\nTotal Bayar sekarang: Rp ' + totalBayarBaru.toLocaleString('id-ID'));

                    document.getElementById(`totalHidden${formId}`).value = totalBayarBaru;
                    document.getElementById(`totalDisplay${formId}`).value = 'Rp ' + totalBayarBaru.toLocaleString('id-ID');
                    document.querySelector(`.jumlah-bayar[data-id="${formId}"]`).value = '';

                    const modal = bootstrap.Modal.getInstance(document.getElementById(`editModal${formId}`));
                    modal.hide();
                });
            });
        </script>
    @endpush
@endsection
