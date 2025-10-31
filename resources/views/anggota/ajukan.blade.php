@extends('layouts.dashboard')

@section('title', 'Ajukan Pinjaman')
@section('page-title', 'Ajukan Pinjaman')

@php
    $role = 'Anggota';
    $nama = auth()->user()->name;
    $routePrefix = 'anggota';
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

    <!-- Error Alert -->
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px; border: none; background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(248, 113, 113, 0.1) 100%); border-left: 4px solid #ef4444; color: #dc2626; font-weight: 500; margin-bottom: 1.5rem;">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Page Header Banner -->
    <div class="welcome-banner">
        <div class="welcome-content">
            <div class="welcome-icon">
                <i class="bi bi-file-earmark-plus text-white" style="font-size: 1.75rem;"></i>
            </div>
            <div>
                <h2>Ajukan Pinjaman Baru 📝</h2>
                <p>Lengkapi formulir di bawah ini untuk mengajukan pinjaman sebagai anggota koperasi</p>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card form-card">
        <div class="card-body">
            <form id="formAjukanPinjaman" action="{{ route('anggota.ajukan.store') }}" method="POST">
                @csrf
                <!-- Data Anggota Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h5 class="section-title">
                            <i class="bi bi-person-vcard"></i>
                            <span>Data Anggota</span>
                        </h5>
                        <p class="section-subtitle">Informasi pribadi Anda yang terdaftar</p>
                    </div>
                    <div class="section-content">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" value="{{ $anggota['nama'] }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">NIP</label>
                                <input type="text" class="form-control" value="{{ $anggota['nip'] }}" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jabatan</label>
                                <input type="text" class="form-control" value="{{ $anggota['jabatan'] }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Golongan</label>
                                <input type="text" class="form-control" value="{{ $anggota['golongan'] }}" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">No HP</label>
                                <input type="text" class="form-control" value="{{ $anggota['no_hp'] }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="{{ $anggota['email'] }}" readonly>
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
                                <select class="form-select" id="metodePembayaran" name="metode_pembayaran" required>
                                    <option value="">Pilih Metode Pembayaran</option>
                                    <option value="potong_gaji" {{ old('metode_pembayaran') == 'potong_gaji' ? 'selected' : '' }}>Potong Gaji Pokok</option>
                                    <option value="potong_tukin" {{ old('metode_pembayaran') == 'potong_tukin' ? 'selected' : '' }}>Potong Tunjangan Kinerja</option>
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
                                    <input type="radio" name="jumlah_pinjaman" id="amount1" value="3000000" {{ old('jumlah_pinjaman') == '3000000' ? 'checked' : '' }}>
                                    <label for="amount1">Rp 3.000.000</label>
                                </div>
                                <div class="amount-option">
                                    <input type="radio" name="jumlah_pinjaman" id="amount2" value="3500000" {{ old('jumlah_pinjaman') == '3500000' ? 'checked' : '' }}>
                                    <label for="amount2">Rp 3.500.000</label>
                                </div>
                                <div class="amount-option">
                                    <input type="radio" name="jumlah_pinjaman" id="amount3" value="4000000" {{ old('jumlah_pinjaman') == '4000000' ? 'checked' : '' }}>
                                    <label for="amount3">Rp 4.000.000</label>
                                </div>
                                <div class="amount-option">
                                    <input type="radio" name="jumlah_pinjaman" id="amount4" value="4500000" {{ old('jumlah_pinjaman') == '4500000' ? 'checked' : '' }}>
                                    <label for="amount4">Rp 4.500.000</label>
                                </div>
                                <div class="amount-option">
                                    <input type="radio" name="jumlah_pinjaman" id="amount5" value="5000000" {{ old('jumlah_pinjaman') == '5000000' ? 'checked' : '' }}>
                                    <label for="amount5">Rp 5.000.000</label>
                                </div>
                                <div class="amount-option">
                                    <input type="radio" name="jumlah_pinjaman" id="amount6" value="5500000" {{ old('jumlah_pinjaman') == '5500000' ? 'checked' : '' }}>
                                    <label for="amount6">Rp 5.500.000</label>
                                </div>
                                <div class="amount-option">
                                    <input type="radio" name="jumlah_pinjaman" id="amount7" value="6000000" {{ old('jumlah_pinjaman') == '6000000' ? 'checked' : '' }}>
                                    <label for="amount7">Rp 6.000.000</label>
                                </div>
                                <div class="amount-option">
                                    <input type="radio" name="jumlah_pinjaman" id="amount8" value="7000000" {{ old('jumlah_pinjaman') == '7000000' ? 'checked' : '' }}>
                                    <label for="amount8">Rp 7.000.000</label>
                                </div>
                                <div class="amount-option">
                                    <input type="radio" name="jumlah_pinjaman" id="amount9" value="8000000" {{ old('jumlah_pinjaman') == '8000000' ? 'checked' : '' }}>
                                    <label for="amount9">Rp 8.000.000</label>
                                </div>
                                <div class="amount-option">
                                    <input type="radio" name="jumlah_pinjaman" id="amount10" value="9000000" {{ old('jumlah_pinjaman') == '9000000' ? 'checked' : '' }}>
                                    <label for="amount10">Rp 9.000.000</label>
                                </div>
                                <div class="amount-option">
                                    <input type="radio" name="jumlah_pinjaman" id="amount11" value="10000000" {{ old('jumlah_pinjaman') == '10000000' ? 'checked' : '' }}>
                                    <label for="amount11">Rp 10.000.000</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Tenor/Cicilan
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="tenorCicilan" name="tenor_cicilan" required disabled>
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
                            <textarea class="form-control" id="keperluan" name="keperluan" rows="4" placeholder="Jelaskan keperluan pinjaman Anda secara detail..." required>{{ old('keperluan') }}</textarea>
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
                    <a href="{{ route('anggota.dashboard') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Konfirmasi Custom -->
    <div class="modal fade" id="konfirmasiModal" tabindex="-1" aria-labelledby="konfirmasiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 680px;">
            <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);">
                <div class="modal-header" style="background: white; border: none; padding: 1.5rem; border-radius: 16px 16px 0 0;">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 52px; height: 52px; background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="bi bi-cash-coin text-white" style="font-size: 1.375rem;"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold mb-0" id="konfirmasiModalLabel" style="color: #1f2937; font-size: 1.125rem;">Konfirmasi Pengajuan Pinjaman</h5>
                            <small style="color: #9ca3af; font-size: 0.813rem;">Pastikan data sudah benar</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 1.5rem 2rem; background: white;">
                    <!-- Alert Info -->
                    <div class="alert alert-warning d-flex align-items-center p-3 mb-4" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border: 1px solid #f59e0b; border-radius: 8px;">
                        <i class="bi bi-exclamation-triangle-fill me-2" style="color: #f59e0b; font-size: 1.25rem;"></i>
                        <div>
                            <small class="fw-bold" style="color: #92400e;">Pengajuan tidak dapat dibatalkan setelah disubmit!</small>
                        </div>
                    </div>
                    <!-- Data Pinjaman -->
                    <div class="row g-3 mb-4">
                        <div class="col-12">
                            <div class="p-3" style="background: #f8fafc; border-radius: 8px; border: 1px solid #e5e7eb;">
                                <style>
                                    .confirm-grid{display:grid;grid-template-columns:1fr auto;gap:10px 16px}
                                    .confirm-label{color:#6b7280;font-size:.875rem}
                                    .confirm-value{color:#1f2937;font-weight:700;text-align:right;min-width:140px}
                                    .confirm-value.danger{color:#dc2626}
                                    .confirm-value.warning{color:#f59e0b}
                                    .confirm-value.success{color:#059669}
                                </style>
                                <div class="confirm-grid">
                                    <span class="confirm-label">Jumlah Pinjaman:</span>
                                    <strong id="konfirm-jumlah" class="confirm-value">-</strong>

                                    <span class="confirm-label">Tenor:</span>
                                    <strong id="konfirm-tenor" class="confirm-value">-</strong>

                                    <span class="confirm-label">Cicilan per Bulan:</span>
                                    <strong id="konfirm-cicilan" class="confirm-value danger">-</strong>

                                    <span class="confirm-label">Total Dibayar:</span>
                                    <strong id="konfirm-total" class="confirm-value danger">-</strong>

                                    <span class="confirm-label">Biaya Admin:</span>
                                    <strong id="konfirm-admin" class="confirm-value warning">-</strong>

                                    <span class="confirm-label">Jumlah Diterima:</span>
                                    <strong id="konfirm-diterima" class="confirm-value success">-</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Lainnya -->
                    <div class="mb-4">
                        <div class="p-3" style="background: #f8fafc; border-radius: 8px; border: 1px solid #e5e7eb;">
                            <div class="confirm-grid">
                                <span class="confirm-label">Metode Pembayaran:</span>
                                <strong id="konfirm-metode" class="confirm-value" style="white-space: nowrap;">-</strong>

                                <span class="confirm-label">Keperluan:</span>
                                <em id="konfirm-keperluan" style="color:#1f2937;font-size:.875rem;text-align:right;white-space: normal; word-break: break-word; overflow-wrap: anywhere; display: block; max-height: 4.5rem; overflow-y: auto;">-</em>
                            </div>
                        </div>
                    </div>

                    <!-- Pertanyaan Konfirmasi -->
                    <div class="text-center py-4" style="border-top: 1px solid #e5e7eb; margin-top: 1rem;">
                        <div style="width: 72px; height: 72px; border: 5px solid #3b82f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem;">
                            <span style="font-size: 2.75rem; color: #3b82f6; font-weight: 700; line-height: 1;">?</span>
                        </div>
                        <h6 style="color: #1f2937; font-weight: 600; margin-bottom: 0.5rem; font-size: 1.063rem;">Apakah Anda yakin ingin mengajukan pinjaman ini?</h6>
                        <p class="mb-0" style="color: #6b7280; font-size: 0.875rem; line-height: 1.5;">Pengajuan akan segera diproses oleh tim admin koperasi.</p>
                    </div>
                </div>
                <div class="modal-footer" style="border: none; padding: 0 1.5rem 1.5rem; gap: 0.75rem; background: white; border-radius: 0 0 16px 16px; display: flex; justify-content: stretch;">
                    <button type="button" class="btn" data-bs-dismiss="modal" style="flex: 1; background: white; border: 1.5px solid #d1d5db; color: #6b7280; border-radius: 8px; padding: 0.75rem 1rem; font-weight: 500; font-size: 0.938rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem; transition: all 0.2s;">
                        <i class="bi bi-x-circle" style="font-size: 1.125rem;"></i>
                        <span>Batal</span>
                    </button>
                    <button type="button" class="btn" id="konfirmSubmit" style="flex: 1; background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%); border: none; color: white; border-radius: 8px; padding: 0.75rem 1rem; font-weight: 500; font-size: 0.938rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem; transition: all 0.2s;">
                        <i class="bi bi-check-circle" style="font-size: 1.125rem;"></i>
                        <span>Ya, Ajukan</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Success -->
    <div class="modal fade" id="cancelModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 20px; border: none;">
                <div class="modal-body text-center p-5">
                    <i class="bi bi-x-circle-fill text-danger" style="font-size: 4rem;"></i>
                    <h4 class="mt-3 fw-bold text-danger">Pengajuan Dibatalkan</h4>
                    <p class="text-muted">Anda dapat mengubah data dan mencoba lagi.</p>
                    <button type="button" class="btn btn-primary mt-3" data-bs-dismiss="modal" style="border-radius: 50px;">
                        <i class="bi bi-arrow-left me-2"></i>
                        Kembali ke Form
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);">
                <div class="modal-header" style="background: white; border: none; padding: 1.5rem; border-radius: 16px 16px 0 0;">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 52px; height: 52px; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="bi bi-exclamation-triangle text-white" style="font-size: 1.375rem;"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold mb-0" id="errorModalTitle" style="color: #1f2937; font-size: 1.125rem;">Error</h5>
                            <small style="color: #9ca3af; font-size: 0.813rem;">Mohon perhatikan</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 2rem; background: white;">
                    <p id="errorModalMessage" class="mb-0" style="color: #6b7280; line-height: 1.6;"></p>
                </div>
                <div class="modal-footer" style="border: none; padding: 0 1.5rem 1.5rem; background: white; border-radius: 0 0 16px 16px;">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" style="background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%); border: none; border-radius: 8px; padding: 0.75rem 1.5rem; font-weight: 500;">
                        <i class="bi bi-check-circle me-2"></i>Mengerti
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // CSRF & URLs
            const CSRF_TOKEN = '{{ csrf_token() }}';
            const SUBMIT_URL = '{{ route('anggota.ajukan.store') }}';
            const RIWAYAT_URL = '{{ route('anggota.riwayat') }}';
            // Data tabel pinjaman sesuai gambar
            const tabelPinjaman = {
                3000000: {
                    maxTenor: 3,
                    admin: 150000,
                    terima: 2850000,
                    cicilan: {
                        2: 1500000,
                        3: 1000000
                    }
                },
                3500000: {
                    maxTenor: 4,
                    admin: 175000,
                    terima: 3325000,
                    cicilan: {
                        2: 1750000,
                        3: 1166667,
                        4: 875000
                    }
                },
                4000000: {
                    maxTenor: 5,
                    admin: 200000,
                    terima: 3800000,
                    cicilan: {
                        2: 2000000,
                        3: 1333334,
                        4: 1000000,
                        5: 800000
                    }
                },
                4500000: {
                    maxTenor: 6,
                    admin: 225000,
                    terima: 4275000,
                    cicilan: {
                        2: 2250000,
                        3: 1500000,
                        4: 1125000,
                        5: 900000,
                        6: 750000
                    }
                },
                5000000: {
                    maxTenor: 16,
                    admin: 250000,
                    terima: 4750000,
                    cicilan: {
                        2: 2500000,
                        3: 1666667,
                        4: 1250000,
                        5: 1000000,
                        6: 916667,
                        7: 785714,
                        8: 687500,
                        9: 666667,
                        10: 600000,
                        11: 636364,
                        12: 666667,
                        15: 600000,
                        16: 625000
                    }
                },
                5500000: {
                    maxTenor: 8,
                    admin: 275000,
                    terima: 5225000,
                    cicilan: {
                        2: 2750000,
                        3: 1833334,
                        4: 1375000,
                        5: 1100000,
                        6: 916667,
                        7: 785714,
                        8: 687500
                    }
                },
                6000000: {
                    maxTenor: 9,
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
                        9: 666667
                    }
                },
                7000000: {
                    maxTenor: 10,
                    admin: 350000,
                    terima: 6650000,
                    cicilan: {
                        2: 3500000,
                        3: 2333334,
                        4: 1750000,
                        5: 1400000,
                        6: 1166667,
                        7: 1000000,
                        8: 875000,
                        9: 777778,
                        10: 700000
                    }
                },
                8000000: {
                    maxTenor: 12,
                    admin: 400000,
                    terima: 7600000,
                    cicilan: {
                        2: 4000000,
                        3: 2666667,
                        4: 2000000,
                        5: 1600000,
                        6: 1333334,
                        7: 1142857,
                        8: 1000000,
                        9: 888889,
                        10: 800000,
                        11: 727273,
                        12: 666667
                    }
                },
                9000000: {
                    maxTenor: 15,
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
                        13: 692308,
                        14: 642857,
                        15: 600000
                    }
                },
                10000000: {
                    maxTenor: 20,
                    admin: 500000,
                    terima: 9500000,
                    cicilan: {
                        2: 5000000,
                        3: 3333334,
                        4: 2500000,
                        5: 2000000,
                        6: 1666667,
                        7: 1428571,
                        8: 1250000,
                        9: 1111111,
                        10: 1000000,
                        11: 909091,
                        12: 833333,
                        13: 769231,
                        14: 714286,
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
            document.querySelectorAll('input[name="jumlah_pinjaman"]').forEach(radio => {
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
                const jumlahPinjaman = document.querySelector('input[name="jumlah_pinjaman"]:checked');

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
                const jumlahPinjaman = document.querySelector('input[name="jumlah_pinjaman"]:checked');
                const tenorCicilan = document.getElementById('tenorCicilan').value;
                const metodePembayaran = document.getElementById('metodePembayaran').value;
                const keperluan = document.getElementById('keperluan').value;

                if (!jumlahPinjaman || !tenorCicilan || !metodePembayaran || !keperluan) {
                    e.preventDefault();
                    showErrorModal('Form Tidak Lengkap', 'Mohon lengkapi semua field yang wajib diisi!');
                    return;
                }

                // Prevent default untuk menampilkan konfirmasi
                e.preventDefault();

                // Ambil data untuk konfirmasi
                const jumlah = parseInt(jumlahPinjaman.value);
                const tenor = parseInt(tenorCicilan);
                const data = tabelPinjaman[jumlah];

                // Debug log untuk melihat apa yang terjadi
                console.log('Jumlah:', jumlah);
                console.log('Tenor:', tenor);
                console.log('Data:', data);
                console.log('Available cicilan:', data ? Object.keys(data.cicilan) : 'No data');

                // Skip JavaScript validation, let backend handle it
                // Backend sudah menggunakan AngsuranHelper yang lebih akurat
                if (!data || !data.cicilan) {
                    console.warn('Menggunakan default calculation karena data JavaScript tidak lengkap');
                    // Gunakan perhitungan sederhana untuk display modal
                    var defaultCicilan = Math.ceil(jumlah / tenor);
                    var defaultAdmin = jumlah * 0.05;
                    var defaultTerima = jumlah - defaultAdmin;

                    data = {
                        cicilan: {},
                        admin: defaultAdmin,
                        terima: defaultTerima
                    };
                    data.cicilan[tenor] = defaultCicilan;
                }

                const cicilanPerBulan = roundCicilan(data.cicilan[tenor]);
                const totalDibayar = cicilanPerBulan * tenor;
                const biayaAdmin = data.admin; // Gunakan data admin dari tabel
                const jumlahDiterima = data.terima; // Gunakan data terima dari tabel

                // Format angka untuk display
                const formatRupiah = (angka) => {
                    return 'Rp ' + angka.toLocaleString('id-ID');
                };

                // Update modal dengan data
                document.getElementById('konfirm-jumlah').textContent = formatRupiah(jumlah);
                document.getElementById('konfirm-tenor').textContent = tenor + ' bulan';
                document.getElementById('konfirm-cicilan').textContent = formatRupiah(cicilanPerBulan);
                document.getElementById('konfirm-total').textContent = formatRupiah(totalDibayar);
                document.getElementById('konfirm-admin').textContent = formatRupiah(biayaAdmin);
                document.getElementById('konfirm-diterima').textContent = formatRupiah(jumlahDiterima);
                document.getElementById('konfirm-metode').textContent = metodePembayaran === 'potong_gaji' ? 'Potong Gaji Pokok' : 'Potong Tunjangan Kinerja';
                document.getElementById('konfirm-keperluan').textContent = keperluan;

                // Store form reference for later submission
                window.currentForm = this;

                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('konfirmasiModal'));
                modal.show();
            });

            // Handle konfirmasi submit (AJAX + redirect)
            document.getElementById('konfirmSubmit').addEventListener('click', async function() {
                const btn = this;
                btn.disabled = true;
                const originalHTML = btn.innerHTML;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mengajukan...';

                try {
                    if (!window.currentForm) {
                        throw new Error('Form tidak ditemukan. Mohon coba lagi.');
                    }

                    const formData = new FormData(window.currentForm);

                    const res = await fetch(SUBMIT_URL, {
                        method: 'POST',
                        credentials: 'same-origin',
                        headers: {
                            'X-CSRF-TOKEN': CSRF_TOKEN,
                            'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8'
                        },
                        body: formData
                    });

                    if (res.ok) {
                        // Berhasil -> arahkan ke Riwayat Pinjaman
                        window.location.href = RIWAYAT_URL + '?success=1';
                        return;
                    }

                    // Jika 422 (validasi) atau lainnya, tampilkan pesan umum
                    const text = await res.text();
                    showErrorModal('Gagal Mengajukan', 'Pengajuan gagal dikirim. Pastikan semua field valid sesuai ketentuan.');
                    console.error('Submit error:', res.status, text);
                } catch (err) {
                    showErrorModal('Kesalahan Sistem', err.message || 'Terjadi kesalahan tak terduga.');
                    console.error(err);
                } finally {
                    btn.disabled = false;
                    btn.innerHTML = originalHTML;
                    // Tutup modal jika masih terbuka
                    const modalEl = document.getElementById('konfirmasiModal');
                    const modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) modal.hide();
                }
            });

            // Handle cancel (optional - bisa menampilkan modal cancel)
            document.getElementById('konfirmasiModal').addEventListener('hidden.bs.modal', function() {
                // Optional: Clear stored form reference
                window.currentForm = null;
            });

            // Function to show error modal
            function showErrorModal(title, message) {
                document.getElementById('errorModalTitle').textContent = title;
                document.getElementById('errorModalMessage').textContent = message;
                const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                errorModal.show();
            }

            // Function to show success notification
            function showSuccessNotification(message) {
                // You can implement a toast or success modal here
                console.log('Success:', message);
            }
        </script>
    @endpush
@endsection
