@extends('layouts.dashboard')

@section('title', 'Tambah Pengurus Koperasi')
@section('page-title', 'Tambah Pengurus Koperasi')

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

    .action-buttons {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid rgba(37, 99, 235, 0.1);
    }

    @media (max-width: 768px) {
        .admin-form-body {
            padding: 1rem;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-primary-admin,
        .btn-secondary-admin {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="admin-form-card">
    <div class="admin-form-header">
        <h4 class="admin-form-title mb-0">
            <i class="bi bi-person-plus-fill me-2"></i>Form Tambah Pengurus Koperasi
        </h4>
    </div>
    <div class="admin-form-body">
        <form action="{{ route('administrator.pengurus-koperasi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror"
                               id="nama" name="nama" value="{{ old('nama') }}"
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
                            <option value="Kepala BPS" {{ old('jabatan') == 'Kepala BPS' ? 'selected' : '' }}>Kepala BPS</option>
                            <option value="Ketua Koperasi" {{ old('jabatan') == 'Ketua Koperasi' ? 'selected' : '' }}>Ketua Koperasi</option>
                            <option value="Wakil Ketua Koperasi" {{ old('jabatan') == 'Wakil Ketua Koperasi' ? 'selected' : '' }}>Wakil Ketua Koperasi</option>
                            <option value="Sekretaris Koperasi" {{ old('jabatan') == 'Sekretaris Koperasi' ? 'selected' : '' }}>Sekretaris Koperasi</option>
                            <option value="Bendahara Koperasi 1" {{ old('jabatan') == 'Bendahara Koperasi 1' ? 'selected' : '' }}>Bendahara Koperasi 1</option>
                            <option value="Bendahara Koperasi 2" {{ old('jabatan') == 'Bendahara Koperasi 2' ? 'selected' : '' }}>Bendahara Koperasi 2</option>
                            <option value="Bidang Usaha Koperasi" {{ old('jabatan') == 'Bidang Usaha Koperasi' ? 'selected' : '' }}>Bidang Usaha Koperasi</option>
                            <option value="Administrator Koperasi" {{ old('jabatan') == 'Administrator Koperasi' ? 'selected' : '' }}>Administrator Koperasi</option>
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
                          placeholder="Masukkan deskripsi singkat tentang pengurus">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email') }}"
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
                               id="telepon" name="telepon" value="{{ old('telepon') }}"
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
                               id="urutan" name="urutan" value="{{ old('urutan', 1) }}"
                               min="1" max="10" placeholder="1" required>
                        <div class="form-text">Urutan tampil di halaman depan (1-10)</div>
                        @error('urutan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="foto" class="form-label">Foto Profil</label>
                        <div class="file-upload-area">
                            <div class="file-upload-icon">
                                <i class="bi bi-cloud-upload"></i>
                            </div>
                            <div class="file-upload-text mb-2">Klik untuk memilih foto atau drag & drop</div>
                            <input type="file" class="form-control @error('foto') is-invalid @enderror"
                                   id="foto" name="foto" accept="image/*">
                            <div class="form-text">Format: JPG, PNG, GIF. Maksimal 2MB</div>
                        </div>
                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="aktif" name="aktif"
                       {{ old('aktif', true) ? 'checked' : '' }}>
                <label class="form-check-label" for="aktif">
                    Aktif (akan ditampilkan di halaman depan)
                </label>
            </div>

            <div class="action-buttons">
                <a href="{{ route('administrator.pengurus-koperasi.index') }}" class="btn-secondary-admin">
                    <i class="bi bi-arrow-left"></i>Kembali
                </a>
                <button type="submit" class="btn-primary-admin">
                    <i class="bi bi-check-lg"></i>Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
