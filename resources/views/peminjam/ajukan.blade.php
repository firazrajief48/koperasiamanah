@extends('layouts.dashboard')

@section('title', 'Ajukan Pinjaman')
@section('page-title', 'Ajukan Pinjaman')

@php
    $role = 'Peminjam';
    $nama = auth()->user()->name;
    $routePrefix = 'peminjam';
    $showAjukan = true;
    $showRiwayat = true;
@endphp

@section('main-content')
    <style>
        :root {
            --primary-blue: #1e40af;
            --primary-light: #3b82f6;
            --accent-orange: #f97316;
            --accent-yellow: #fbbf24;
            --dark-navy: #0f172a;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --success-green: #10b981;
            --purple: #8b5cf6;
            --pink: #ec4899;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0e7ff 100%);
            min-height: 100vh;
        }

        /* Welcome Banner - Compact (sama dengan dashboard) */
        .welcome-banner {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #6366f1 100%);
            border-radius: 20px;
            padding: 1.5rem 2rem;
            margin-bottom: 1.5rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(30, 64, 175, 0.2);
            animation: slideDown 0.6s ease-out;
        }

        .welcome-banner::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.08) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 20s infinite ease-in-out;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(20px, -20px) rotate(3deg); }
            66% { transform: translate(-15px, 15px) rotate(-3deg); }
        }

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

        .welcome-content {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }

        .welcome-icon {
            width: 56px;
            height: 56px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .welcome-banner h2 {
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .welcome-banner p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.875rem;
            margin-bottom: 0;
        }

        /* Modern Form Card (sama dengan dashboard) */
        .form-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(30px);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(30, 64, 175, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.6);
            animation: fadeInUp 0.6s ease-out 0.2s both;
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

        .form-card .card-body {
            padding: 0;
        }

        /* Form Section Header (mirip table header di dashboard) */
        .form-section {
            margin: 0 2rem 1.5rem;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(30, 64, 175, 0.06);
            border: 1px solid rgba(30, 64, 175, 0.08);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .form-section:hover {
            box-shadow: 0 8px 24px rgba(30, 64, 175, 0.12);
            transform: translateY(-2px);
            background: white;
        }

        .form-section:first-child {
            margin-top: 2rem;
        }

        .form-section:last-child {
            margin-bottom: 2rem;
        }

        .section-header {
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.08) 0%, rgba(99, 102, 241, 0.08) 100%);
            padding: 1.5rem 2rem;
            border-bottom: 2px solid rgba(30, 64, 175, 0.1);
        }

        .section-title {
            color: var(--dark-navy);
            font-size: 1.125rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-title i {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-light));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.125rem;
        }

        .section-subtitle {
            color: #64748b;
            margin-bottom: 0;
            font-size: 0.813rem;
            margin-left: 48px;
        }

        .section-content {
            padding: 2rem;
        }

        /* Form Controls */
        .form-label {
            font-weight: 600;
            color: #475569;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .form-control, .form-select {
            border-radius: 12px;
            padding: 0.75rem 1rem;
            border: 2px solid rgba(30, 64, 175, 0.1);
            font-size: 0.875rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            background: white;
            transform: translateY(-1px);
        }

        .form-control[readonly] {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-color: #e2e8f0;
            color: #64748b;
            cursor: not-allowed;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        /* Info Alert */
        .alert-info {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(99, 102, 241, 0.1) 100%);
            border: 2px solid rgba(59, 130, 246, 0.3);
            border-radius: 12px;
            color: var(--primary-blue);
            padding: 1rem 1.25rem;
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            animation: fadeIn 0.6s ease-out 0.4s both;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .alert-info i {
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        /* Success Info Alert (mirip cicilan info) */
        .alert-success-custom {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(52, 211, 153, 0.1) 100%);
            border: 2px solid rgba(16, 185, 129, 0.3);
            border-radius: 12px;
            padding: 1rem;
        }

        .alert-success-custom .alert-icon {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
        }

        .alert-success-custom .alert-icon i {
            color: #047857;
            font-size: 1.25rem;
        }

        .alert-success-custom .alert-icon strong {
            color: #047857;
        }

        .alert-success-custom .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 0.75rem;
        }

        .alert-success-custom .info-item small {
            color: #64748b;
            display: block;
            font-size: 0.75rem;
        }

        .alert-success-custom .info-item strong {
            color: #047857;
            font-size: 1.125rem;
        }

        /* Buttons */
        .form-actions {
            display: flex;
            gap: 1rem;
            padding: 1.5rem 2rem;
            border-top: 2px solid rgba(226, 232, 240, 0.5);
            background: linear-gradient(135deg, rgba(248, 250, 252, 0.5) 0%, rgba(241, 245, 249, 0.5) 100%);
        }

        .form-actions .btn {
            padding: 0.75rem 1.75rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: none;
        }

        .form-actions .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .form-actions .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
            background: linear-gradient(135deg, #2563eb 0%, #4f46e5 100%);
        }

        .form-actions .btn-primary:active {
            transform: translateY(-1px);
        }

        .form-actions .btn-secondary {
            background: white;
            border: 2px solid #e2e8f0;
            color: #475569;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .form-actions .btn-secondary:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        /* Amount Options Grid */
        .amount-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .amount-option {
            position: relative;
        }

        .amount-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .amount-option label {
            display: block;
            padding: 1rem;
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            text-align: center;
            font-weight: 600;
            color: #64748b;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.875rem;
        }

        .amount-option input[type="radio"]:checked + label {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(99, 102, 241, 0.1) 100%);
            border-color: var(--primary-blue);
            color: var(--primary-blue);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
        }

        .amount-option label:hover {
            border-color: var(--primary-light);
            transform: translateY(-1px);
        }

        /* Required indicator */
        .text-danger {
            color: #ef4444;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .welcome-banner {
                padding: 1.25rem 1.5rem;
            }

            .welcome-content {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.75rem;
            }

            .welcome-banner h2 {
                font-size: 1.25rem;
            }

            .form-section {
                margin-left: 1.5rem;
                margin-right: 1.5rem;
            }

            .section-header,
            .section-content {
                padding: 1.25rem 1.5rem;
            }

            .form-actions {
                padding: 1.25rem 1.5rem;
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .amount-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .section-subtitle {
                margin-left: 0;
                margin-top: 0.5rem;
            }

            .section-title {
                flex-wrap: wrap;
            }
        }

        @media (max-width: 480px) {
            .amount-grid {
                grid-template-columns: 1fr;
            }

            .alert-success-custom .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <!-- Page Header Banner -->
    <div class="welcome-banner">
        <div class="welcome-content">
            <div class="welcome-icon">
                <i class="bi bi-file-earmark-plus text-white" style="font-size: 1.75rem;"></i>
            </div>
            <div>
                <h2>Ajukan Pinjaman Baru 📝</h2>
                <p>Lengkapi formulir di bawah ini untuk mengajukan pinjaman Anda</p>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card form-card">
        <div class="card-body">
            <form id="formAjukanPinjaman">
                <!-- Data Peminjam Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h5 class="section-title">
                            <i class="bi bi-person-vcard"></i>
                            <span>Data Peminjam</span>
                        </h5>
                        <p class="section-subtitle">Informasi pribadi Anda yang terdaftar</p>
                    </div>
                    <div class="section-content">
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
                </div>

                <!-- Detail Pinjaman Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h5 class="section-title">
                            <i class="bi bi-cash-coin"></i>
                            <span>Detail Pinjaman</span>
                        </h5>
                        <p class="section-subtitle">Tentukan jumlah dan tenor pinjaman Anda</p>
                    </div>
                    <div class="section-content">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Tanggal Pengajuan
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="tanggalPengajuan" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Metode Pembayaran
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" id="metodePembayaran" required>
                                    <option value="">Pilih Metode Pembayaran</option>
                                    <option value="potong_gaji">Potong Gaji</option>
                                    <option value="potong_tukin">Potong Tunjangan Kinerja</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Jumlah Pinjaman
                                <span class="text-danger">*</span>
                            </label>
                            <div class="amount-grid">
                                <div class="amount-option">
                                    <input type="radio" name="jumlahPinjaman" id="amount1" value="3000000">
                                    <label for="amount1">Rp 3.000.000</label>
                                </div>
                                <div class="amount-option">
                                    <input type="radio" name="jumlahPinjaman" id="amount2" value="3500000">
                                    <label for="amount2">Rp 3.500.000</label>
                                </div>
                                <div class="amount-option">
                                    <input type="radio" name="jumlahPinjaman" id="amount3" value="4000000">
                                    <label for="amount3">Rp 4.000.000</label>
                                </div>
                                <div class="amount-option">
                                    <input type="radio" name="jumlahPinjaman" id="amount4" value="4500000">
                                    <label for="amount4">Rp 4.500.000</label>
                                </div>
                                <div class="amount-option">
                                    <input type="radio" name="jumlahPinjaman" id="amount5" value="5000000">
                                    <label for="amount5">Rp 5.000.000</label>
                                </div>
                                <div class="amount-option">
                                    <input type="radio" name="jumlahPinjaman" id="amount6" value="5500000">
                                    <label for="amount6">Rp 5.500.000</label>
                                </div>
                                <div class="amount-option">
                                    <input type="radio" name="jumlahPinjaman" id="amount7" value="6000000">
                                    <label for="amount7">Rp 6.000.000</label>
                                </div>
                                <div class="amount-option">
                                    <input type="radio" name="jumlahPinjaman" id="amount8" value="7000000">
                                    <label for="amount8">Rp 7.000.000</label>
                                </div>
                                <div class="amount-option">
                                    <input type="radio" name="jumlahPinjaman" id="amount9" value="8000000">
                                    <label for="amount9">Rp 8.000.000</label>
                                </div>
                                <div class="amount-option">
                                    <input type="radio" name="jumlahPinjaman" id="amount10" value="9000000">
                                    <label for="amount10">Rp 9.000.000</label>
                                </div>
                                <div class="amount-option">
                                    <input type="radio" name="jumlahPinjaman" id="amount11" value="10000000">
                                    <label for="amount11">Rp 10.000.000</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Tenor/Cicilan
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="tenorCicilan" required disabled>
                                <option value="">Pilih jumlah pinjaman terlebih dahulu</option>
                            </select>
                            <small class="text-muted mt-1 d-block">
                                <i class="bi bi-info-circle"></i> Pilih jumlah pinjaman untuk melihat opsi tenor yang tersedia
                            </small>
                        </div>

                        <div class="mb-3" id="cicilanInfo" style="display: none;">
                            <div class="alert-success-custom">
                                <div class="alert-icon">
                                    <i class="bi bi-calculator"></i>
                                    <strong>Rincian Cicilan:</strong>
                                </div>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <small>Cicilan per Bulan:</small>
                                        <strong id="cicilanPerBulan">-</strong>
                                    </div>
                                    <div class="info-item">
                                        <small>Total Dibayar:</small>
                                        <strong id="totalDibayar">-</strong>
                                    </div>
                                    <div class="info-item">
                                        <small>Biaya Admin (5%):</small>
                                        <strong id="biayaAdmin">-</strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Keperluan
                                <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control" id="keperluan" rows="4" placeholder="Jelaskan keperluan pinjaman Anda secara detail..." required></textarea>
                        </div>

                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i>
                            <span>Semua field bertanda <span class="text-danger">*</span> wajib diisi sebelum mengajukan pinjaman.</span>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send-fill"></i>
                        Ajukan Pinjaman
                    </button>
                    <a href="{{ route('peminjam.dashboard') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            // Data tabel pinjaman sesuai gambar
            const tabelPinjaman = {
                3000000: {
                    maxTenor: 5,
                    admin: 150000,
                    terima: 2850000,
                    cicilan: {
                        2: 1500000,
                        3: 1000000,
                        4: 750000,
                        5: 600000
                    }
                },
                3500000: {
                    maxTenor: 6,
                    admin: 175000,
                    terima: 3325000,
                    cicilan: {
                        2: 1750000,
                        3: 1166667,
                        4: 875000,
                        5: 700000,
                        6: 583333
                    }
                },
                4000000: {
                    maxTenor: 7,
                    admin: 200000,
                    terima: 3800000,
                    cicilan: {
                        2: 2000000,
                        3: 1333334,
                        4: 1000000,
                        5: 800000,
                        6: 666667,
                        7: 571429
                    }
                },
                4500000: {
                    maxTenor: 8,
                    admin: 225000,
                    terima: 4275000,
                    cicilan: {
                        2: 2250000,
                        3: 1500000,
                        4: 1125000,
                        5: 900000,
                        6: 750000,
                        7: 642857,
                        8: 562500
                    }
                },
                5000000: {
                    maxTenor: 9,
                    admin: 250000,
                    terima: 4750000,
                    cicilan: {
                        2: 2500000,
                        3: 1666667,
                        4: 1250000,
                        5: 1000000,
                        6: 833333,
                        7: 714286,
                        8: 625000,
                        9: 555556
                    }
                },
                5500000: {
                    maxTenor: 10,
                    admin: 275000,
                    terima: 5225000,
                    cicilan: {
                        2: 2750000,
                        3: 1833333,
                        4: 1375000,
                        5: 1100000,
                        6: 916667,
                        7: 785714,
                        8: 687500,
                        9: 611111,
                        10: 550000
                    }
                },
                6000000: {
                    maxTenor: 11,
                    admin: 300000,
                    terima: 5700000,
                    cicilan: {
                        2: 3000000,
                        3: 2000000,
                        4: 1500000,
                        5: 1200000,
                        6: 1000000,
                        7: 857143,
                        8: 750000,
                        9: 666667,
                        10: 600000,
                        11: 545455
                    }
                },
                7000000: {
                    maxTenor: 12,
                    admin: 350000,
                    terima: 6650000,
                    cicilan: {
                        2: 3500000,
                        3: 2333333,
                        4: 1750000,
                        5: 1400000,
                        6: 1166667,
                        7: 1000000,
                        8: 875000,
                        9: 777778,
                        10: 700000,
                        11: 636364,
                        12: 583333
                    }
                },
                8000000: {
                    maxTenor: 15,
                    admin: 400000,
                    terima: 7600000,
                    cicilan: {
                        2: 4000000,
                        3: 2666667,
                        4: 2000000,
                        5: 1600000,
                        6: 1333333,
                        7: 1142857,
                        8: 1000000,
                        9: 888889,
                        10: 800000,
                        11: 727273,
                        12: 666667,
                        15: 533333
                    }
                },
                9000000: {
                    maxTenor: 16,
                    admin: 450000,
                    terima: 8550000,
                    cicilan: {
                        2: 4500000,
                        3: 3000000,
                        4: 2250000,
                        5: 1800000,
                        6: 1500000,
                        7: 1285714,
                        8: 1125000,
                        9: 1000000,
                        10: 900000,
                        11: 818182,
                        12: 750000,
                        15: 600000,
                        16: 562500
                    }
                },
                10000000: {
                    maxTenor: 20,
                    admin: 500000,
                    terima: 9500000,
                    cicilan: {
                        2: 5000000,
                        3: 3333333,
                        4: 2500000,
                        5: 2000000,
                        6: 1666667,
                        7: 1428571,
                        8: 1250000,
                        9: 1111111,
                        10: 1000000,
                        11: 909091,
                        12: 833333,
                        15: 666667,
                        16: 625000,
                        17: 588235,
                        18: 555556,
                        19: 526316,
                        20: 500000
                    }
                }
            };

            // Set tanggal pengajuan otomatis
            const today = new Date();
            const formattedDate = today.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
            document.getElementById('tanggalPengajuan').value = formattedDate;

            // Format rupiah
            function formatRupiah(angka) {
                return 'Rp ' + angka.toLocaleString('id-ID');
            }

            // Fungsi untuk membulatkan ke kelipatan tertentu
            function roundToNearest(value, nearest) {
                return Math.round(value / nearest) * nearest;
            }

            // Fungsi untuk membulatkan angsuran (ke kelipatan 10 untuk nominal kecil, 100 untuk nominal besar)
            function roundCicilan(cicilan) {
                if (cicilan < 10000) {
                    return roundToNearest(cicilan, 10); // Bulatkan ke kelipatan 10 untuk nilai kecil
                } else if (cicilan < 100000) {
                    return roundToNearest(cicilan, 50); // Bulatkan ke kelipatan 50 untuk nilai sedang
                } else {
                    return roundToNearest(cicilan, 100); // Bulatkan ke kelipatan 100 untuk nilai besar
                }
            }

            // Handle perubahan jumlah pinjaman
            document.querySelectorAll('input[name="jumlahPinjaman"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    const jumlah = parseInt(this.value);
                    const data = tabelPinjaman[jumlah];
                    const tenorSelect = document.getElementById('tenorCicilan');

                    // Reset dan enable tenor select
                    tenorSelect.innerHTML = '<option value="">Pilih Tenor Cicilan</option>';
                    tenorSelect.disabled = false;

                    // Populate tenor options berdasarkan max tenor
                    const tenorOptions = Object.keys(data.cicilan).sort((a, b) => a - b);
                    tenorOptions.forEach(tenor => {
                        const option = document.createElement('option');
                        option.value = tenor;
                        const cicilanBulat = roundCicilan(data.cicilan[tenor]);
                        option.textContent = `${tenor} Bulan - ${formatRupiah(cicilanBulat)}/bulan`;
                        tenorSelect.appendChild(option);
                    });

                    // Hide cicilan info
                    document.getElementById('cicilanInfo').style.display = 'none';
                });
            });

            // Handle perubahan tenor
            document.getElementById('tenorCicilan').addEventListener('change', function() {
                const jumlahPinjaman = document.querySelector('input[name="jumlahPinjaman"]:checked');

                if (jumlahPinjaman && this.value) {
                    const jumlah = parseInt(jumlahPinjaman.value);
                    const tenor = parseInt(this.value);
                    const data = tabelPinjaman[jumlah];
                    const cicilanPerBulan = roundCicilan(data.cicilan[tenor]);
                    const totalDibayar = cicilanPerBulan * tenor;

                    // Update info cicilan
                    document.getElementById('cicilanPerBulan').textContent = formatRupiah(cicilanPerBulan);
                    document.getElementById('totalDibayar').textContent = formatRupiah(totalDibayar);
                    document.getElementById('biayaAdmin').textContent = formatRupiah(data.admin);
                    document.getElementById('cicilanInfo').style.display = 'block';
                }
            });

            // Form submission handler
            document.getElementById('formAjukanPinjaman').addEventListener('submit', function(e) {
                e.preventDefault();

                const jumlahPinjaman = document.querySelector('input[name="jumlahPinjaman"]:checked');
                const tenorCicilan = document.getElementById('tenorCicilan').value;
                const metodePembayaran = document.getElementById('metodePembayaran').value;
                const keperluan = document.getElementById('keperluan').value;

                if (!jumlahPinjaman || !tenorCicilan || !metodePembayaran || !keperluan) {
                    alert('Mohon lengkapi semua field yang wajib diisi!');
                    return;
                }

                // Simulasi sukses
                const data = tabelPinjaman[parseInt(jumlahPinjaman.value)];
                const tenor = parseInt(tenorCicilan);
                const cicilan = data.cicilan[tenor];

                alert(`✅ Pengajuan pinjaman berhasil disimpan!\n\nDetail:\n- Jumlah: ${formatRupiah(parseInt(jumlahPinjaman.value))}\n- Tenor: ${tenor} bulan\n- Cicilan: ${formatRupiah(cicilan)}/bulan\n- Diterima: ${formatRupiah(data.terima)}\n\nPinjaman Anda akan segera diproses oleh admin.`);
                window.location.href = '{{ route('peminjam.riwayat') }}';
            });
        </script>
    @endpush
@endsection
