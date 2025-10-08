@extends('layouts.dashboard')

@section('title', 'Laporan Pinjaman')
@section('page-title', 'Laporan Pinjaman')

@php
    $role = 'Kepala Koperasi';
    $nama = 'Budi Santoso';
    $routePrefix = 'kepala_koperasi';
    $showLaporan = true;
@endphp

@section('main-content')
    <div class="card">
        <div class="card-header">
            <h5>Laporan Pinjaman yang Sudah Diverifikasi</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
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
                                <td>{{ $l['nip'] ?? '199001012020' }}</td>
                                <td>Rp {{ number_format($l['jumlah'], 0, ',', '.') }}</td>
                                <td>{{ date('d/m/Y', strtotime($l['tanggal_verifikasi'] ?? ($l['tanggal'] ?? now()))) }}</td>
                                <td>
                                    <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal{{ $l['id'] ?? $loop->index }}">
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
        <div class="modal fade" id="detailModal{{ $l['id'] ?? $loop->index }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Riwayat Verifikasi - {{ $l['nama'] }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <h6 class="fw-bold mb-3">Informasi Peminjam</h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="200"><strong>Nama</strong></td>
                                <td>: {{ $l['nama'] }}</td>
                            </tr>
                            <tr>
                                <td><strong>NIP</strong></td>
                                <td>: {{ $l['nip'] ?? '199001012020' }}</td>
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
                                <td>{{ date('d/m/Y H:i', strtotime($l['tanggal_verifikasi'] ?? now())) }}</td>
                            </tr>
                            <tr>
                                <td><strong>Status</strong></td>
                                <td><span class="badge bg-success">{{ $l['status'] ?? 'Diverifikasi' }}</span></td>
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
                                <td><strong>Angsuran</strong></td>
                                <td>{{ $l['angsuran'] ?? '2 kali' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Catatan</strong></td>
                                <td>{{ $l['catatan'] ?? 'Pengajuan telah disetujui dan memenuhi syarat.' }}</td>
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
