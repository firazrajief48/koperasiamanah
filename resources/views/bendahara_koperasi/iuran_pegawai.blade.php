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

        .btn-bayar {
            background-color: #10b981;
            border: none;
            color: white;
            padding: 0.4rem 1rem;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s ease;
            font-size: 0.875rem;
        }

        .btn-bayar:hover:not(:disabled) {
            background-color: #059669;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .btn-bayar:disabled {
            background-color: #6b7280;
            cursor: not-allowed;
            opacity: 0.6;
        }

        .btn-bayar-semua {
            background: linear-gradient(135deg, #f97316 0%, #fb923c 100%);
            border: none;
            color: white;
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-bayar-semua:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(249, 115, 22, 0.4);
            color: white;
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
    </style>

    <div class="welcome-banner">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="fw-bold mb-0">💰 Iuran Pegawai</h3>
                <small class="opacity-75">Kelola pembayaran iuran pegawai koperasi per bulan</small>
            </div>
            <a href="{{ route('bendahara_koperasi.dashboard') }}" class="btn btn-outline-light">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
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
                            @for ($year = date('Y'); $year >= 2020; $year--)
                                <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">
                            <i class="bi bi-funnel me-1"></i>Status Pembayaran
                        </label>
                        <select id="statusFilter" class="form-select">
                            <option value="semua">Semua Status</option>
                            <option value="lunas">Lunas</option>
                            <option value="belum">Belum Lunas</option>
                        </select>
                    </div>
                    <div class="col-md-6 text-end">
                        <button class="btn btn-bayar-semua" onclick="bayarSemua()">
                            <i class="bi bi-cash-stack me-2"></i>Bayar Semua Pegawai
                        </button>
                        <button class="btn btn-outline-primary ms-2" onclick="exportData()">
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
                            <th style="width:120px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <tr>
                            <td colspan="7" class="text-center py-5">
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

    <script>
        // Configuration
        const NOMINAL_IURAN = 50000;
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.content || '';

        // State Management
        let currentMonth = {{ date('n') }};
        let currentYear = {{ date('Y') }};
        let statusFilter = 'semua';
        let currentData = [];

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

            const url = `/bendahara-koperasi/iuran-pegawai/data?bulan=${currentMonth}&tahun=${currentYear}&status=${statusFilter}`;

            fetch(url, {
                method: 'GET',
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

                const row = `
                    <tr>
                        <td class="text-center">${index + 1}</td>
                        <td>
                            <a href="#" onclick="showRiwayat(${pegawai.id}, '${pegawai.nama.replace(/'/g, "\\'")}'); return false;"
                               class="nama-pegawai-link">
                                ${pegawai.nama}
                            </a>
                        </td>
                        <td><small class="text-muted">${pegawai.nip}</small></td>
                        <td><span class="badge bg-light text-dark">${pegawai.jabatan}</span></td>
                        <td class="fw-bold ${sudahBayar ? 'text-success' : 'text-muted'}">
                            Rp ${nominal.toLocaleString('id-ID')}
                        </td>
                        <td>
                            ${sudahBayar
                                ? '<span class="badge-lunas">✓ Lunas</span>'
                                : '<span class="badge-belum">✗ Belum Lunas</span>'}
                        </td>
                        <td>
                            <button class="btn btn-bayar btn-sm w-100"
                                    onclick="bayarIuran(${pegawai.id}, '${pegawai.nama.replace(/'/g, "\\'")}')"
                                    ${sudahBayar ? 'disabled' : ''}>
                                ${sudahBayar ? '✓ Lunas' : '💰 Bayar'}
                            </button>
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
                    <td colspan="7" class="text-center text-muted py-5">
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
            let totalPegawai = data.length;

            data.forEach(pegawai => {
                if (pegawai.sudah_bayar == 1) {
                    totalPemasukan += parseFloat(pegawai.nominal) || 0;
                    jumlahLunas++;
                }
            });

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

        // Bayar Iuran Single
        function bayarIuran(pegawaiId, namaPegawai) {
            if (!confirm(`Konfirmasi pembayaran iuran sebesar Rp ${NOMINAL_IURAN.toLocaleString('id-ID')} untuk:\n\n${namaPegawai}\n\nLanjutkan?`)) {
                return;
            }

            showLoading(true);

            fetch('/bendahara-koperasi/iuran-pegawai/bayar', {
                method: 'POST',
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

        // Bayar Semua Pegawai
        function bayarSemua() {
            const belumBayar = currentData.filter(p => p.sudah_bayar == 0).length;

            if (belumBayar === 0) {
                showError('Semua pegawai sudah membayar untuk bulan ini');
                return;
            }

            const totalBayar = belumBayar * NOMINAL_IURAN;

            if (!confirm(`Konfirmasi pembayaran MASSAL:\n\n` +
                        `Jumlah Pegawai: ${belumBayar} orang\n` +
                        `Total Pembayaran: Rp ${totalBayar.toLocaleString('id-ID')}\n` +
                        `Bulan: ${getBulanName(currentMonth)} ${currentYear}\n\n` +
                        `Lanjutkan?`)) {
                return;
            }

            showLoading(true);

            fetch('/bendahara-koperasi/iuran-pegawai/bayar-semua', {
                method: 'POST',
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
                const sudahBayar = item !== undefined;

                if (sudahBayar) {
                    totalBayar += parseFloat(item.nominal);
                    jumlahBulanLunas++;
                }

                html += `<tr class="${sudahBayar ? 'table-success' : ''}">
                    <td><strong>${bulanNames[i-1]}</strong></td>
                    <td>${sudahBayar ? '<span class="badge-lunas">Lunas</span>' : '<span class="badge-belum">Belum</span>'}</td>
                    <td class="fw-bold">${sudahBayar ? 'Rp ' + parseInt(item.nominal).toLocaleString('id-ID') : '-'}</td>
                    <td>${sudahBayar ? formatTanggal(item.tanggal_bayar) : '-'}</td>
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

            // Status filter
            document.getElementById('statusFilter')?.addEventListener('change', function() {
                statusFilter = this.value;
                loadData();
            });
        });
    </script>
@endsection
