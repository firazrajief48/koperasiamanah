@extends('layouts.dashboard')

@section('title', 'Profile')
@section('page-title', 'Profile Akun')

@php
    $role = 'Kepala Koperasi';
    $routePrefix = 'kepala_koperasi';
    $showLaporan = true;
@endphp

@section('main-content')
    <div class="row">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <img src="{{ $user['foto'] }}" class="rounded-circle mb-3" width="200" height="200" alt="Foto Profile" id="previewFoto">
                    <h4>{{ $user['nama'] }}</h4>
                    <p class="text-muted">{{ $user['jabatan'] }}</p>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editFotoModal">
                        <i class="bi bi-camera"></i> Ganti Foto
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Informasi Akun</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <td width="200"><strong>Nama Lengkap</strong></td>
                            <td>: {{ $user['nama'] }}</td>
                        </tr>
                        <tr>
                            <td><strong>NIP</strong></td>
                            <td>: {{ $user['nip'] }}</td>
                        </tr>
                        <tr>
                            <td><strong>Jabatan</strong></td>
                            <td>: {{ $user['jabatan'] }}</td>
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
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> Informasi akun tidak dapat diubah. Hanya foto profile yang dapat diganti.
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
