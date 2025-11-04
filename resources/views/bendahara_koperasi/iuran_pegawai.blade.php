@extends('layouts.dashboard')

@section('title', 'Iuran Pegawai')
@section('page-title', 'Iuran Pegawai')

@php
    $role = 'Bendahara Koperasi';
    $nama = auth()->user()->name;
    $routePrefix = 'bendahara_koperasi';
    $showLaporan = true;
@endphp

@section('main-content')
    <style>
        .welcome-banner {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #6366f1 100%);
            border-radius: 20px;
            padding: 1.25rem 1.5rem;
            margin-bottom: 1.25rem;
            color: white;
            box-shadow: 0 10px 30px rgba(30, 64, 175, 0.08);
        }

        .card-dashboard {
            background: white;
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(11, 73, 98, 0.08);
        }

        .table thead th {
            vertical-align: middle;
            font-weight: 700;
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .month-tabs {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-bottom: 1.5rem;
        }

        .month-tab {
            padding: 0.5rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: 0.875rem;
        }

        .month-tab:hover {
            border-color: #3b82f6;
            background-color: #eff6ff;
            transform: translateY(-2px);
        }

        .month-tab.active {
            background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%);
            color: white;
            border-color: #3b82f6;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .btn-detail {
            background-color: #3b82f6;
            border: none;
            color: white;
            padding: 0.4rem 0.6rem;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
        }

        .btn-detail:hover {
            background-color: #2563eb;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .btn-danger {
            background-color: #ef4444;
            border: none;
            color: white;
            padding: 0.4rem 0.6rem;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s ease;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
        }

        .btn-danger:hover {
            background-color: #dc2626;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        /* Styling untuk tombol action yang seragam */
        .btn-action-custom {
            padding: 0.625rem 1.25rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 180px;
            white-space: nowrap;
        }

        .btn-bayar-semua {
            background: linear-gradient(135deg, #f97316 0%, #fb923c 100%);
            border: none;
            color: white;
        }

        .btn-bayar-semua:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(249, 115, 22, 0.4);
            color: white;
        }

        .btn-tambah-manual {
            border: 2px solid #10b981;
            background: white;
            color: #10b981;
        }

        .btn-tambah-manual:hover {
            background: #10b981;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
        }

        .btn-export-excel {
            border: 2px solid #3b82f6;
            background: white;
            color: #3b82f6;
        }

        .btn-export-excel:hover {
            background: #3b82f6;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.3);
        }

        .badge-lunas {
            background-color: #10b981;
            color: white;
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.75rem;
            display: inline-block;
        }

        .badge-belum {
            background-color: #ef4444;
            color: white;
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.75rem;
            display: inline-block;
        }

        .filter-section {
            background-color: #f8f9fa;
            padding: 1.5rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
        }

        .rekap-box {
            background: linear-gradient(135deg, #f97316 0%, #fb923c 100%);
            color: white;
            padding: 2rem;
            border-radius: 12px;
            text-align: center;
            margin-top: 1.5rem;
            box-shadow: 0 6px 20px rgba(249, 115, 22, 0.3);
        }

        .rekap-box h5 {
            font-size: 1rem;
            opacity: 0.9;
            margin-bottom: 0.5rem;
        }

        .rekap-box h2 {
            font-size: 2.5rem;
            font-weight: 700;
        }

        .toast-custom {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 350px;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
            border-width: 0.15em;
        }

        .nama-pegawai-link {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .nama-pegawai-link:hover {
            color: #1e40af;
            text-decoration: underline;
        }

        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
            z-index: 100;
        }

        .form-select, .form-control {
            border-radius: 8px;
            border: 1px solid #d1d5db;
            padding: 0.6rem 1rem;
        }

        .form-select:focus, .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        #searchInput {
            border-radius: 8px 0 0 8px;
        }

        #clearSearchBtn {
            border-radius: 0 8px 8px 0;
            border-left: none;
        }

        #clearSearchBtn:hover {
            background-color: #f3f4f6;
            color: #ef4444;
        }

        .input-group:focus-within #searchInput {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
    </style>

    <div class="welcome-banner">
        <div>
            <h3 class="fw-bold mb-0">💰 Iuran Pegawai</h3>
            <small class="opacity-75">Kelola pembayaran iuran pegawai koperasi per bulan</small>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toastNotification" class="toast-custom" style="display: none;">
        <div class="alert alert-dismissible fade show mb-0" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <span id="toastMessage"></span>
            <button type="button" class="btn-close" onclick="hideToast()"></button>
        </div>
    </div>

    <!-- Main Card -->
    <div class="card card-dashboard position-relative">
        <div id="loadingOverlay" class="loading-overlay" style="display: none;">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <div class="card-body p-4">
            <!-- Filter Section -->
            <div class="filter-section">
                <div class="row align-items-end mb-3">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">
                            <i class="bi bi-calendar3 me-1"></i>Pilih Tahun
                        </label>
                        <select id="yearFilter" class="form-select">
                            @for ($year = $maxYear; $year >= $minYear; $year--)
                                <option value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-9 text-end d-flex gap-2 justify-content-end">
                        <button class="btn btn-action-custom btn-tambah-manual" onclick="openTambahManualModal()">
                            <i class="bi bi-plus-circle me-2"></i>Tambah Iuran Manual
                        </button>
                        <button class="btn btn-action-custom btn-bayar-semua" onclick="bayarSemua()">
                            <i class="bi bi-cash-stack me-2"></i>Bayar Semua Pegawai
                        </button>
                        <button class="btn btn-action-custom btn-export-excel" onclick="exportData()">
                            <i class="bi bi-download me-2"></i>Export Excel
                        </button>
                    </div>
                </div>

                <!-- Month Tabs -->
                <label class="form-label fw-bold d-block mb-2">
                    <i class="bi bi-calendar-month me-1"></i>Pilih Bulan
                </label>
                <div class="month-tabs" id="monthTabs">
                    @php
                        $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                                  'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                    @endphp
                    @foreach ($bulan as $index => $namaBulan)
                        <div class="month-tab {{ $index + 1 == date('n') ? 'active' : '' }}"
                             data-month="{{ $index + 1 }}"
                             onclick="selectMonth({{ $index + 1 }})">
                            🔹 {{ $namaBulan }}
                        </div>
                    @endforeach
                </div>

                <!-- Search Section -->
                <div class="row mt-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold">
                            <i class="bi bi-search me-1"></i>Cari Pegawai
                        </label>
                        <div class="input-group">
                            <input type="text" id="searchInput" class="form-control"
                                   placeholder="Cari berdasarkan nama, NIP, atau jabatan..."
                                   autocomplete="off">
                            <button class="btn btn-outline-secondary" type="button" id="clearSearchBtn" style="display: none;" onclick="clearSearch()">
                                <i class="bi bi-x-circle"></i>
                            </button>
                        </div>
                        <small class="text-muted">Tekan Enter atau tunggu beberapa detik untuk mencari</small>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table align-middle" id="iuranTable">
                    <thead>
                        <tr>
                            <th style="width:50px">No</th>
                            <th>Nama Pegawai</th>
                            <th>NIP</th>
                            <th>Jabatan</th>
                            <th style="width:150px">Total Iuran (Rp)</th>
                            <th style="width:140px">Status Pembayaran</th>
                            <th style="width:180px">Tanggal Waktu Pembayaran</th>
                            <th style="width:100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="text-muted mt-2">Memuat data...</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Rekap Total -->
            <div class="rekap-box">
                <h5 class="fw-bold mb-2">📊 Total Pemasukan Bulan Ini</h5>
                <h2 class="fw-bold mb-0" id="totalPemasukan">Rp 0</h2>
                <small class="d-block mt-2 opacity-90" id="rekapDetail">0 dari 0 pegawai sudah membayar</small>
            </div>
        </div>
    </div>

    <!-- Modal Riwayat Iuran -->
    <div class="modal fade" id="riwayatModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-clock-history me-2"></i>Riwayat Iuran Pegawai
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <h6 class="fw-bold mb-3" id="namaPegawaiModal"></h6>
                    <div id="riwayatContent">
                        <div class="text-center py-4">
                            <div class="spinner-border text-primary" role="status"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Iuran Manual -->
    <div class="modal fade" id="tambahManualModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Iuran Manual
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="formTambahManual">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="bi bi-person me-1"></i>Pilih Pegawai <span class="text-danger">*</span>
                            </label>
                            <select id="manualPegawaiId" class="form-select" required>
                                <option value="">-- Pilih Pegawai --</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">
                                    <i class="bi bi-calendar-month me-1"></i>Bulan
                                </label>
                                <input type="text" id="manualBulan" class="form-control" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">
                                    <i class="bi bi-calendar-year me-1"></i>Tahun
                                </label>
                                <input type="text" id="manualTahun" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="bi bi-cash me-1"></i>Nominal (Rp) <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="manualNominal" class="form-control" value="" placeholder="Masukkan nominal iuran (contoh: 50000)" required inputmode="numeric">
                            <small class="text-muted">Iuran standar: Rp 50.000 (dapat diubah sesuai kebutuhan)</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="bi bi-calendar-event me-1"></i>Tanggal & Waktu Bayar
                            </label>
                            <input type="datetime-local" id="manualTanggalBayar" class="form-control" value="{{ date('Y-m-d\TH:i') }}">
                            <small class="text-muted">Kosongkan untuk menggunakan waktu real-time sekarang</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle me-2"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Bayar Semua (Website Style) -->
    <div class="modal fade" id="massConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius:16px; border:none; overflow:hidden;">
                <div class="modal-header" style="background: linear-gradient(135deg, #2563eb, #3b82f6); color:white; border:none;">
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-cash-stack me-2"></i>Konfirmasi Pembayaran Massal
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2"><strong>Bulan:</strong> <span id="massBulanText"></span></div>
                    <div class="mb-2"><strong>Nominal per pegawai:</strong> Rp <span id="massNominalText"></span></div>
                    <div class="alert alert-warning d-flex align-items-start" style="border-radius:12px;">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <div>
                            Hanya bulan yang dipilih yang akan ditandai sebagai <strong>Terbayar</strong>. Bulan lainnya tidak terpengaruh.
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border:none;">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="massConfirmBtn">
                        <i class="bi bi-check2-circle me-1"></i>Ya, Proses
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus Iuran (Website Style) -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius:16px; border:none; overflow:hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
                <div class="modal-header" style="background: linear-gradient(135deg, #ef4444, #dc2626); color:white; border:none; padding: 1.25rem 1.5rem;">
                    <h5 class="modal-title fw-bold mb-0" style="font-size: 1.1rem;">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>Konfirmasi Hapus Pembayaran
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="opacity: 0.9;"></button>
                </div>
                <div class="modal-body" style="padding: 1.5rem;">
                    <p class="mb-3 fw-semibold" style="color: #374151; font-size: 0.95rem;">Hapus pembayaran iuran untuk:</p>
                    <div class="mb-3 p-3" style="background-color: #f9fafb; border-radius: 8px; border-left: 3px solid #ef4444;">
                        <div class="mb-2">
                            <strong style="color: #374151;">Nama Pegawai:</strong>
                            <span id="deleteNamaPegawai" style="color: #1f2937; display: block; margin-top: 0.25rem;">-</span>
                        </div>
                        <div class="mb-2">
                            <strong style="color: #374151;">Nominal Iuran:</strong>
                            <span id="deleteNominalText" style="color: #1f2937; display: block; margin-top: 0.25rem; font-weight: 600; color: #059669;">-</span>
                        </div>
                        <div class="mb-2">
                            <strong style="color: #374151;">Tanggal Pembayaran:</strong>
                            <span id="deleteTanggalText" style="color: #1f2937; display: block; margin-top: 0.25rem;">-</span>
                        </div>
                        <div>
                            <strong style="color: #374151;">Bulan:</strong>
                            <span id="deleteBulanText" style="color: #1f2937; display: block; margin-top: 0.25rem;">-</span>
                        </div>
                    </div>
                    <div class="alert alert-danger d-flex align-items-start" style="border-radius:12px; border: 1px solid #fecaca; background-color: #fef2f2; margin-bottom: 0;">
                        <i class="bi bi-exclamation-triangle-fill me-2 mt-1" style="font-size: 1.1rem;"></i>
                        <div style="color: #991b1b; line-height: 1.6;">
                            Record pembayaran ini akan <strong>dihapus permanen</strong> dari sistem. Tindakan ini tidak dapat dibatalkan.
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border:none; padding: 1rem 1.5rem; background-color: #f9fafb; border-radius: 0 0 16px 16px; display: flex; gap: 0.75rem; justify-content: flex-end;">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border-radius: 8px; font-weight: 500; width: 150px; height: 42px; padding: 0; display: flex; align-items: center; justify-content: center; border: 1px solid #d1d5db;">
                        Batal
                    </button>
                    <button type="button" class="btn btn-danger" id="deleteConfirmBtn" style="border-radius: 8px; font-weight: 600; width: 150px; height: 42px; padding: 0; white-space: nowrap; display: flex; align-items: center; justify-content: center; gap: 0.5rem; border: none;">
                        <i class="bi bi-trash" style="font-size: 1rem;"></i>
                        <span>Ya, Hapus</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Configuration
        const NOMINAL_IURAN = 50000;
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.content || '';

        // State Management
        let currentMonth = {{ date('n') }};
        let currentYear = {{ date('Y') }};
        let currentData = [];
        let currentSearch = '';
        let searchTimeout = null;

        /**
         * ========================================
         * CORE FUNCTIONS
         * ========================================
         */

        // Select Month
        function selectMonth(month) {
            currentMonth = month;
            document.querySelectorAll('.month-tab').forEach(tab => {
                tab.classList.remove('active');
                if (parseInt(tab.dataset.month) === month) {
                    tab.classList.add('active');
                }
            });
            loadData();
        }

        // Load Data from Server
        function loadData() {
            showLoading(true);

            // Build URL with search parameter
            let url = `/bendahara-koperasi/iuran-pegawai/data?bulan=${currentMonth}&tahun=${currentYear}&status=semua`;
            if (currentSearch.trim() !== '') {
                url += `&search=${encodeURIComponent(currentSearch.trim())}`;
            }

            fetch(url, {
                method: 'GET',
                credentials: 'same-origin',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                }
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    currentData = result.data;
                    renderTable(result.data);
                    calculateTotal(result.data);
                } else {
                    showError('Gagal memuat data');
                    renderEmptyTable();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showError('Terjadi kesalahan koneksi');
                renderEmptyTable();
            })
            .finally(() => {
                showLoading(false);
            });
        }

        // Render Table
        function renderTable(data) {
            const tbody = document.getElementById('tableBody');
            tbody.innerHTML = '';

            if (data.length === 0) {
                renderEmptyTable();
                return;
            }

            data.forEach((pegawai, index) => {
                const sudahBayar = pegawai.sudah_bayar == 1;
                const nominal = parseInt(pegawai.nominal) || 0;
                const tanggalBayar = pegawai.tanggal_bayar || null;
                const iuranId = pegawai.iuran_id || null;

                let tanggalDisplay = '-';
                if (tanggalBayar) {
                    // Parse langsung dari string (format: YYYY-MM-DD HH:MM:SS)
                    // Waktu sudah dalam timezone Asia/Jakarta dari server
                    // Parse manual tanpa menggunakan Date constructor untuk menghindari konversi timezone
                    const parts = tanggalBayar.split(' ');
                    const datePart = parts[0].split('-'); // YYYY-MM-DD
                    const timePart = parts[1] ? parts[1].split(':') : ['00', '00', '00']; // HH:MM:SS

                    const day = datePart[2];
                    const month = datePart[1];
                    const year = datePart[0];
                    const hours = timePart[0].padStart(2, '0');
                    const minutes = timePart[1].padStart(2, '0');

                    tanggalDisplay = `${day}/${month}/${year} ${hours}:${minutes}`;
                }

                const row = `
                    <tr>
                        <td class="text-center">${index + 1}</td>
                        <td>
                            <span class="fw-bold text-dark">${pegawai.nama}</span>
                        </td>
                        <td>
                            <span class="fw-bold text-dark">${pegawai.nip}</span>
                        </td>
                        <td>
                            <span class="fw-bold text-dark">${pegawai.jabatan}</span>
                        </td>
                        <td class="fw-bold ${sudahBayar ? 'text-success' : 'text-muted'}">
                            Rp ${nominal.toLocaleString('id-ID')}
                        </td>
                        <td>
                            ${sudahBayar
                                ? '<span class="badge-lunas">✓ Lunas</span>'
                                : '<span class="badge-belum">✗ Belum Lunas</span>'}
                        </td>
                        <td>
                            <span class="text-dark">
                                ${tanggalDisplay}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-2 justify-content-center">
                                <button class="btn btn-detail btn-sm"
                                        onclick="showRiwayat(${pegawai.id}, '${pegawai.nama.replace(/'/g, "\\'")}'); return false;"
                                        title="Lihat Riwayat Iuran">
                                    <i class="bi bi-eye"></i>
                                </button>
                                ${sudahBayar ? `
                                <button class="btn btn-danger btn-sm"
                                        onclick="hapusIuran(${iuranId ? iuranId : 'null'}, '${pegawai.nama.replace(/'/g, "\\'")}', ${pegawai.id}, ${nominal}, '${tanggalDisplay}'); return false;"
                                        title="Hapus Pembayaran Iuran">
                                    <i class="bi bi-trash"></i>
                                </button>
                                ` : ''}
                            </div>
                        </td>
                    </tr>
                `;
                tbody.innerHTML += row;
            });
        }

        // Render Empty Table
        function renderEmptyTable() {
            const tbody = document.getElementById('tableBody');
            tbody.innerHTML = `
                <tr>
                    <td colspan="8" class="text-center text-muted py-5">
                        <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                        <p class="mt-2">Tidak ada data sesuai filter</p>
                    </td>
                </tr>
            `;
        }

        // Calculate Total
        function calculateTotal(data) {
            let totalPemasukan = 0;
            let jumlahLunas = 0;

            // Hitung jumlah pegawai unik berdasarkan user_id (id)
            let uniquePegawaiIds = new Set();
            let uniqueLunasIds = new Set();

            data.forEach(pegawai => {
                // Tambahkan id pegawai ke Set untuk menghitung pegawai unik
                uniquePegawaiIds.add(pegawai.id);

                if (pegawai.sudah_bayar == 1) {
                    totalPemasukan += parseFloat(pegawai.nominal) || 0;
                    // Tambahkan id pegawai yang sudah lunas ke Set untuk menghitung pegawai unik yang sudah lunas
                    uniqueLunasIds.add(pegawai.id);
                }
            });

            // Hitung jumlah pegawai unik yang sudah lunas
            jumlahLunas = uniqueLunasIds.size;
            // Hitung total pegawai unik
            let totalPegawai = uniquePegawaiIds.size;

            document.getElementById('totalPemasukan').textContent =
                'Rp ' + totalPemasukan.toLocaleString('id-ID');

            document.getElementById('rekapDetail').textContent =
                `${jumlahLunas} dari ${totalPegawai} pegawai sudah membayar`;
        }

        /**
         * ========================================
         * PAYMENT FUNCTIONS
         * ========================================
         */

        // Bayar Iuran Single - Tidak digunakan lagi karena sudah ada fitur bayar semua
        // Function ini tetap ada untuk backward compatibility tapi sebaiknya menggunakan modal juga
        function bayarIuran(pegawaiId, namaPegawai) {
            // Untuk saat ini tetap menggunakan confirm, bisa diubah ke modal jika diperlukan
            if (!confirm(`Konfirmasi pembayaran iuran sebesar Rp ${NOMINAL_IURAN.toLocaleString('id-ID')} untuk:\n\n${namaPegawai}\n\nLanjutkan?`)) {
                return;
            }

            showLoading(true);

            fetch('/bendahara-koperasi/iuran-pegawai/bayar', {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                body: JSON.stringify({
                    pegawai_id: pegawaiId,
                    bulan: currentMonth,
                    tahun: currentYear,
                    nominal: NOMINAL_IURAN
                })
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    loadData();
                    showToast(`✅ Pembayaran iuran bulan ${getBulanName(currentMonth)} untuk ${namaPegawai} berhasil dicatat!`);
                } else {
                    showError(result.message || 'Pembayaran gagal');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showError('Terjadi kesalahan saat memproses pembayaran');
            })
            .finally(() => {
                showLoading(false);
            });
        }

        // Bayar Semua Pegawai - HANYA UNTUK BULAN YANG DIPILIH SAJA
        function bayarSemua() {
            // Tampilkan modal konfirmasi website style
            document.getElementById('massBulanText').textContent = `${getBulanName(currentMonth)} ${currentYear}`;
            document.getElementById('massNominalText').textContent = NOMINAL_IURAN.toLocaleString('id-ID');
            const modal = new bootstrap.Modal(document.getElementById('massConfirmModal'));
            modal.show();

            // Binding sekali lalu lepaskan agar tidak dobel
            const btn = document.getElementById('massConfirmBtn');
            const handler = () => {
                btn.removeEventListener('click', handler);
                modal.hide();

                showLoading(true);
                fetch('/bendahara-koperasi/iuran-pegawai/bayar-semua', {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    body: JSON.stringify({
                        bulan: currentMonth,
                        tahun: currentYear,
                        nominal: NOMINAL_IURAN
                    })
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        loadData();
                        showToast(`✅ Berhasil mencatat pembayaran untuk ${result.count} pegawai!\nTotal: Rp ${result.total.toLocaleString('id-ID')}`);
                    } else {
                        showError(result.message || 'Pembayaran gagal');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showError('Terjadi kesalahan saat memproses pembayaran massal');
                })
                .finally(() => {
                    showLoading(false);
                });
            };
            btn.addEventListener('click', handler);
        }

        /**
         * ========================================
         * MANUAL IURAN FUNCTIONS
         * ========================================
         */

        // Load daftar pegawai untuk dropdown (semua pegawai, tidak hanya yang sudah punya record iuran)
        function loadPegawaiList() {
            fetch('/bendahara-koperasi/iuran-pegawai/pegawai-list', {
                method: 'GET',
                credentials: 'same-origin',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                }
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    const select = document.getElementById('manualPegawaiId');
                    select.innerHTML = '<option value="">-- Pilih Pegawai --</option>';

                    result.data.forEach(pegawai => {
                        const option = document.createElement('option');
                        option.value = pegawai.id;
                        option.textContent = `${pegawai.nama} - ${pegawai.nip}`;
                        select.appendChild(option);
                    });
                }
            })
            .catch(error => {
                console.error('Error loading pegawai:', error);
                showError('Gagal memuat daftar pegawai');
            });
        }

        // Open Tambah Manual Modal
        function openTambahManualModal() {
            loadPegawaiList();

            // Set bulan dan tahun sesuai yang dipilih
            document.getElementById('manualBulan').value = getBulanName(currentMonth);
            document.getElementById('manualTahun').value = currentYear;
            // Nominal default kosong, user bebas mengisi berapapun
            document.getElementById('manualNominal').value = '';

            // Set tanggal dan waktu sekarang untuk datetime-local
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            document.getElementById('manualTanggalBayar').value = `${year}-${month}-${day}T${hours}:${minutes}`;

            document.getElementById('manualPegawaiId').value = '';

            new bootstrap.Modal(document.getElementById('tambahManualModal')).show();
        }

        // Format nominal dengan titik ribuan
        function formatNominal(value) {
            // Hapus semua karakter non-numerik
            const numericValue = value.replace(/[^\d]/g, '');
            // Format dengan titik sebagai separator ribuan
            return numericValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        // Parse nominal dari format dengan titik
        function parseNominal(value) {
            // Hapus semua titik dan ambil hanya angka
            return parseFloat(value.replace(/\./g, '')) || 0;
        }

        // Event listener untuk format otomatis nominal
        document.getElementById('manualNominal')?.addEventListener('input', function(e) {
            const cursorPos = e.target.selectionStart;
            const oldValue = e.target.value;
            const newValue = formatNominal(oldValue);

            e.target.value = newValue;

            // Restore cursor position setelah format
            const diff = newValue.length - oldValue.length;
            e.target.setSelectionRange(cursorPos + diff, cursorPos + diff);
        });

        // Handle form tambah manual
        document.getElementById('formTambahManual')?.addEventListener('submit', function(e) {
            e.preventDefault();

            const pegawaiId = document.getElementById('manualPegawaiId').value;
            // Parse nominal yang sudah diformat dengan titik
            const nominal = parseNominal(document.getElementById('manualNominal').value);
            const tanggalBayar = document.getElementById('manualTanggalBayar').value;

            if (!pegawaiId || nominal <= 0) {
                showError('Mohon lengkapi data yang diperlukan');
                return;
            }

            // Cari nama pegawai
            const pegawaiOption = document.getElementById('manualPegawaiId').selectedOptions[0];
            const namaPegawai = pegawaiOption ? pegawaiOption.textContent.split(' - ')[0] : '';

            showLoading(true);

            fetch('/bendahara-koperasi/iuran-pegawai/tambah-manual', {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                body: JSON.stringify({
                    pegawai_id: pegawaiId,
                    bulan: currentMonth,
                    tahun: currentYear,
                    nominal: nominal,
                    tanggal_bayar: tanggalBayar || null
                })
            })
            .then(response => {
                return response.json().then(data => {
                    if (!response.ok) {
                        return Promise.reject({ data, status: response.status });
                    }
                    return data;
                });
            })
            .then(result => {
                if (result.success) {
                    bootstrap.Modal.getInstance(document.getElementById('tambahManualModal')).hide();
                    loadData();
                    showToast(`✅ ${result.message || `Berhasil menambahkan iuran manual untuk ${namaPegawai}!\nNominal: Rp ${nominal.toLocaleString('id-ID')}`}`);
                } else {
                    showError(result.message || 'Gagal menambahkan iuran');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (error.data && error.data.message) {
                    showError(error.data.message);
                } else {
                    showError('Terjadi kesalahan saat menambahkan iuran');
                }
            })
            .finally(() => {
                showLoading(false);
            });
        });

        // Variable untuk menyimpan data modal hapus (di scope global untuk akses handler)
        let currentDeleteData = null;

        // Hapus Iuran - Tampilkan Modal Konfirmasi
        function hapusIuran(iuranId, namaPegawai, pegawaiId, nominal, tanggalBayar) {
            // Simpan data untuk digunakan saat konfirmasi
            currentDeleteData = {
                iuranId: iuranId,
                pegawaiId: pegawaiId,
                namaPegawai: namaPegawai
            };

            // Set data di modal
            document.getElementById('deleteNamaPegawai').textContent = namaPegawai;
            document.getElementById('deleteNominalText').textContent = 'Rp ' + (nominal || 0).toLocaleString('id-ID');
            document.getElementById('deleteTanggalText').textContent = tanggalBayar || '-';
            document.getElementById('deleteBulanText').textContent = `${getBulanName(currentMonth)} ${currentYear}`;

            // Tampilkan modal
            const modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
            modal.show();

            // Binding handler untuk tombol konfirmasi
            const btn = document.getElementById('deleteConfirmBtn');
            // Hapus event listener sebelumnya jika ada
            const newBtn = btn.cloneNode(true);
            btn.parentNode.replaceChild(newBtn, btn);

            newBtn.addEventListener('click', function() {
                modal.hide();
                showLoading(true);

                // Pastikan iuranId adalah number atau null, bukan string
                const validIuranId = (currentDeleteData.iuranId && currentDeleteData.iuranId !== 'null' && currentDeleteData.iuranId !== null && !isNaN(currentDeleteData.iuranId))
                    ? parseInt(currentDeleteData.iuranId)
                    : null;

                // Kirim iuran_id jika tersedia, jika tidak gunakan pegawai_id + bulan (backward compatibility)
                const requestBody = validIuranId ? {
                    iuran_id: validIuranId
                } : {
                    pegawai_id: currentDeleteData.pegawaiId,
                    bulan: currentMonth,
                    tahun: currentYear
                };

                fetch('/bendahara-koperasi/iuran-pegawai/hapus', {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    body: JSON.stringify(requestBody)
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        loadData();
                        showToast(`✅ Pembayaran iuran untuk ${currentDeleteData.namaPegawai} berhasil dihapus!`);
                    } else {
                        showError(result.message || 'Gagal menghapus pembayaran');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showError('Terjadi kesalahan saat menghapus pembayaran');
                })
                .finally(() => {
                    showLoading(false);
                    currentDeleteData = null; // Clear data setelah selesai
                });
            });
        }

        /**
         * ========================================
         * RIWAYAT FUNCTIONS
         * ========================================
         */

        function showRiwayat(pegawaiId, namaPegawai) {
            document.getElementById('namaPegawaiModal').textContent = namaPegawai;
            document.getElementById('riwayatContent').innerHTML =
                '<div class="text-center py-4"><div class="spinner-border text-primary"></div></div>';

            fetch(`/bendahara-koperasi/iuran-pegawai/riwayat/${pegawaiId}?tahun=${currentYear}`, {
                method: 'GET',
                credentials: 'same-origin',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                }
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    renderRiwayat(result.riwayat);
                } else {
                    document.getElementById('riwayatContent').innerHTML =
                        '<div class="alert alert-danger">Gagal memuat riwayat</div>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('riwayatContent').innerHTML =
                    '<div class="alert alert-danger">Terjadi kesalahan koneksi</div>';
            });

            new bootstrap.Modal(document.getElementById('riwayatModal')).show();
        }

        function renderRiwayat(riwayat) {
            const bulanNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                               'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            const riwayatMap = {};
            riwayat.forEach(item => {
                riwayatMap[item.bulan] = item;
            });

            let html = '<div class="table-responsive"><table class="table table-sm table-hover">';
            html += '<thead class="table-light"><tr><th>Bulan</th><th>Status</th><th>Nominal</th><th>Tanggal Bayar</th></tr></thead><tbody>';

            let totalBayar = 0;
            let jumlahBulanLunas = 0;

            for (let i = 1; i <= 12; i++) {
                const item = riwayatMap[i];

                // Opsi A: Jika tidak ada data, default BELUM terbayar
                const statusTerbayar = item && item.status !== 'belum';
                const nominalDisplay = statusTerbayar ? (parseInt(item?.nominal) || 0) : 0;
                const tanggalDisplay = statusTerbayar && item && item.tanggal_bayar ? formatTanggal(item.tanggal_bayar) : '-';

                if (statusTerbayar) {
                    totalBayar += nominalDisplay;
                    jumlahBulanLunas++;
                }

                html += `<tr class="${statusTerbayar ? 'table-success' : ''}">
                    <td><strong>${bulanNames[i-1]}</strong></td>
                    <td>${statusTerbayar ? '<span class="badge-lunas">✓ Lunas</span>' : '<span class="badge-belum">✗ Belum</span>'}</td>
                    <td class="fw-bold">${statusTerbayar ? 'Rp ' + nominalDisplay.toLocaleString('id-ID') : '-'}</td>
                    <td>${tanggalDisplay}</td>
                </tr>`;
            }

            html += '</tbody>';
            html += `<tfoot class="table-light">
                <tr>
                    <td colspan="2" class="fw-bold">Total Terbayar (${jumlahBulanLunas} bulan):</td>
                    <td colspan="2" class="fw-bold text-success">Rp ${totalBayar.toLocaleString('id-ID')}</td>
                </tr>
            </tfoot>`;
            html += '</table></div>';

            document.getElementById('riwayatContent').innerHTML = html;
        }

        /**
         * ========================================
         * UTILITY FUNCTIONS
         * ========================================
         */

        function getBulanName(bulan) {
            const names = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                          'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            return names[bulan - 1];
        }

        function formatTanggal(tanggal) {
            const date = new Date(tanggal);
            return date.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
        }

        function showLoading(show) {
            document.getElementById('loadingOverlay').style.display = show ? 'flex' : 'none';
        }

        function showToast(message) {
            const toast = document.getElementById('toastNotification');
            const alert = toast.querySelector('.alert');

            document.getElementById('toastMessage').textContent = message;
            alert.classList.remove('alert-danger');
            alert.classList.add('alert-success');

            toast.style.display = 'block';

            setTimeout(() => {
                hideToast();
            }, 5000);
        }

        function showError(message) {
            const toast = document.getElementById('toastNotification');
            const alert = toast.querySelector('.alert');

            document.getElementById('toastMessage').textContent = '❌ ' + message;
            alert.classList.remove('alert-success');
            alert.classList.add('alert-danger');

            toast.style.display = 'block';

            setTimeout(() => {
                hideToast();
            }, 5000);
        }

        function hideToast() {
            document.getElementById('toastNotification').style.display = 'none';
        }

        function exportData() {
            window.location.href = `/bendahara-koperasi/iuran-pegawai/export?bulan=${currentMonth}&tahun=${currentYear}`;
        }

        /**
         * ========================================
         * SEARCH FUNCTIONS
         * ========================================
         */

        function clearSearch() {
            document.getElementById('searchInput').value = '';
            currentSearch = '';
            document.getElementById('clearSearchBtn').style.display = 'none';
            loadData();
        }

        function handleSearch() {
            const searchValue = document.getElementById('searchInput').value;
            currentSearch = searchValue;

            // Show/hide clear button
            if (searchValue.trim() !== '') {
                document.getElementById('clearSearchBtn').style.display = 'block';
            } else {
                document.getElementById('clearSearchBtn').style.display = 'none';
            }

            // Clear previous timeout
            if (searchTimeout) {
                clearTimeout(searchTimeout);
            }

            // Debounce search - wait 500ms after user stops typing
            searchTimeout = setTimeout(() => {
                loadData();
            }, 500);
        }

        /**
         * ========================================
         * EVENT LISTENERS
         * ========================================
         */

        document.addEventListener('DOMContentLoaded', function() {
            // Load initial data
            loadData();

            // Year filter
            document.getElementById('yearFilter')?.addEventListener('change', function() {
                currentYear = parseInt(this.value);
                loadData();
            });

            // Search input
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                // Search on input (with debounce)
                searchInput.addEventListener('input', handleSearch);

                // Search on Enter key (immediate)
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        if (searchTimeout) {
                            clearTimeout(searchTimeout);
                        }
                        const searchValue = searchInput.value;
                        currentSearch = searchValue;
                        if (searchValue.trim() !== '') {
                            document.getElementById('clearSearchBtn').style.display = 'block';
                        } else {
                            document.getElementById('clearSearchBtn').style.display = 'none';
                        }
                        loadData();
                    }
                });
            }

        });
    </script>
@endsection
