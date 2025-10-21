@extends('layouts.dashboard')

@section('title', 'Profile')
@section('page-title', 'Profile Akun')

@php
    $role = 'Peminjam';
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
            --dark-navy: #0f172a;
            --success-green: #10b981;
            --purple-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0e7ff 100%);
            min-height: 100vh;
        }

        .profile-container {
            max-width: 1200px;
            margin: 0 auto;
            animation: fadeInUp 0.6s ease-out;
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

        .profile-header-card {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #6366f1 100%);
            border-radius: 24px;
            padding: 2.5rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(30, 64, 175, 0.2);
        }

        .profile-header-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 20s infinite ease-in-out;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(20px, -20px) rotate(3deg); }
            66% { transform: translate(-15px, 15px) rotate(-3deg); }
        }

        .photo-section {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .photo-container {
            position: relative;
            width: 180px;
            height: 180px;
            margin: 0 auto 1.5rem;
        }

        .profile-photo {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            border: 6px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            object-fit: cover;
            transition: all 0.3s ease;
        }

        .profile-photo:hover {
            transform: scale(1.05);
            border-color: rgba(255, 255, 255, 0.5);
        }

        .photo-badge {
            position: absolute;
            bottom: 10px;
            right: 10px;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--success-green) 0%, #34d399 100%);
            border-radius: 50%;
            border: 4px solid white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .action-btn {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            color: white;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-decoration: none;
        }

        .action-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            color: white;
        }

        .action-btn i {
            font-size: 1.1rem;
        }

        .profile-name {
            color: white;
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }

        .edit-name-btn {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .edit-name-btn:hover {
            background: rgba(255, 255, 255, 0.35);
            transform: rotate(90deg) scale(1.1);
        }

        .profile-role {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
            display: inline-block;
            padding: 0.5rem 1.25rem;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 50px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .info-cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .info-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(30px);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(30, 64, 175, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.8);
            transition: all 0.4s ease;
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 50px rgba(30, 64, 175, 0.15);
        }

        .info-card-header {
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.08) 0%, rgba(99, 102, 241, 0.08) 100%);
            padding: 1.5rem 2rem;
            border-bottom: 2px solid rgba(30, 64, 175, 0.1);
        }

        .info-card-header h5 {
            color: var(--dark-navy);
            font-weight: 700;
            margin: 0;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .info-card-header i {
            color: var(--primary-blue);
            font-size: 1.5rem;
        }

        .info-table {
            margin: 0;
        }

        .info-table tr {
            border-bottom: 1px solid rgba(226, 232, 240, 0.5);
            transition: all 0.3s ease;
        }

        .info-table tr:last-child {
            border-bottom: none;
        }

        .info-table tr:hover {
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.03) 0%, rgba(99, 102, 241, 0.03) 100%);
        }

        .info-table td {
            padding: 1.25rem 2rem;
            border: none;
            font-size: 0.938rem;
        }

        .label-col {
            color: #64748b;
            font-weight: 600;
            width: 140px;
        }

        .value-col {
            color: var(--dark-navy);
            font-weight: 600;
        }

        .security-card {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.05) 0%, rgba(251, 146, 60, 0.05) 100%);
            border: 2px solid rgba(239, 68, 68, 0.15);
        }

        .security-card .info-card-header {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.08) 0%, rgba(251, 146, 60, 0.08) 100%);
        }

        .security-card .info-card-header i {
            color: #ef4444;
        }

        .password-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.5rem 2rem;
        }

        .password-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .password-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #ef4444 0%, #f97316 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
        }

        .password-text h6 {
            margin: 0;
            color: var(--dark-navy);
            font-weight: 700;
            font-size: 1rem;
        }

        .password-text p {
            margin: 0;
            color: #64748b;
            font-size: 0.875rem;
        }

        .btn-change-password {
            background: linear-gradient(135deg, #ef4444 0%, #f97316 100%);
            border: none;
            padding: 0.65rem 1.5rem;
            border-radius: 50px;
            color: white;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .btn-change-password:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
            color: white;
        }

        .alert-custom {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.08) 0%, rgba(99, 102, 241, 0.08) 100%);
            border: 2px solid rgba(59, 130, 246, 0.2);
            border-left: 5px solid var(--primary-blue);
            color: var(--primary-blue);
            padding: 1.25rem 1.5rem;
            border-radius: 16px;
            margin: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .alert-custom i {
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .modal-content {
            border-radius: 24px;
            border: none;
            overflow: hidden;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-light) 100%);
            color: white;
            padding: 1.5rem 2rem;
            border: none;
        }

        .modal-header.modal-header-danger {
            background: linear-gradient(135deg, #ef4444 0%, #f97316 100%);
        }

        .modal-header h5 {
            font-weight: 700;
            font-size: 1.25rem;
        }

        .modal-header .btn-close {
            filter: invert(1);
            opacity: 0.8;
        }

        .modal-header .btn-close:hover {
            opacity: 1;
        }

        .modal-body {
            padding: 2rem;
        }

        .modal-preview-container {
            position: relative;
            width: 200px;
            height: 200px;
            margin: 0 auto 1.5rem;
        }

        .modal-preview {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            border: 5px solid var(--primary-light);
            box-shadow: 0 10px 30px rgba(30, 64, 175, 0.2);
            object-fit: cover;
        }

        .form-label {
            color: var(--dark-navy);
            font-weight: 600;
            margin-bottom: 0.75rem;
            font-size: 0.938rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-control {
            border-radius: 12px;
            border: 2px solid #e2e8f0;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            font-size: 0.938rem;
        }

        .form-control:focus {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        .input-group {
            position: relative;
        }

        .input-group .form-control {
            padding-right: 3rem;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #64748b;
            cursor: pointer;
            padding: 0.5rem;
            z-index: 10;
            transition: all 0.3s ease;
        }

        .password-toggle:hover {
            color: var(--primary-blue);
        }

        .password-requirements {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(99, 102, 241, 0.05) 100%);
            border: 2px solid rgba(59, 130, 246, 0.15);
            border-radius: 12px;
            padding: 1rem 1.25rem;
            margin-top: 1rem;
        }

        .password-requirements h6 {
            color: var(--dark-navy);
            font-size: 0.875rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
        }

        .requirement-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.813rem;
            color: #64748b;
            margin-bottom: 0.5rem;
        }

        .requirement-item:last-child {
            margin-bottom: 0;
        }

        .requirement-item i {
            font-size: 0.75rem;
        }

        .alert-warning {
            background: linear-gradient(135deg, rgba(251, 191, 36, 0.1) 0%, rgba(252, 211, 77, 0.1) 100%);
            border: 2px solid rgba(251, 191, 36, 0.3);
            border-left: 5px solid var(--accent-orange);
            color: #d97706;
            padding: 1rem 1.25rem;
            border-radius: 12px;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-warning i {
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .modal-footer {
            padding: 1.5rem 2rem;
            border-top: 1px solid #e2e8f0;
            background: #f8fafc;
        }

        .btn-secondary {
            background: #64748b;
            border: none;
            padding: 0.75rem 1.75rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: #475569;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(100, 116, 139, 0.3);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-light) 100%);
            border: none;
            padding: 0.75rem 1.75rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #f97316 100%);
            border: none;
            padding: 0.75rem 1.75rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(239, 68, 68, 0.4);
        }

        @media (max-width: 768px) {
            .profile-header-card {
                padding: 2rem 1.5rem;
            }

            .photo-container {
                width: 150px;
                height: 150px;
            }

            .profile-photo {
                width: 150px;
                height: 150px;
            }

            .profile-name {
                font-size: 1.5rem;
            }

            .action-buttons {
                flex-direction: column;
            }

            .action-btn {
                width: 100%;
                justify-content: center;
            }

            .info-cards-grid {
                grid-template-columns: 1fr;
            }

            .info-table td {
                padding: 1rem 1.5rem;
                font-size: 0.875rem;
            }

            .label-col {
                width: 120px;
            }

            .password-row {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
        }
    </style>

    <div class="profile-container">
        <div class="profile-header-card">
            <div class="photo-section">
                <div class="photo-container">
                    <img src="{{ $user['foto'] }}" class="profile-photo" alt="Foto Profile" id="previewFoto">
                    <div class="photo-badge">
                        <i class="bi bi-check-lg text-white fs-5"></i>
                    </div>
                </div>
                <h4 class="profile-name">
                    <span id="displayNama">{{ $user['nama'] }}</span>
                    <button class="edit-name-btn" data-bs-toggle="modal" data-bs-target="#editNamaModal" title="Edit Nama">
                        <i class="bi bi-pencil-fill"></i>
                    </button>
                </h4>
                <span class="profile-role">
                    <i class="bi bi-briefcase me-2"></i>{{ $user['jabatan'] }}
                </span>
                <div class="mt-3">
                    <div class="action-buttons">
                        <button class="action-btn" data-bs-toggle="modal" data-bs-target="#editFotoModal">
                            <i class="bi bi-camera-fill"></i>
                            <span>Ganti Foto</span>
                        </button>
                        <button class="action-btn" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                            <i class="bi bi-shield-lock-fill"></i>
                            <span>Ubah Password</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-cards-grid">
            <div class="info-card">
                <div class="info-card-header">
                    <h5>
                        <i class="bi bi-person-badge-fill"></i>
                        Informasi Pribadi
                    </h5>
                </div>
                <div class="card-body p-0">
                    <table class="table info-table">
                        <tr>
                            <td class="label-col">Nama Lengkap</td>
                            <td class="value-col">: <span id="tableNama">{{ $user['nama'] }}</span></td>
                        </tr>
                        <tr>
                            <td class="label-col">NIP</td>
                            <td class="value-col">: {{ $user['nip'] }}</td>
                        </tr>
                        <tr>
                            <td class="label-col">Jabatan</td>
                            <td class="value-col">: {{ $user['jabatan'] }}</td>
                        </tr>
                        <tr>
                            <td class="label-col">Golongan</td>
                            <td class="value-col">: {{ $user['golongan'] }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="info-card">
                <div class="info-card-header">
                    <h5>
                        <i class="bi bi-envelope-fill"></i>
                        Informasi Kontak
                    </h5>
                </div>
                <div class="card-body p-0">
                    <table class="table info-table">
                        <tr>
                            <td class="label-col">No. HP</td>
                            <td class="value-col">: {{ $user['no_hp'] }}</td>
                        </tr>
                        <tr>
                            <td class="label-col">Email</td>
                            <td class="value-col">: {{ $user['email'] }}</td>
                        </tr>
                    </table>
                    <div class="alert-custom">
                        <i class="bi bi-info-circle-fill"></i>
                        <span>Data NIP, Jabatan, Golongan, No. HP dan Email tidak dapat diubah.</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-card security-card">
            <div class="info-card-header">
                <h5>
                    <i class="bi bi-shield-fill-check"></i>
                    Keamanan Akun
                </h5>
            </div>
            <div class="password-row">
                <div class="password-info">
                    <div class="password-icon">
                        <i class="bi bi-key-fill"></i>
                    </div>
                    <div class="password-text">
                        <h6>Password</h6>
                        <p>••••••••••••</p>
                    </div>
                </div>
                <button class="btn-change-password" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                    <i class="bi bi-arrow-clockwise"></i>
                    <span>Ubah Password</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Edit Nama -->
    <div class="modal fade" id="editNamaModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-person-fill-gear me-2"></i>
                        Edit Nama
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditNama">
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-person-fill"></i>
                                Nama Lengkap
                            </label>
                            <input type="text" class="form-control" id="inputNama" value="{{ $user['nama'] }}" placeholder="Masukkan nama lengkap">
                        </div>
                        <div class="alert-warning">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <span>Ini adalah simulasi. Perubahan nama tidak akan tersimpan secara permanen.</span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>Batal
                    </button>
                    <button type="button" class="btn btn-primary" onclick="simpanNama()">
                        <i class="bi bi-check-circle me-2"></i>Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Foto -->
    <div class="modal fade" id="editFotoModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-camera-fill me-2"></i>
                        Ganti Foto Profile
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formGantiFoto">
                        <div class="modal-preview-container">
                            <img src="{{ $user['foto'] }}" class="modal-preview" alt="Preview" id="modalPreview">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-image"></i>
                                Upload Foto Baru
                            </label>
                            <input type="file" class="form-control" id="inputFoto" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG. Max 2MB</small>
                        </div>
                        <div class="alert-warning">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <span>Ini adalah simulasi. Foto tidak akan tersimpan secara permanen.</span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>Batal
                    </button>
                    <button type="button" class="btn btn-primary" onclick="simpanFoto()">
                        <i class="bi bi-check-circle me-2"></i>Simpan Foto
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Change Password -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header modal-header-danger">
                    <h5 class="modal-title">
                        <i class="bi bi-shield-lock-fill me-2"></i>
                        Ubah Password
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formChangePassword">
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-lock-fill"></i>
                                Password Lama
                            </label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="oldPassword" placeholder="Masukkan password lama">
                                <button class="password-toggle" type="button" onclick="togglePassword('oldPassword')">
                                    <i class="bi bi-eye-fill"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-lock-fill"></i>
                                Password Baru
                            </label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="newPassword" placeholder="Masukkan password baru">
                                <button class="password-toggle" type="button" onclick="togglePassword('newPassword')">
                                    <i class="bi bi-eye-fill"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-lock-fill"></i>
                                Konfirmasi Password Baru
                            </label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="confirmPassword" placeholder="Ulangi password baru">
                                <button class="password-toggle" type="button" onclick="togglePassword('confirmPassword')">
                                    <i class="bi bi-eye-fill"></i>
                                </button>
                            </div>
                        </div>
                        <div class="password-requirements">
                            <h6><i class="bi bi-info-circle-fill me-2"></i>Ketentuan Password:</h6>
                            <div class="requirement-item">
                                <i class="bi bi-check-circle-fill text-success"></i>
                                <span>Minimal 8 karakter</span>
                            </div>
                            <div class="requirement-item">
                                <i class="bi bi-check-circle-fill text-success"></i>
                                <span>Mengandung huruf besar dan kecil</span>
                            </div>
                            <div class="requirement-item">
                                <i class="bi bi-check-circle-fill text-success"></i>
                                <span>Mengandung angka</span>
                            </div>
                            <div class="requirement-item">
                                <i class="bi bi-check-circle-fill text-success"></i>
                                <span>Mengandung karakter khusus (!@#$%^&*)</span>
                            </div>
                        </div>
                        <div class="alert-warning mt-3">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <span>Ini adalah simulasi. Password tidak akan tersimpan secara permanen.</span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>Batal
                    </button>
                    <button type="button" class="btn btn-danger" onclick="changePassword()">
                        <i class="bi bi-shield-check me-2"></i>Ubah Password
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            let selectedImage = null;

            // Edit Nama Function
            function simpanNama() {
                const newNama = document.getElementById('inputNama').value.trim();
                
                if (!newNama) {
                    alert('Nama tidak boleh kosong!');
                    return;
                }

                if (newNama.length < 3) {
                    alert('Nama minimal 3 karakter!');
                    return;
                }

                // Update nama di semua tempat
                document.getElementById('displayNama').textContent = newNama;
                document.getElementById('tableNama').textContent = newNama;

                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('editNamaModal'));
                modal.hide();

                // Show success message
                showSuccessToast('Nama berhasil diubah!');
            }

            // Ganti Foto Function
            document.getElementById('inputFoto').addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Validate file size (max 2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('Ukuran file maksimal 2MB!');
                        this.value = '';
                        return;
                    }

                    // Validate file type
                    if (!file.type.match('image.*')) {
                        alert('File harus berupa gambar!');
                        this.value = '';
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(event) {
                        selectedImage = event.target.result;
                        document.getElementById('modalPreview').src = selectedImage;
                    }
                    reader.readAsDataURL(file);
                }
            });

            function simpanFoto() {
                if (selectedImage) {
                    document.getElementById('previewFoto').src = selectedImage;

                    const modal = bootstrap.Modal.getInstance(document.getElementById('editFotoModal'));
                    modal.hide();

                    showSuccessToast('Foto profile berhasil diubah!');
                    
                    // Reset input
                    document.getElementById('inputFoto').value = '';
                    selectedImage = null;
                } else {
                    alert('Silakan pilih foto terlebih dahulu!');
                }
            }

            // Toggle Password Visibility
            function togglePassword(inputId) {
                const input = document.getElementById(inputId);
                const button = input.parentElement.querySelector('.password-toggle i');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    button.classList.remove('bi-eye-fill');
                    button.classList.add('bi-eye-slash-fill');
                } else {
                    input.type = 'password';
                    button.classList.remove('bi-eye-slash-fill');
                    button.classList.add('bi-eye-fill');
                }
            }

            // Change Password Function
            function changePassword() {
                const oldPassword = document.getElementById('oldPassword').value;
                const newPassword = document.getElementById('newPassword').value;
                const confirmPassword = document.getElementById('confirmPassword').value;

                // Validation
                if (!oldPassword || !newPassword || !confirmPassword) {
                    alert('Semua field harus diisi!');
                    return;
                }

                if (newPassword.length < 8) {
                    alert('Password baru minimal 8 karakter!');
                    return;
                }

                // Check password strength
                const hasUpperCase = /[A-Z]/.test(newPassword);
                const hasLowerCase = /[a-z]/.test(newPassword);
                const hasNumber = /[0-9]/.test(newPassword);
                const hasSpecialChar = /[!@#$%^&*]/.test(newPassword);

                if (!hasUpperCase || !hasLowerCase || !hasNumber || !hasSpecialChar) {
                    alert('Password harus memenuhi semua ketentuan yang disebutkan!');
                    return;
                }

                if (newPassword !== confirmPassword) {
                    alert('Konfirmasi password tidak cocok!');
                    return;
                }

                if (oldPassword === newPassword) {
                    alert('Password baru tidak boleh sama dengan password lama!');
                    return;
                }

                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('changePasswordModal'));
                modal.hide();

                // Reset form
                document.getElementById('formChangePassword').reset();

                // Show success message
                showSuccessToast('Password berhasil diubah!');
            }

            // Success Toast Notification
            function showSuccessToast(message) {
                // Create toast element
                const toastHTML = `
                    <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
                        <div class="toast align-items-center text-white border-0 show" role="alert" style="background: linear-gradient(135deg, #10b981 0%, #34d399 100%); border-radius: 12px; box-shadow: 0 8px 24px rgba(16, 185, 129, 0.3);">
                            <div class="d-flex">
                                <div class="toast-body d-flex align-items-center gap-2" style="font-weight: 600;">
                                    <i class="bi bi-check-circle-fill fs-5"></i>
                                    <span>${message}</span>
                                </div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                            </div>
                        </div>
                    </div>
                `;

                // Add to body
                document.body.insertAdjacentHTML('beforeend', toastHTML);

                // Auto remove after 3 seconds
                setTimeout(() => {
                    const toastElement = document.querySelector('.toast');
                    if (toastElement) {
                        toastElement.remove();
                    }
                }, 3000);
            }

            // Reset modal when closed
            document.getElementById('editNamaModal').addEventListener('hidden.bs.modal', function () {
                document.getElementById('inputNama').value = document.getElementById('displayNama').textContent;
            });

            document.getElementById('editFotoModal').addEventListener('hidden.bs.modal', function () {
                document.getElementById('inputFoto').value = '';
                document.getElementById('modalPreview').src = document.getElementById('previewFoto').src;
                selectedImage = null;
            });

            document.getElementById('changePasswordModal').addEventListener('hidden.bs.modal', function () {
                document.getElementById('formChangePassword').reset();
                // Reset all password toggles to hidden
                ['oldPassword', 'newPassword', 'confirmPassword'].forEach(id => {
                    const input = document.getElementById(id);
                    const button = input.parentElement.querySelector('.password-toggle i');
                    input.type = 'password';
                    button.classList.remove('bi-eye-slash-fill');
                    button.classList.add('bi-eye-fill');
                });
            });
        </script>
    @endpush
@endsection