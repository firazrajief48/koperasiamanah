@extends('layouts.dashboard')

@section('title', 'Edit Pengurus Koperasi')
@section('page-title', 'Edit Pengurus Koperasi')

@php
    $role = 'Administrator';
    $nama = auth()->user()->name;
    $routePrefix = 'administrator';
    $showLaporan = true;
@endphp

@section('main-content')
<style>
    .admin-form-card {
        background: white;
        border-radius: 20px;
        border: 1px solid rgba(37, 99, 235, 0.08);
        box-shadow: 0 8px 32px rgba(37, 99, 235, 0.08);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .admin-form-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 16px 48px rgba(37, 99, 235, 0.12);
        border-color: rgba(37, 99, 235, 0.15);
    }

    .admin-form-header {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-bottom: 1px solid rgba(37, 99, 235, 0.1);
        border-radius: 20px 20px 0 0;
        padding: 1.5rem 2rem;
    }

    .admin-form-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }

    .admin-form-body {
        padding: 2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }

    .form-control,
    .form-select {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        background: white;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        transform: translateY(-1px);
    }

    .form-control.is-invalid,
    .form-select.is-invalid {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }

    .invalid-feedback {
        font-size: 0.8rem;
        margin-top: 0.25rem;
        color: #ef4444;
    }

    .form-text {
        font-size: 0.8rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }

    .btn-primary-admin {
        background: linear-gradient(135deg, #2563eb 0%, #60a5fa 100%);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.75rem 2rem;
        border-radius: 12px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 16px rgba(37, 99, 235, 0.3);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary-admin:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(37, 99, 235, 0.4);
        background: linear-gradient(135deg, #60a5fa 0%, #2563eb 100%);
        color: white;
    }

    .btn-secondary-admin {
        background: linear-gradient(135deg, #64748b 0%, #94a3b8 100%);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.75rem 2rem;
        border-radius: 12px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 16px rgba(100, 116, 139, 0.3);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-secondary-admin:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(100, 116, 139, 0.4);
        background: linear-gradient(135deg, #94a3b8 0%, #64748b 100%);
        color: white;
    }

    .form-check {
        padding: 1rem;
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.05) 0%, rgba(96, 165, 250, 0.05) 100%);
        border-radius: 12px;
        border: 1px solid rgba(37, 99, 235, 0.1);
    }

    .form-check-input {
        width: 1.2rem;
        height: 1.2rem;
        border-radius: 6px;
        border: 2px solid #d1d5db;
        transition: all 0.3s ease;
    }

    .form-check-input:checked {
        background-color: #2563eb;
        border-color: #2563eb;
    }

    .form-check-input:focus {
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .form-check-label {
        font-weight: 500;
        color: #374151;
        margin-left: 0.5rem;
    }

    .file-upload-area {
        border: 2px dashed #d1d5db;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.02) 0%, rgba(96, 165, 250, 0.02) 100%);
    }

    .file-upload-area:hover {
        border-color: #2563eb;
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.05) 0%, rgba(96, 165, 250, 0.05) 100%);
    }

    .file-upload-icon {
        font-size: 2rem;
        color: #6b7280;
        margin-bottom: 0.5rem;
    }

    .file-upload-text {
        color: #6b7280;
        font-size: 0.9rem;
    }

    /* Enhanced Photo Styling */
    .current-photo {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #e5e7eb;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .current-photo-placeholder {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        border: 4px solid #e5e7eb;
    }

    .photo-preview {
        width: 200px;
        height: 200px;
        border-radius: 12px;
        object-fit: cover;
        border: 2px solid #d1d5db;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .photo-preview-container {
        background: #f9fafb;
        border-radius: 12px;
        padding: 1.5rem;
        border: 2px solid #e5e7eb;
    }

    /* Crop Modal Styles */
    .crop-modal .modal-dialog {
        max-width: 700px;
    }

    .crop-container {
        position: relative;
        width: 100%;
        height: 500px;
        background: #f9fafb;
        border-radius: 8px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .crop-image {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        cursor: grab;
        transition: transform 0.1s ease;
    }

    .crop-image:active {
        cursor: grabbing;
    }

    .crop-overlay {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 250px;
        height: 250px;
        border: 3px dashed #2563eb;
        border-radius: 50%;
        background: rgba(37, 99, 235, 0.05);
        pointer-events: none;
        box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.3);
    }

    .crop-controls {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        margin-top: 1rem;
        padding: 1rem;
        background: #f8fafc;
        border-radius: 8px;
    }

    .crop-slider {
        width: 250px;
    }

    /* Confirmation Modal Styles */
    .modal-content {
        border-radius: 12px;
        border: none;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    }

    .modal-header {
        border-bottom: 1px solid #e5e7eb;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-radius: 12px 12px 0 0;
    }

    .modal-footer {
        border-top: 1px solid #e5e7eb;
        background: #f8fafc;
        border-radius: 0 0 12px 12px;
    }

    /* Enhanced Photo Upload Card */
    .photo-upload-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .photo-upload-card:hover {
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        border-color: #d1d5db;
    }

    /* Current Photo Section */
    .current-photo-section {
        text-align: center;
        margin-bottom: 1.5rem;
        padding: 1rem;
        background: #f8fafc;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
    }

    .current-photo-wrapper,
    .no-photo-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.75rem;
    }

    .current-photo {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #e5e7eb;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .no-photo-icon {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        border: 3px solid #e5e7eb;
    }

    .no-photo-icon i {
        font-size: 3rem;
        color: #9ca3af;
    }

    .photo-status {
        display: flex;
        align-items: center;
        font-size: 0.875rem;
        font-weight: 500;
        color: #6b7280;
    }

    /* Upload Section */
    .upload-section {
        margin-bottom: 1rem;
    }

    .upload-area {
        border: 2px dashed #d1d5db;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    }

    .upload-area:hover {
        border-color: #2563eb;
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        transform: translateY(-2px);
    }

    .upload-icon {
        font-size: 2.5rem;
        color: #6b7280;
        margin-bottom: 1rem;
    }

    .upload-area:hover .upload-icon {
        color: #2563eb;
    }

    .upload-text h6 {
        font-size: 1rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
    }

    .upload-text p {
        font-size: 0.875rem;
        color: #6b7280;
        margin: 0;
    }

    .upload-info {
        margin-top: 1rem;
        text-align: center;
    }

    /* Preview Section */
    .preview-section {
        background: #f8fafc;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }

    .preview-header {
        background: #e5e7eb;
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #d1d5db;
    }

    .preview-header h6 {
        margin: 0;
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
    }

    .preview-content {
        padding: 1rem;
        text-align: center;
    }

    .preview-image {
        width: 150px;
        height: 150px;
        border-radius: 12px;
        object-fit: cover;
        border: 2px solid #d1d5db;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .preview-actions {
        padding: 1rem;
        display: flex;
        gap: 0.75rem;
        justify-content: center;
        background: white;
        border-top: 1px solid #e2e8f0;
    }


    .action-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-top: 2rem;
        padding: 2rem;
        background: #f8fafc;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
    }

    @media (max-width: 576px) {
        .action-buttons {
            flex-direction: column;
            gap: 0.75rem;
        }

        .action-buttons .btn {
            width: 100%;
        }
    }

    /* Form Card Styling */
    .form-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    .form-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid #e5e7eb;
        overflow: hidden;
    }

    .admin-form-header {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        color: white;
        padding: 1.5rem 2rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .admin-form-header h4 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 600;
    }

    .admin-form-body {
        padding: 2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }

    .form-control {
        border: 1px solid #d1d5db;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .form-control.is-invalid {
        border-color: #dc2626;
    }

    .invalid-feedback {
        font-size: 0.75rem;
        color: #dc2626;
        margin-top: 0.25rem;
    }


    /* Enhanced Form Spacing */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    /* Row spacing consistency */
    .row {
        margin-bottom: 1.5rem;
    }

    .row:last-child {
        margin-bottom: 0;
    }

    /* Photo upload card spacing */
    .photo-upload-card .form-group {
        margin-bottom: 0;
    }

    /* Button Styling */
    .btn {
        border-radius: 8px;
        font-weight: 500;
        padding: 0.75rem 1.5rem;
        transition: all 0.2s ease;
    }

    .btn-lg {
        padding: 0.875rem 2rem;
        font-size: 1rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
        border: none;
        box-shadow: 0 2px 8px rgba(37, 99, 235, 0.3);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
    }

    .btn-outline-secondary {
        border: 1px solid #d1d5db;
        color: #6b7280;
    }

    .btn-outline-secondary:hover {
        background: #f9fafb;
        border-color: #9ca3af;
        color: #374151;
        transform: translateY(-1px);
    }

    @media (max-width: 768px) {
        .form-container {
            padding: 1rem;
        }

        .admin-form-body {
            padding: 1.5rem;
        }

        .admin-form-header {
            padding: 1rem 1.5rem;
        }

        .admin-form-header h4 {
            font-size: 1.25rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .photo-upload-card {
            padding: 1rem;
        }

        .current-photo-section {
            padding: 0.75rem;
            margin-bottom: 1rem;
        }

        .upload-area {
            padding: 1.5rem;
        }

        .action-buttons {
            flex-direction: column;
            padding: 1.5rem;
            margin-top: 1.5rem;
        }

        .action-buttons .btn {
            width: 100%;
        }
    }

    @media (max-width: 576px) {
        .form-container {
            padding: 0.5rem;
        }

        .admin-form-body {
            padding: 1rem;
        }

        .admin-form-header {
            padding: 0.75rem 1rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .photo-upload-card {
            padding: 0.75rem;
        }

        .current-photo-section {
            padding: 0.5rem;
            margin-bottom: 0.75rem;
        }

        .upload-area {
            padding: 1rem;
        }

        .upload-icon {
            font-size: 2rem;
            margin-bottom: 0.75rem;
        }

        .upload-text h6 {
            font-size: 0.875rem;
        }

        .upload-text p {
            font-size: 0.75rem;
        }

        .action-buttons {
            padding: 1rem;
            margin-top: 1rem;
        }
    }
</style>

<div class="form-container">
    <div class="form-card">
        <div class="admin-form-header">
            <h4>
                <i class="bi bi-person-gear me-2"></i>Form Edit Pengurus Koperasi
            </h4>
        </div>
        <div class="admin-form-body">
        <form action="{{ route('administrator.pengurus-koperasi.update', $pengurus->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror"
                               id="nama" name="nama" value="{{ old('nama', $pengurus->nama) }}"
                               placeholder="Masukkan nama lengkap" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="jabatan" class="form-label">Jabatan <span class="text-danger">*</span></label>
                        <select class="form-select @error('jabatan') is-invalid @enderror"
                                id="jabatan" name="jabatan" required>
                            <option value="">Pilih Jabatan</option>
                            <option value="Kepala BPS" {{ old('jabatan', $pengurus->jabatan) == 'Kepala BPS' ? 'selected' : '' }}>Kepala BPS</option>
                            <option value="Ketua Koperasi" {{ old('jabatan', $pengurus->jabatan) == 'Ketua Koperasi' ? 'selected' : '' }}>Ketua Koperasi</option>
                            <option value="Wakil Ketua Koperasi" {{ old('jabatan', $pengurus->jabatan) == 'Wakil Ketua Koperasi' ? 'selected' : '' }}>Wakil Ketua Koperasi</option>
                            <option value="Sekretaris Koperasi" {{ old('jabatan', $pengurus->jabatan) == 'Sekretaris Koperasi' ? 'selected' : '' }}>Sekretaris Koperasi</option>
                            <option value="Bendahara Koperasi 1" {{ old('jabatan', $pengurus->jabatan) == 'Bendahara Koperasi 1' ? 'selected' : '' }}>Bendahara Koperasi 1</option>
                            <option value="Bendahara Koperasi 2" {{ old('jabatan', $pengurus->jabatan) == 'Bendahara Koperasi 2' ? 'selected' : '' }}>Bendahara Koperasi 2</option>
                            <option value="Bidang Usaha Koperasi" {{ old('jabatan', $pengurus->jabatan) == 'Bidang Usaha Koperasi' ? 'selected' : '' }}>Bidang Usaha Koperasi</option>
                            <option value="Administrator Koperasi" {{ old('jabatan', $pengurus->jabatan) == 'Administrator Koperasi' ? 'selected' : '' }}>Administrator Koperasi</option>
                        </select>
                        @error('jabatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                          id="deskripsi" name="deskripsi" rows="3"
                          placeholder="Masukkan deskripsi singkat tentang pengurus">{{ old('deskripsi', $pengurus->deskripsi) }}</textarea>
                @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email', $pengurus->email) }}"
                               placeholder="contoh@email.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="telepon" class="form-label">Telepon</label>
                        <input type="text" class="form-control @error('telepon') is-invalid @enderror"
                               id="telepon" name="telepon" value="{{ old('telepon', $pengurus->telepon) }}"
                               placeholder="081234567890">
                        @error('telepon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="urutan" class="form-label">Urutan Tampil <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('urutan') is-invalid @enderror"
                               id="urutan" name="urutan" value="{{ old('urutan', $pengurus->urutan) }}"
                               min="1" max="10" placeholder="1" required>
                        <div class="form-text">Urutan tampil di halaman depan (1-10)</div>
                        @error('urutan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="aktif" name="aktif" value="1"
                                   {{ old('aktif', $pengurus->aktif) ? 'checked' : '' }}>
                            <label class="form-check-label" for="aktif">
                                Aktif (ditampilkan di halaman depan)
                            </label>
                        </div>
                        @error('aktif')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="foto" class="form-label">Foto Profil</label>
                <!-- Photo Upload Card -->
                        <div class="photo-upload-card">
                            <!-- Current Photo Display -->
                            <div class="current-photo-section">
                                @if($pengurus->foto && file_exists(public_path('storage/' . $pengurus->foto)))
                                    <div class="current-photo-wrapper">
                                        <img src="http://127.0.0.1:8000/storage/{{ $pengurus->foto }}" alt="{{ $pengurus->nama }}"
                                             class="current-photo" id="currentPhoto">
                                        <div class="photo-status">
                                            <i class="bi bi-check-circle text-success me-1"></i>
                                            <span>Foto saat ini</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="no-photo-wrapper">
                                        <div class="no-photo-icon">
                                            <i class="bi bi-person-circle"></i>
                                        </div>
                                        <div class="photo-status">
                                            <i class="bi bi-exclamation-circle text-warning me-1"></i>
                                            <span>Belum ada foto</span>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Upload Area -->
                            <div class="upload-section" id="fileUploadArea">
                                <div class="upload-area" onclick="document.getElementById('foto').click()">
                                    <div class="upload-icon">
                                        <i class="bi bi-cloud-upload"></i>
                                    </div>
                                    <div class="upload-text">
                                        <h6>Upload Foto Profil</h6>
                                        <p>Klik untuk memilih foto atau drag & drop</p>
                                    </div>
                                    <input type="file" class="form-control @error('foto') is-invalid @enderror"
                                           id="foto" name="foto" accept="image/*" style="display: none;">
                                </div>
                                <div class="upload-info">
                                    <small class="text-muted">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Format: JPG, PNG, GIF. Maksimal 2MB
                                    </small>
                                </div>
                            </div>

                            <!-- Preview Area -->
                            <div class="preview-section" id="photoPreviewContainer" style="display: none;">
                                <div class="preview-header">
                                    <h6><i class="bi bi-eye me-2"></i>Preview Foto</h6>
                                </div>
                                <div class="preview-content">
                                    <img id="photoPreview" class="preview-image" alt="Preview">
                                </div>
                                <div class="preview-actions">
                                    <button type="button" class="btn btn-primary btn-sm" id="cropPhotoBtn">
                                        <i class="bi bi-scissors me-1"></i>Crop Foto
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" id="cancelUploadBtn">
                                        <i class="bi bi-x me-1"></i>Batal
                                    </button>
                                </div>
                            </div>

                            <!-- Hidden input for cropped photo -->
                            <input type="hidden" id="croppedPhoto" name="cropped_photo">

                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
            </div>


            <div class="action-buttons">
                <a href="{{ route('administrator.pengurus-koperasi.index') }}" class="btn btn-outline-secondary btn-lg" id="backBtn">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
                <button type="button" class="btn btn-primary btn-lg" id="saveBtn">
                    <i class="bi bi-check-lg me-2"></i>Update Data
                </button>
            </div>
        </form>
        </div>
    </div>
</div>

<!-- Crop Photo Modal -->
<div class="modal fade crop-modal" id="cropModal" tabindex="-1" aria-labelledby="cropModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cropModalLabel">
                    <i class="bi bi-scissors me-2"></i>Crop Foto Profil
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="crop-container">
                    <img id="cropImage" class="crop-image" alt="Crop Image">
                    <div class="crop-overlay" id="cropOverlay"></div>
                </div>
                <div class="crop-controls">
                    <label for="cropSlider" class="form-label">Zoom:</label>
                    <input type="range" class="form-range crop-slider" id="cropSlider" min="0.5" max="3" step="0.1" value="1">
                    <span id="zoomValue">100%</span>
                </div>
                <div class="text-center mt-3">
                    <small class="text-muted">Drag untuk memindahkan foto, gunakan slider untuk zoom</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="applyCropBtn">
                    <i class="bi bi-check-lg me-1"></i>Terapkan Crop
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">
                    <i class="bi bi-question-circle me-2"></i>Konfirmasi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="confirmMessage">Apakah Anda yakin ingin menyimpan perubahan?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="confirmAction">
                    <i class="bi bi-check-lg me-1"></i>Ya, Simpan
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('foto');
    const photoPreview = document.getElementById('photoPreview');
    const photoPreviewContainer = document.getElementById('photoPreviewContainer');
    const fileUploadArea = document.getElementById('fileUploadArea');
    const cropPhotoBtn = document.getElementById('cropPhotoBtn');
    const cancelUploadBtn = document.getElementById('cancelUploadBtn');
    const cropModal = document.getElementById('cropModal');
    const cropImage = document.getElementById('cropImage');
    const cropOverlay = document.getElementById('cropOverlay');
    const cropSlider = document.getElementById('cropSlider');
    const zoomValue = document.getElementById('zoomValue');
    const applyCropBtn = document.getElementById('applyCropBtn');
    const saveBtn = document.getElementById('saveBtn');
    const backBtn = document.getElementById('backBtn');
    const confirmModal = document.getElementById('confirmModal');
    const confirmMessage = document.getElementById('confirmMessage');
    const confirmAction = document.getElementById('confirmAction');
    const form = document.querySelector('form');

    let currentFile = null;
    let currentScale = 1;
    let currentX = 0;
    let currentY = 0;
    let isDragging = false;
    let dragStartX = 0;
    let dragStartY = 0;
    let hasChanges = false;

    // Track form changes
    const formInputs = form.querySelectorAll('input, textarea, select');
    formInputs.forEach(input => {
        input.addEventListener('change', function() {
            console.log('Form input changed:', input.name, input.value);
            hasChanges = true;
        });
    });

    // Handle checkbox change for aktif status
    const aktifCheckbox = document.getElementById('aktif');
    if (aktifCheckbox) {
        aktifCheckbox.addEventListener('change', function() {
            console.log('Aktif checkbox changed:', this.checked);
            hasChanges = true;
        });
    }

    // File input change handler
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        console.log('File input changed, file:', file);
        if (file) {
            console.log('File details:', {
                name: file.name,
                size: file.size,
                type: file.type
            });

            // Validate file size (2MB max)
            if (file.size > 2 * 1024 * 1024) {
                console.log('File too large:', file.size);
                showAlert('File terlalu besar. Maksimal 2MB.', 'error');
                return;
            }

            // Validate file type
            if (!file.type.startsWith('image/')) {
                console.log('Invalid file type:', file.type);
                showAlert('File harus berupa gambar.', 'error');
                return;
            }

            currentFile = file;
            hasChanges = true;
            console.log('File validated, hasChanges set to:', hasChanges);
            const reader = new FileReader();
            reader.onload = function(e) {
                photoPreview.src = e.target.result;
                photoPreviewContainer.style.display = 'block';
                fileUploadArea.style.display = 'none';
                console.log('Photo preview updated');
            };
            reader.readAsDataURL(file);
        }
    });

    // Crop photo button
    cropPhotoBtn.addEventListener('click', function() {
        if (currentFile) {
            const reader = new FileReader();
            reader.onload = function(e) {
                cropImage.src = e.target.result;
                const modal = new bootstrap.Modal(cropModal);
                modal.show();
                resetCropSettings();
            };
            reader.readAsDataURL(currentFile);
        }
    });

    // Cancel upload button
    cancelUploadBtn.addEventListener('click', function() {
        photoPreviewContainer.style.display = 'none';
        fileUploadArea.style.display = 'block';
        fileInput.value = '';
        currentFile = null;
        hasChanges = false;
    });

    // Crop slider change
    cropSlider.addEventListener('input', function() {
        currentScale = parseFloat(this.value);
        zoomValue.textContent = Math.round(currentScale * 100) + '%';
        updateCropImage();
    });

    // Apply crop button
    applyCropBtn.addEventListener('click', function() {
        if (currentFile) {
            cropImageToCanvas();
        }
    });

    // Drag functionality for crop image
    cropImage.addEventListener('mousedown', function(e) {
        isDragging = true;
        dragStartX = e.clientX - currentX;
        dragStartY = e.clientY - currentY;
        cropImage.style.cursor = 'grabbing';
        e.preventDefault();
    });

    document.addEventListener('mousemove', function(e) {
        if (isDragging) {
            currentX = e.clientX - dragStartX;
            currentY = e.clientY - dragStartY;
            updateCropImage();
        }
    });

    document.addEventListener('mouseup', function() {
        if (isDragging) {
            isDragging = false;
            cropImage.style.cursor = 'grab';
        }
    });

    // Save button with confirmation
    saveBtn.addEventListener('click', function(e) {
        e.preventDefault(); // Prevent default form submission
        console.log('Save button clicked, hasChanges:', hasChanges);
        console.log('Current file:', currentFile);
        console.log('Form data:', new FormData(form));

        if (hasChanges) {
            console.log('Changes detected, showing confirmation modal...');
            confirmMessage.textContent = 'Apakah Anda yakin ingin menyimpan perubahan data pengurus?';
            confirmAction.innerHTML = '<i class="bi bi-check-lg me-1"></i>Ya, Simpan';
            confirmAction.onclick = function() {
                console.log('Confirming save, submitting form...');
                console.log('Form action:', form.action);
                console.log('Form method:', form.method);
                console.log('Form enctype:', form.enctype);
                console.log('Form elements:', form.elements);

                // Check if form has file input
                const fileInput = form.querySelector('input[type="file"]');
                console.log('File input:', fileInput);
                console.log('File input files:', fileInput ? fileInput.files : 'No file input');

                // Submit form
                try {
                    form.submit();
                    console.log('Form submitted successfully');
                } catch (error) {
                    console.error('Error submitting form:', error);
                }
            };
            const modal = new bootstrap.Modal(confirmModal);
            modal.show();
        } else {
            console.log('No changes detected, submitting form directly...');
            try {
                form.submit();
                console.log('Form submitted directly');
            } catch (error) {
                console.error('Error submitting form directly:', error);
            }
        }
    });

    // Back button with confirmation
    backBtn.addEventListener('click', function(e) {
        if (hasChanges) {
            e.preventDefault();
            confirmMessage.textContent = 'Apakah Anda yakin ingin keluar? Perubahan yang belum disimpan akan hilang.';
            confirmAction.innerHTML = '<i class="bi bi-arrow-left me-1"></i>Ya, Keluar';
            confirmAction.onclick = function() {
                window.location.href = backBtn.href;
            };
            const modal = new bootstrap.Modal(confirmModal);
            modal.show();
        }
    });

    function resetCropSettings() {
        currentScale = 1;
        currentX = 0;
        currentY = 0;
        cropSlider.value = 1;
        zoomValue.textContent = '100%';
        updateCropImage();
    }

    function updateCropImage() {
        cropImage.style.transform = `translate(${currentX}px, ${currentY}px) scale(${currentScale})`;
    }

    function cropImageToCanvas() {
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');

        // Set canvas size to 400x400 for better quality
        canvas.width = 400;
        canvas.height = 400;

        // Create a circular clipping path
        ctx.beginPath();
        ctx.arc(200, 200, 200, 0, 2 * Math.PI);
        ctx.clip();

        // Calculate the source rectangle for cropping
        const img = new Image();
        img.onload = function() {
            const imgWidth = img.width;
            const imgHeight = img.height;

            // Calculate the crop area (center of the image)
            const cropSize = Math.min(imgWidth, imgHeight);
            const cropX = (imgWidth - cropSize) / 2;
            const cropY = (imgHeight - cropSize) / 2;

            // Draw the cropped image
            ctx.drawImage(img, cropX, cropY, cropSize, cropSize, 0, 0, 400, 400);

            // Convert to blob and update the form
            canvas.toBlob(function(blob) {
                const croppedFile = new File([blob], currentFile.name, { type: 'image/jpeg' });

                // Update the file input
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(croppedFile);
                fileInput.files = dataTransfer.files;

                // Update preview
                photoPreview.src = canvas.toDataURL();

                // Hide preview container and show upload area
                photoPreviewContainer.style.display = 'none';
                fileUploadArea.style.display = 'block';

                // Hide modal
                const modal = bootstrap.Modal.getInstance(cropModal);
                modal.hide();

                // Show success message
                showAlert('Foto berhasil di-crop dan siap diupload!', 'success');
            }, 'image/jpeg', 0.9);
        };
        img.src = cropImage.src;
    }

    function showAlert(message, type = 'info') {
        const alertClass = type === 'error' ? 'alert-danger' : 'alert-success';
        const icon = type === 'error' ? 'bi-exclamation-triangle' : 'bi-check-circle';

        const alertDiv = document.createElement('div');
        alertDiv.className = `alert ${alertClass} alert-dismissible fade show position-fixed`;
        alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        alertDiv.innerHTML = `
            <i class="bi ${icon} me-2"></i>${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(alertDiv);

        // Auto remove after 4 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.parentNode.removeChild(alertDiv);
            }
        }, 4000);
    }
});
</script>
@endpush
