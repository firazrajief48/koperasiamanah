@extends('layouts.dashboard')

@section('title', 'Detail Pengajuan')
@section('page-title', 'Detail Pengajuan Pinjaman')
@section('page-subtitle', 'Koperasi Amanah BPS Kota Surabaya')

@php
    $role = 'Kepala Koperasi';
    $nama = 'Budi Santoso';
    $routePrefix = 'kepala_koperasi';
    $showLaporan = true;
@endphp

@section('main-content')
    <style>
        .detail-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        .detail-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(149, 157, 165, 0.15);
            border: 1px solid #e5e7eb;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .detail-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 28px rgba(149, 157, 165, 0.2);
        }
        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .section-title i {
            color: #3b82f6;
            font-size: 1.25rem;
        }
        .info-grid {
            display: grid;
            gap: 1.25rem;
        }
        .info-item {
            display: flex;
            gap: 0.5rem;
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        .info-item:hover {
            background: rgba(59, 130, 246, 0.05);
        }
        .info-label {
            color: #64748b;
            font-weight: 500;
            font-size: 0.9375rem;
            flex: 0 0 150px;
        }
        .info-value {
            color: #1e293b;
            font-weight: 500;
            font-size: 0.9375rem;
        }
        .divider {
            height: 1px;
            background: linear-gradient(to right, #e5e7eb 0%, #f8fafc 100%);
            margin: 2rem 0;
        }
        .form-control {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 0.9375rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease;
        }
        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            transform: translateY(-1px);
        }
        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #475569;
            font-size: 0.875rem;
        }
        .alert-custom {
            background: linear-gradient(145deg, #eff6ff, #dbeafe);
            border: 1px solid rgba(59, 130, 246, 0.1);
            color: #1e40af;
            padding: 1rem 1.25rem;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.875rem;
            margin: 1.5rem 0;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.08);
        }
        .alert-custom i {
            font-size: 1.25rem;
            color: #3b82f6;
        }
        .btn-action {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.9375rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
        }
        .btn-verify {
            background: linear-gradient(145deg, #22c55e, #16a34a);
            color: white;
            border: none;
            box-shadow: 0 4px 12px rgba(22, 163, 74, 0.15);
        }
        .btn-verify:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(22, 163, 74, 0.25);
        }
        .btn-reject {
            background: linear-gradient(145deg, #ef4444, #dc2626);
            color: white;
            border: none;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.15);
        }
        .btn-reject:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(220, 38, 38, 0.25);
        }
        .btn-back {
            background: linear-gradient(145deg, #f8fafc, #f1f5f9);
            color: #64748b;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 4px rgba(148, 163, 184, 0.05);
        }
        .btn-back:hover {
            transform: translateY(-2px);
            background: #f1f5f9;
            box-shadow: 0 4px 8px rgba(148, 163, 184, 0.1);
        }
    </style>

    <div class="detail-container">
        <div class="detail-card">
            <div class="card-body p-4">
                <h5 class="section-title"><i class="bi bi-person"></i>Data Peminjam</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Nama</div>
                                <div class="info-value">: {{ $pengajuan['nama'] }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">NIP</div>
                                <div class="info-value">: {{ $pengajuan['nip'] }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Jabatan</div>
                                <div class="info-value">: {{ $pengajuan['jabatan'] }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Golongan</div>
                                <div class="info-value">: {{ $pengajuan['golongan'] }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">No HP</div>
                                <div class="info-value">: {{ $pengajuan['no_hp'] }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Email</div>
                                <div class="info-value">: {{ $pengajuan['email'] }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Tanggal</div>
                                <div class="info-value">: {{ date('d/m/Y', strtotime($pengajuan['tanggal_pengajuan'])) }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="divider"></div>

                <h5 class="section-title"><i class="bi bi-cash"></i>Detail Pinjaman</h5>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Jumlah Pinjaman</div>
                                <div class="info-value">: Rp {{ number_format($pengajuan['jumlah_pinjaman'], 0, ',', '.') }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Metode Pembayaran</div>
                                <div class="info-value">: {{ $pengajuan['metode_pembayaran'] }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Angsuran</div>
                                <div class="info-value">: {{ $pengajuan['berapa_kali'] ?? '2 kali' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Gaji Pokok</div>
                                <div class="info-value">: Rp {{ number_format($pengajuan['gaji_pokok'], 0, ',', '.') }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Sisa Gaji</div>
                                <div class="info-value">: Rp {{ number_format($pengajuan['sisa_gaji'], 0, ',', '.') }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Angsuran per Bulan</div>
                                <div class="info-value">: Rp {{ number_format($pengajuan['angsuran_per_bulan'], 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Tujuan Peminjaman</label>
                    <textarea class="form-control" rows="3" readonly>{{ $pengajuan['tujuan'] ?? 'Renovasi rumah dan kebutuhan mendesak lainnya' }}</textarea>
                </div>

                <div class="alert-custom">
                    <i class="bi bi-info-circle"></i>
                    <span>Data di atas tidak dapat diubah. Silakan tinjau sebelum menyetujui.</span>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="button" class="btn-action btn-verify" onclick="setujui()">
                        <i class="bi bi-check-circle"></i> Setujui
                    </button>
                    <button type="button" class="btn-action btn-reject" onclick="tolak()">
                        <i class="bi bi-x-circle"></i> Tolak
                    </button>
                    <a href="{{ route('kepala_koperasi.dashboard') }}" class="btn-action btn-back">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function setujui() {
                if (confirm('Apakah Anda yakin ingin menyetujui pengajuan ini?')) {
                    alert('Pengajuan berhasil disetujui!');
                    window.location.href = '{{ route('kepala_koperasi.dashboard') }}';
                }
            }

            function tolak() {
                if (confirm('Apakah Anda yakin ingin menolak pengajuan ini?')) {
                    alert('Pengajuan ditolak!');
                    window.location.href = '{{ route('kepala_koperasi.dashboard') }}';
                }
            }
        </script>
    @endpush
@endsection
