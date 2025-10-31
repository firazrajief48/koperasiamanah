@extends('layouts.dashboard')

@section('title', 'Detail Pengajuan')
@section('page-title', 'Detail Pengajuan Pinjaman')

@php
    $role = 'Bendahara Koperasi';
    $nama = auth()->user()->name;
    $routePrefix = 'bendahara_koperasi';
    $showLaporan = true;

    $jumlahPinjaman = $pinjaman->jumlah_pinjaman;
    $tenorBulan = $pinjaman->tenor_bulan;

    $tabelPinjaman = [
        3000000 => [
            2 => 1500000, 3 => 1000000, 4 => 750000, 5 => 600000,
            6 => 500000, 7 => 428571, 8 => 375000, 9 => 333333, 10 => 300000
        ],
        3500000 => [
            2 => 1750000, 3 => 1166667, 4 => 875000, 5 => 700000,
            6 => 583333, 7 => 500000, 8 => 437500
        ],
        4000000 => [
            2 => 2000000, 3 => 1333333, 4 => 1000000, 5 => 800000,
            6 => 666667, 7 => 571429, 8 => 500000
        ],
        4500000 => [
            2 => 2250000, 3 => 1500000, 4 => 1125000, 5 => 900000,
            6 => 750000, 7 => 642857, 8 => 562500, 9 => 500000
        ],
        5000000 => [
            2 => 2500000, 3 => 1666667, 4 => 1250000, 5 => 1000000,
            6 => 833333, 7 => 714286, 8 => 625000, 9 => 555556, 10 => 500000
        ],
        5500000 => [
            2 => 2750000, 3 => 1833333, 4 => 1375000, 5 => 1100000,
            6 => 916667, 7 => 785714, 8 => 687500, 9 => 611111,
            10 => 550000, 11 => 500000
        ],
        6000000 => [
            2 => 3000000, 3 => 2000000, 4 => 1500000, 5 => 1200000,
            6 => 1000000, 7 => 857143, 8 => 750000, 9 => 666667,
            10 => 600000, 11 => 545455, 12 => 500000
        ],
        7000000 => [
            2 => 3500000, 3 => 2333333, 4 => 1750000, 5 => 1400000,
            6 => 1166667, 7 => 1000000, 8 => 875000, 9 => 777778,
            10 => 700000, 11 => 636364, 12 => 583333, 15 => 466667
        ],
        8000000 => [
            2 => 4000000, 3 => 2666667, 4 => 2000000, 5 => 1600000,
            6 => 1333333, 7 => 1142857, 8 => 1000000, 9 => 888889,
            10 => 800000, 11 => 727273, 12 => 666667, 15 => 533333, 16 => 500000
        ],
        9000000 => [
            2 => 4500000, 3 => 3000000, 4 => 2250000, 5 => 1800000,
            6 => 1500000, 7 => 1285714, 8 => 1125000, 9 => 1000000,
            10 => 900000, 11 => 818182, 12 => 750000, 15 => 600000,
            16 => 562500, 17 => 529412, 18 => 500000
        ],
        10000000 => [
            2 => 5000000, 3 => 3333333, 4 => 2500000, 5 => 2000000,
            6 => 1666667, 7 => 1428571, 8 => 1250000, 9 => 1111111,
            10 => 1000000, 11 => 909091, 12 => 833333, 15 => 666667,
            16 => 625000, 17 => 588235, 18 => 555556, 19 => 526316, 20 => 500000
        ],
    ];

    $cicilanPerBulan = isset($tabelPinjaman[$jumlahPinjaman][$tenorBulan])
        ? $tabelPinjaman[$jumlahPinjaman][$tenorBulan]
        : ($jumlahPinjaman / $tenorBulan);
@endphp

@section('main-content')
    <style>
        /* ==================== VARIABEL WARNA ==================== */
        :root {
            --primary-blue: #1e40af;
            --primary-light: #3b82f6;
            --accent-orange: #f97316;
            --dark-navy: #0f172a;
            --success-green: #10b981;
        }

        /* ==================== STYLING DASAR ==================== */
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0e7ff 100%);
            min-height: 100vh;
        }

        /* ==================== ANIMASI ==================== */
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ==================== HEADER HALAMAN ==================== */
        .page-header {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #6366f1 100%);
            border-radius: 20px;
            padding: 1.5rem 2rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 10px 30px rgba(30, 64, 175, 0.2);
            animation: slideDown 0.6s ease-out;
            position: relative;
            z-index: 2;
        }

        .page-header::before,
        .page-header::after {
            content: none !important;
            display: none !important;
        }

        .page-header h4 {
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .page-header p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.875rem;
            margin-bottom: 0;
        }

        /* ==================== KARTU DETAIL ==================== */
        .detail-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(30px);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(30, 64, 175, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.6);
            margin-bottom: 1.5rem;
            animation: fadeInUp 0.6s ease-out both;
        }

        .detail-card:nth-child(2) { animation-delay: 0.1s; }
        .detail-card:nth-child(3) { animation-delay: 0.2s; }
        .detail-card:nth-child(4) { animation-delay: 0.3s; }

        .card-header-modern {
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.08) 0%, rgba(99, 102, 241, 0.08) 100%);
            padding: 1.5rem 2rem;
            border-bottom: 2px solid rgba(30, 64, 175, 0.1);
        }

        .card-header-modern h5 {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--dark-navy);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .card-header-modern h5 i {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-light));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.125rem;
        }

        .card-body-modern {
            padding: 2rem;
        }

        /* ==================== GRID INFORMASI ==================== */
        .info-grid {
            display: grid;
            gap: 1.25rem;
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .info-item:hover {
            background: white;
            transform: translateX(4px);
        }

        .info-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(99, 102, 241, 0.15));
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-blue);
            flex-shrink: 0;
        }

        .info-content {
            flex: 1;
        }

        .info-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.25rem;
        }

        .info-value {
            font-size: 0.938rem;
            font-weight: 600;
            color: var(--dark-navy);
        }

        /* ==================== FORM ==================== */
        .form-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #475569;
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control, .form-select {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 0.938rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            outline: none;
        }

        .form-control:disabled {
            background: #f8fafc;
            color: #64748b;
        }

        /* ==================== TABEL ANGSURAN ==================== */
        .angsuran-table {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .angsuran-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .angsuran-table thead {
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        }

        .angsuran-table thead th {
            padding: 1rem;
            font-size: 0.75rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-align: center;
            border: none;
        }

        .angsuran-table tbody td {
            padding: 1rem;
            text-align: center;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.875rem;
            color: var(--dark-navy);
            font-weight: 500;
        }

        .angsuran-table tbody tr:last-child td {
            border-bottom: none;
        }

        .angsuran-table tbody tr:hover {
            background: rgba(59, 130, 246, 0.03);
        }

        /* ==================== KOTAK ALERT ==================== */
        .alert-modern {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(99, 102, 241, 0.1));
            border: 2px solid rgba(59, 130, 246, 0.2);
            border-radius: 12px;
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 1.5rem 0;
        }

        .alert-modern i {
            font-size: 1.25rem;
            color: var(--primary-blue);
        }

        .alert-modern span {
            color: #1e40af;
            font-size: 0.875rem;
            font-weight: 500;
        }

        /* ==================== TOMBOL AKSI ==================== */
        .action-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-top: 2rem;
        }

        .btn-modern {
            padding: 0.875rem 1.75rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.938rem;
            display: inline-flex;
            align-items: center;
            gap: 0.625rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            cursor: pointer;
        }

        .btn-approve {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .btn-approve:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
        }

        .btn-reject {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .btn-reject:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(239, 68, 68, 0.4);
        }

        .btn-back {
            background: white;
            color: #64748b;
            border: 2px solid #e2e8f0;
        }

        .btn-back:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
        }

        /* ==================== RESPONSIVE ==================== */
        @media (max-width: 768px) {
            .page-header {
                padding: 1.25rem 1.5rem;
            }

            .card-body-modern {
                padding: 1.5rem;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-modern {
                width: 100%;
                justify-content: center;
            }
        }
    </style>

    <!-- ==================== HEADER HALAMAN ==================== -->
    <div class="page-header-modern">
        <div class="d-flex align-items-center gap-3">
            <div class="icon-box"><i class="bi bi-file-earmark-text text-white"></i></div>
            <div>
                <h2>📋 Detail Pengajuan Pinjaman</h2>
                <small>Review dan verifikasi pengajuan pinjaman dari anggota koperasi</small>
            </div>
        </div>
    </div>

    <!-- ==================== DATA PEMINJAM ==================== -->
    <div class="detail-card">
        <div class="card-header-modern">
            <h5>
                <i class="bi bi-person-circle"></i>
                <span>Data Peminjam</span>
            </h5>
        </div>
        <div class="card-body-modern">
            <div class="row">
                <div class="col-md-6">
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="bi bi-person"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Nama Lengkap</div>
                                <div class="info-value">{{ $pinjaman->user->name }}</div>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="bi bi-card-text"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">NIP</div>
                                <div class="info-value">{{ $pinjaman->user->nip ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="bi bi-briefcase"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Jabatan</div>
                                <div class="info-value">{{ $pinjaman->user->jabatan ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="bi bi-award"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Golongan</div>
                                <div class="info-value">{{ $pinjaman->user->golongan ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="bi bi-telephone"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">No. HP</div>
                                <div class="info-value">{{ $pinjaman->user->phone ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Email</div>
                                <div class="info-value">{{ $pinjaman->user->email }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== DETAIL PINJAMAN ==================== -->
    <div class="detail-card">
        <div class="card-header-modern">
            <h5>
                <i class="bi bi-cash-stack"></i>
                <span>Detail Pinjaman</span>
            </h5>
        </div>
        <div class="card-body-modern">
            <div class="row">
                <div class="col-md-6">
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="bi bi-wallet2"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Jumlah Pinjaman</div>
                                <div class="info-value">Rp {{ number_format($jumlahPinjaman, 0, ',', '.') }}</div>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="bi bi-calendar-range"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Tenor/Angsuran</div>
                                <div class="info-value">{{ $tenorBulan }} Bulan</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="bi bi-credit-card"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Metode Pembayaran</div>
                                <div class="info-value">{{ $pinjaman->metode_pembayaran === 'potong_gaji' ? 'Potong Gaji Pokok' : 'Potong Tunjangan Kinerja' }}</div>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="bi bi-calendar-event"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Tanggal Pengajuan</div>
                                <div class="info-value">{{ $pinjaman->created_at->format('d F Y') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <label class="form-label">Tujuan Peminjaman</label>
                <textarea class="form-control" rows="3" disabled>{{ $pinjaman->keterangan ?? '-' }}</textarea>
            </div>
        </div>
    </div>

    <!-- ==================== RIWAYAT ANGSURAN ==================== -->
    <div class="detail-card">
        <div class="card-header-modern">
            <h5>
                <i class="bi bi-clock-history"></i>
                <span>Riwayat Angsuran yang Dipilih</span>
            </h5>
        </div>
        <div class="card-body-modern">
            <div class="angsuran-table">
                <table>
                    <thead>
                        <tr>
                            <th>Bulan Ke-</th>
                            <th>Nominal Angsuran</th>
                            <th>Sisa Pinjaman</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 1; $i <= $tenorBulan; $i++)
                            @php
                                $sisaPinjaman = $jumlahPinjaman - ($i * $cicilanPerBulan);
                            @endphp
                            <tr>
                                <td><strong>Bulan {{ $i }}</strong></td>
                                <td>Rp {{ number_format($cicilanPerBulan, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($sisaPinjaman, 0, ',', '.') }}</td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ==================== FORM VERIFIKASI ==================== -->
    <div class="detail-card">
        <div class="card-header-modern">
            <h5>
                <i class="bi bi-check2-square"></i>
                <span>Form Verifikasi</span>
            </h5>
        </div>
        <div class="card-body-modern">
            <form id="formVerifikasi">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Gaji Pokok <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="gajiPokok" placeholder="Masukkan gaji pokok" value="{{ $pinjaman->gaji_pokok ?? '' }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Sisa Gaji <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="sisaGaji" placeholder="Masukkan sisa gaji" required>
                    </div>
                </div>

                <div class="mb-4" id="catatanContainer" style="display: none;">
                    <label class="form-label">Catatan Penolakan <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="catatan" rows="4" placeholder="Masukkan alasan penolakan pengajuan pinjaman..."></textarea>
                </div>

                <div class="alert-modern">
                    <i class="bi bi-info-circle-fill"></i>
                    <span>Pastikan semua data sudah benar sebelum menyetujui atau menolak pengajuan pinjaman</span>
                </div>

                <div class="action-buttons">
                    <button type="button" class="btn-modern btn-approve" id="approveBtn">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Setujui Pengajuan</span>
                    </button>
                    <button type="button" class="btn-modern btn-reject" onclick="showCatatanTolak()">
                        <i class="bi bi-x-circle-fill"></i>
                        <span>Tolak Pengajuan</span>
                    </button>
                    <a href="{{ route('bendahara_koperasi.dashboard') }}" class="btn-modern btn-back">
                        <i class="bi bi-arrow-left-circle"></i>
                        <span>Kembali</span>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Confirm Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,.2);">
                <div class="modal-header" style="background: white; border: none; padding: 1.25rem 1.5rem; border-radius: 16px 16px 0 0;">
                    <div class="d-flex align-items-center gap-2">
                        <div style="width: 44px; height: 44px; background: linear-gradient(135deg,#3b82f6,#6366f1); border-radius: 10px; display:flex; align-items:center; justify-content:center;">
                            <i class="bi bi-question-lg text-white"></i>
                        </div>
                        <h5 class="modal-title fw-bold mb-0" style="color:#1f2937;">Konfirmasi</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 1rem 1.5rem; color:#475569;">
                    <p id="confirmMessage" class="mb-0">Apakah Anda yakin?</p>
                </div>
                <div class="modal-footer" style="border: none; padding: 0 1.5rem 1.25rem; gap:.5rem;">
                    <button type="button" class="btn" data-bs-dismiss="modal" style="background:white;border:1px solid #d1d5db;color:#475569;border-radius:10px;">Batal</button>
                    <button type="button" class="btn" id="confirmOkBtn" style="background:linear-gradient(135deg,#10b981,#059669); color:white; border:none; border-radius:10px;">Ya, Lanjutkan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1080;">
        <div id="actionToast" class="toast align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true" style="border-radius:12px;">
            <div class="d-flex">
                <div class="toast-body" id="toastMessage">Aksi berhasil.</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            /* ==================== JAVASCRIPT ==================== */
            let catatanShown = false;

            function showCatatanTolak() {
                if (!catatanShown) {
                    document.getElementById('catatanContainer').style.display = 'block';
                    document.getElementById('catatan').required = true;
                    document.getElementById('catatan').focus();
                    catatanShown = true;
                } else {
                    const gajiPokok = document.getElementById('gajiPokok').value;
                    const sisaGaji = document.getElementById('sisaGaji').value;
                    const catatan = document.getElementById('catatan').value;

                    if (!gajiPokok || !sisaGaji) {
                        openToast('Gaji Pokok dan Sisa Gaji wajib diisi!', false);
                        return;
                    }

                    if (!catatan) {
                        openToast('Catatan penolakan wajib diisi!', false);
                        return;
                    }

                    openConfirm('Tolak pengajuan ini?', function () { kirimVerifikasi('tolak'); });
                }
            }

            async function kirimVerifikasi(aksi) {
                const gajiPokok = document.getElementById('gajiPokok').value;
                const sisaGaji = document.getElementById('sisaGaji').value;
                const catatan = document.getElementById('catatan')?.value || '';

                if (!gajiPokok || !sisaGaji) {
                    alert('⚠️ Gaji Pokok dan Sisa Gaji wajib diisi!');
                    return;
                }

                if (aksi === 'tolak' && !catatan) {
                    alert('⚠️ Catatan penolakan wajib diisi!');
                    return;
                }

                try {
                    const res = await fetch('{{ route('bendahara_koperasi.verifikasi') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            id: {{ $pinjaman->id }},
                            gaji_pokok: gajiPokok,
                            sisa_gaji: sisaGaji,
                            catatan: catatan,
                            aksi: aksi
                        })
                    });
                    const json = await res.json();
                    if (json.success) {
                        openToast(json.message, true);
                        setTimeout(function(){ window.location.href = '{{ route('bendahara_koperasi.dashboard') }}'; }, 900);
                    } else {
                        openToast('Terjadi kesalahan.', false);
                    }
                } catch (e) {
                    openToast('Gagal mengirim data.', false);
                }
            }

            // Approve button handler uses modal confirm
            document.querySelector('.btn-approve')?.addEventListener('click', function() {
                const gajiPokok = document.getElementById('gajiPokok').value;
                const sisaGaji = document.getElementById('sisaGaji').value;
                if (!gajiPokok || !sisaGaji) {
                    openToast('Gaji Pokok dan Sisa Gaji wajib diisi!', false);
                    return;
                }
                openConfirm('Setujui pengajuan ini?', function () { kirimVerifikasi('setujui'); });
            });

            // Helpers: Modal confirm & toast
            function openConfirm(message, onOk) {
                const msgEl = document.getElementById('confirmMessage');
                const okBtn = document.getElementById('confirmOkBtn');
                msgEl.textContent = message;
                const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
                okBtn.onclick = null; // pastikan tidak ada handler lama
                okBtn.onclick = function () { modal.hide(); onOk && onOk(); };
                modal.show();
            }

            function openToast(message, success = true) {
                const toastEl = document.getElementById('actionToast');
                const bodyEl = document.getElementById('toastMessage');
                bodyEl.textContent = message;
                toastEl.classList.remove('bg-danger','bg-success');
                toastEl.classList.add(success ? 'bg-success' : 'bg-danger');
                const t = new bootstrap.Toast(toastEl, { delay: 1500 });
                t.show();
            }
        </script>
    @endpush
@endsection
