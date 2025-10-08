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
        .profile-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .profile-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(149, 157, 165, 0.15);
            border: 1px solid #e5e7eb;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .profile-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 28px rgba(149, 157, 165, 0.2);
        }
        .photo-section {
            background: linear-gradient(145deg, #3b82f6, #2563eb);
            padding: 2rem;
            border-radius: 16px;
            margin-bottom: 1.5rem;
        }
        .photo-container {
            position: relative;
            width: 200px;
            height: 200px;
            margin: 0 auto 1.5rem;
        }
        .profile-photo {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            border: 4px solid #ffffff;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }
        .change-photo-btn {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 0.75rem 1.5rem;
            border-radius: 100px;
            color: white;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
        }
        .change-photo-btn:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
        }
        .info-card {
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
        }
        .info-card-header {
            background: linear-gradient(145deg, #f8fafc, #f1f5f9);
            padding: 1.25rem;
            border-bottom: 1px solid #e2e8f0;
        }
        .info-card-header h5 {
            color: #1e293b;
            font-weight: 600;
            margin: 0;
            font-size: 1.1rem;
        }
        .info-table {
            margin: 0;
        }
        .info-table td {
            padding: 1rem 1.25rem;
            border: none;
            font-size: 0.925rem;
        }
        .info-table tr {
            border-bottom: 1px solid #f1f5f9;
            transition: all 0.2s ease;
        }
        .info-table tr:last-child {
            border-bottom: none;
        }
        .info-table tr:hover {
            background: rgba(59, 130, 246, 0.05);
        }
        .label-col {
            color: #64748b;
            font-weight: 500;
        }
        .value-col {
            color: #1e293b;
            font-weight: 500;
        }
        .alert-custom {
            background: linear-gradient(145deg, #eff6ff, #dbeafe);
            border: 1px solid rgba(59, 130, 246, 0.1);
            color: #1e40af;
            padding: 1rem 1.25rem;
            border-radius: 12px;
            margin-top: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.875rem;
        }
        .alert-custom i {
            font-size: 1.25rem;
        }
    </style>

    <div class="profile-container">
        <div class="row">
            <div class="col-md-4">
                <div class="profile-card">
                    <div class="photo-section">
                        <div class="photo-container">
                            <img src="{{ $user['foto'] }}" class="profile-photo" alt="Foto Profile" id="previewFoto">
                        </div>
                        <div class="text-center">
                            <h4 class="text-white mb-2">{{ $user['nama'] }}</h4>
                            <p class="text-white-50 mb-3">{{ $user['jabatan'] }}</p>
                            <button class="change-photo-btn" data-bs-toggle="modal" data-bs-target="#editFotoModal">
                                <i class="bi bi-camera"></i> Ganti Foto
                            </button>
                        </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="info-card">
                <div class="info-card-header">
                    <h5><i class="bi bi-person-badge me-2"></i>Informasi Akun</h5>
                </div>
                <div class="card-body">
                    <table class="table info-table">
                        <tr>
                            <td class="label-col" width="200">Nama Lengkap</td>
                            <td class="value-col">: {{ $user['nama'] }}</td>
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
                            <td><strong>Golongan</strong></td>
                            <td>: {{ $user['golongan'] }}</td>
                        </tr>
                        <tr>
                            <td><strong>No. HP</strong></td>
                            <td>: {{ $user['no_hp'] }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email</strong></td>
                            <td>: {{ $user['email'] }}</td>
                        </tr>
                    </table>
                    <div class="alert-custom">
                        <i class="bi bi-info-circle"></i>
                        <span>Informasi akun tidak dapat diubah. Hanya foto profile yang dapat diganti.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Foto -->
    <div class="modal fade" id="editFotoModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ganti Foto Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formGantiFoto">
                        <div class="mb-3 text-center">
                            <img src="{{ $user['foto'] }}" class="rounded-circle mb-3" width="150" height="150" alt="Preview" id="modalPreview">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Upload Foto Baru</label>
                            <input type="file" class="form-control" id="inputFoto" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG. Max 2MB</small>
                        </div>
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle"></i> Ini adalah simulasi. Foto tidak akan tersimpan secara permanen.
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="simpanFoto()">Simpan Foto</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            let selectedImage = null;

            // Preview foto saat dipilih
            document.getElementById('inputFoto').addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        selectedImage = event.target.result;
                        document.getElementById('modalPreview').src = selectedImage;
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Simpan foto (dummy - hanya update tampilan)
            function simpanFoto() {
                if (selectedImage) {
                    document.getElementById('previewFoto').src = selectedImage;

                    // Tutup modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('editFotoModal'));
                    modal.hide();

                    // Alert sukses
                    alert('Foto profile berhasil diubah! (Simulasi - tidak tersimpan permanen)');
                } else {
                    alert('Silakan pilih foto terlebih dahulu');
                }
            }
        </script>
    @endpush
@endsection
