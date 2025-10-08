@extends('layouts.dashboard')

@section('title', 'Detail Pengajuan')
@section('page-title', 'Detail Pengajuan Pinjaman')
@section('page-subtitle', 'Koperasi Amanah BPS Kota Surabaya')

@php
    $role = 'Bendahara Kantor';
    $nama = 'Ahmad Rizki';
    $routePrefix = 'bendahara_kantor';
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
            box-shadow: 0 4px 12px rgba(149, 157, 165, 0.1);
            border: 1px solid #e5e7eb;
            overflow: hidden;
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
        }
        .info-grid {
            display: grid;
            gap: 1.25rem;
        }
        .info-item {
            display: flex;
            gap: 0.5rem;
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
            background: #e5e7eb;
            margin: 2rem 0;
        }
        .form-control {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 0.625rem 1rem;
            font-size: 0.9375rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }
        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
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
        }
        .btn-action {
            padding: 0.625rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.9375rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s;
        }
        .btn-verify {
            background: #22c55e;
            color: white;
            border: none;
        }
        .btn-verify:hover {
            background: #16a34a;
        }
        .btn-reject {
            background: #ef4444;
            color: white;
            border: none;
        }
        .btn-reject:hover {
            background: #dc2626;
        }
        .btn-back {
            background: #f1f5f9;
            color: #64748b;
            border: 1px solid #e2e8f0;
        }
        .btn-back:hover {
            background: #e2e8f0;
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
            <form id="formVerifikasi">
                <div class="row">
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
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-sm text-gray-600">Gaji Pokok <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="gajiPokok" placeholder="Rp 0" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-sm text-gray-600">Sisa Gaji <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="sisaGaji" placeholder="Rp 0" required>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label text-sm text-gray-600">Tujuan Peminjaman</label>
                    <textarea class="form-control" rows="3" readonly>{{ $pengajuan['tujuan'] ?? 'Renovasi rumah dan kebutuhan mendesak' }}</textarea>
                </div>

                <div class="mb-4" id="catatanContainer" style="display: none;">
                    <label class="form-label text-sm text-gray-600">Catatan (Wajib diisi jika ditolak) <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="catatan" rows="3" placeholder="Masukkan alasan penolakan..."></textarea>
                </div>

                <div class="alert-custom">
                    <i class="bi bi-info-circle"></i>
                    <span>Pastikan data gaji pokok dan sisa gaji sudah benar sebelum verifikasi.</span>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="button" class="btn-action btn-verify" onclick="verifikasi()">
                        <i class="bi bi-check-circle"></i> Verifikasi
                    </button>
                    <button type="button" class="btn-action btn-reject" onclick="showCatatanTolak()">
                        <i class="bi bi-x-circle"></i> Tolak
                    </button>
                    <a href="{{ route('bendahara_kantor.dashboard') }}" class="btn-action btn-back">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function formatRupiah(value) {
                const number = value.replace(/[^,\d]/g, '');
                return 'Rp ' + number.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            document.getElementById('gajiPokok').addEventListener('input', function(e) {
                e.target.value = formatRupiah(e.target.value);
            });

            document.getElementById('sisaGaji').addEventListener('input', function(e) {
                e.target.value = formatRupiah(e.target.value);
            });

            function showCatatanTolak() {
                document.getElementById('catatanContainer').style.display = 'block';
                document.getElementById('catatan').required = true;
            }

            function verifikasi() {
                const gajiPokok = document.getElementById('gajiPokok').value;
                const sisaGaji = document.getElementById('sisaGaji').value;

                if (!gajiPokok || gajiPokok === 'Rp ') {
                    alert('Gaji Pokok wajib diisi!');
                    return;
                }

                if (!sisaGaji || sisaGaji === 'Rp ') {
                    alert('Sisa Gaji wajib diisi!');
                    return;
                }

                if (confirm('Apakah Anda yakin ingin memverifikasi pengajuan ini?')) {
                    alert('Pengajuan berhasil diverifikasi! Data akan muncul di laporan setelah Anda klik detail.');
                    window.location.href = '{{ route('bendahara_kantor.dashboard') }}';
                }
            }

            document.querySelector('.btn-danger').addEventListener('click', function() {
                const catatan = document.getElementById('catatan').value;

                if (!catatan) {
                    alert('Catatan wajib diisi jika menolak pengajuan!');
                    return;
                }

                if (confirm('Apakah Anda yakin ingin menolak pengajuan ini?')) {
                    alert('Pengajuan ditolak!');
                    window.location.href = '{{ route('bendahara_kantor.dashboard') }}';
                }
            });
        </script>
    @endpush
@endsection
