@extends('layouts.dashboard')

@section('title', 'Ajukan Pinjaman')
@section('page-title', 'Ajukan Pinjaman')

@php
    $role = 'Peminjam';
    $nama = $peminjam['nama'];
    $routePrefix = 'peminjam';
    $showAjukan = true;
    $showRiwayat = true;
@endphp

@section('main-content')
    <style>
        .form-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(149, 157, 165, 0.15);
            border: 1px solid #e5e7eb;
            overflow: hidden;
            max-width: 1000px;
            margin: 0 auto;
        }
        .form-card .card-body {
            padding: 1.5rem;
        }
        .form-section {
            background: #f8fafc;
            border-radius: 12px;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }
        .section-title {
            color: #1e293b;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .form-control, .form-select {
            border-radius: 8px;
            padding: 0.625rem 0.875rem;
            border: 2px solid #e2e8f0;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .form-control[readonly] {
            background-color: #f8fafc;
            border-color: #e2e8f0;
        }
        .form-label {
            font-weight: 500;
            color: #475569;
            margin-bottom: 0.5rem;
        }
        .btn {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border: none;
            box-shadow: 0 3px 8px rgba(37, 99, 235, 0.15);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3);
        }
        .btn-secondary {
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            color: #475569;
        }
        .btn-secondary:hover {
            background: #e2e8f0;
        }
        .alert-info {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 8px;
            color: #1e40af;
            padding: 0.75rem;
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }
    </style>
    <div class="card form-card">
        <div class="card-body">
            <form id="formAjukanPinjaman">
                <div class="form-section">
                    <h5 class="section-title"><i class="bi bi-person-vcard me-2"></i>Data Peminjam</h5>
                    <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" value="{{ $peminjam['nama'] }}" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">NIP</label>
                        <input type="text" class="form-control" value="{{ $peminjam['nip'] }}" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jabatan</label>
                        <input type="text" class="form-control" value="{{ $peminjam['jabatan'] }}" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Golongan</label>
                        <input type="text" class="form-control" value="{{ $peminjam['golongan'] }}" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">No HP</label>
                        <input type="text" class="form-control" value="{{ $peminjam['no_hp'] }}" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" value="{{ $peminjam['email'] }}" readonly>
                    </div>
                </div>

                </div>
                <div class="form-section">
                    <h5 class="section-title"><i class="bi bi-cash-coin me-2"></i>Detail Pinjaman</h5>
                    <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Pengajuan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="tanggalPengajuan" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jumlah Pinjaman <span class="text-danger">*</span></label>
                        <select class="form-select" id="jumlahPinjaman" required>
                            <option value="">Pilih Jumlah Pinjaman</option>
                            <option value="3000000">Rp 3.000.000</option>
                            <option value="3500000">Rp 3.500.000</option>
                            <option value="4000000">Rp 4.000.000</option>
                            <option value="4500000">Rp 4.500.000</option>
                            <option value="5000000">Rp 5.000.000</option>
                            <option value="5500000">Rp 5.500.000</option>
                            <option value="6000000">Rp 6.000.000</option>
                            <option value="7000000">Rp 7.000.000</option>
                            <option value="8000000">Rp 8.000.000</option>
                            <option value="9000000">Rp 9.000.000</option>
                            <option value="10000000">Rp 10.000.000</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Metode Pembayaran <span class="text-danger">*</span></label>
                    <select class="form-select" id="metodePembayaran" required>
                        <option value="">Pilih Metode</option>
                        <option value="potong_gaji">Potong Gaji</option>
                        <option value="potong_tukin">Potong Tunjangan Kinerja</option>
                        <option value="transfer">Transfer Manual</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Keperluan <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="keperluan" rows="3" placeholder="Jelaskan keperluan pinjaman" required></textarea>
                </div>

                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> Semua field bertanda <span class="text-danger">*</span> wajib diisi sebelum mengajukan pinjaman.
                </div>

                <button type="submit" class="btn btn-primary">Ajukan Pinjaman</button>
                <a href="{{ route('peminjam.dashboard') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            const today = new Date();
            const formattedDate = today.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
            document.getElementById('tanggalPengajuan').value = formattedDate;

            document.getElementById('formAjukanPinjaman').addEventListener('submit', function(e) {
                e.preventDefault();

                const jumlahPinjaman = document.getElementById('jumlahPinjaman').value;
                const metodePembayaran = document.getElementById('metodePembayaran').value;
                const keperluan = document.getElementById('keperluan').value;

                if (!jumlahPinjaman || !metodePembayaran || !keperluan) {
                    alert('Mohon lengkapi semua field yang wajib diisi!');
                    return;
                }

                alert('Pengajuan pinjaman berhasil disimpan!');
                window.location.href = '{{ route('peminjam.riwayat') }}';
            });
        </script>
    @endpush
@endsection
