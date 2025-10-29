@extends('layouts.dashboard')

@section('title', 'Profile')
@section('page-title', 'Profile Akun')

@php
    $role = 'Kepala BPS';
    $nama = $user->name;
    $routePrefix = 'kepala_bps';
    $showLaporan = true;
@endphp

@section('main-content')
    <style>
        :root { --primary-blue:#1e40af; --primary-light:#3b82f6; --dark-navy:#0f172a; }
        body { font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background:linear-gradient(135deg,#f0f9ff 0%,#e0e7ff 100%); min-height:100vh; }
        .welcome-banner { background:linear-gradient(135deg,#1e40af 0%,#3b82f6 50%,#6366f1 100%); border-radius:20px; padding:1.5rem 2rem; margin-bottom:1.5rem; position:relative; overflow:hidden; box-shadow:0 10px 30px rgba(30,64,175,.2); }
        .welcome-content { position:relative; z-index:2; display:flex; align-items:center; gap:1.25rem; }
        .profile-avatar-banner { width:80px; height:80px; background:rgba(255,255,255,.2); backdrop-filter:blur(10px); border-radius:20px; display:flex; align-items:center; justify-content:center; overflow:hidden; }
        .profile-avatar-banner img { width:100%; height:100%; object-fit:cover; }
        .profile-avatar-banner i { font-size:2.5rem; color:#fff; }
        .welcome-banner h2 { color:#fff; font-size:1.5rem; font-weight:700; margin-bottom:.25rem; }
        .welcome-banner p { color:rgba(255,255,255,.9); font-size:.875rem; margin-bottom:0; }
        .action-buttons-card { background:rgba(255,255,255,.8); backdrop-filter:blur(30px); border-radius:20px; padding:1.5rem 2rem; margin-bottom:1.5rem; box-shadow:0 10px 40px rgba(30,64,175,.1); border:2px solid rgba(255,255,255,.6); }
        .action-buttons-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:1rem; }
        .btn-action { background:#fff; border:2px solid #e2e8f0; color:#475569; padding:1rem 1.5rem; border-radius:12px; font-weight:600; font-size:.875rem; display:inline-flex; align-items:center; justify-content:center; gap:.5rem; transition:.3s; }
        .btn-action:hover { background:#f8fafc; border-color:#cbd5e1; transform:translateY(-2px); }
        .btn-action.primary { background:linear-gradient(135deg,#3b82f6 0%,#6366f1 100%); border:none; color:#fff; }
        .info-cards-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(400px,1fr)); gap:1.5rem; }
        .info-card { background:rgba(255,255,255,.8); backdrop-filter:blur(30px); border-radius:20px; overflow:hidden; box-shadow:0 10px 40px rgba(30,64,175,.1); border:2px solid rgba(255,255,255,.6); }
        .info-card-header { background:linear-gradient(135deg,rgba(30,64,175,.08) 0%,rgba(99,102,241,.08) 100%); padding:1.5rem 2rem; border-bottom:2px solid rgba(30,64,175,.1); display:flex; align-items:center; gap:.75rem; }
        .info-card-icon { width:40px; height:40px; border-radius:12px; background:linear-gradient(135deg,var(--primary-blue),var(--primary-light)); display:flex; align-items:center; justify-content:center; color:#fff; font-size:1.125rem; }
        .info-card-title { font-size:1.125rem; font-weight:700; color:var(--dark-navy); margin:0; }
        .info-card-body { padding:2rem; }
        .info-table { width:100%; border-collapse:collapse; }
        .info-table tr { border-bottom:1px solid rgba(226,232,240,.5); }
        .info-table tr:last-child { border-bottom:none; }
        .info-table td { padding:.875rem 0; }
        .label-col { font-weight:600; color:#64748b; width:35%; padding-right:1rem; font-size:.875rem; }
        .value-col { color:#1f2937; font-weight:500; font-size:.875rem; }
        .value-col .empty-text { color:#9ca3af; font-style:italic; }
    </style>

    <div class="welcome-banner">
        <div class="welcome-content">
            <div class="profile-avatar-banner">
                @if($user->photo && file_exists(public_path('storage/' . $user->photo)))
                    <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}">
                @else
                    <i class="bi bi-person"></i>
                @endif
            </div>
            <div>
                <h2>{{ $user->name }}</h2>
                <p>{{ $user->jabatan ?? 'Kepala BPS' }} • Kelola informasi akun Anda</p>
            </div>
        </div>
    </div>

    <div class="action-buttons-card">
        <div class="action-buttons-grid">
            <button class="btn-action primary" data-bs-toggle="modal" data-bs-target="#editPhotoModal"><i class="bi bi-camera"></i>Edit Foto</button>
            <button class="btn-action" data-bs-toggle="modal" data-bs-target="#editProfileModal"><i class="bi bi-pencil-square"></i>Edit Profile</button>
            <button class="btn-action" data-bs-toggle="modal" data-bs-target="#changePasswordModal"><i class="bi bi-shield-lock"></i>Ubah Password</button>
        </div>
    </div>

    <div class="info-cards-grid">
        <div class="info-card">
            <div class="info-card-header"><div class="info-card-icon"><i class="bi bi-person"></i></div><h3 class="info-card-title">Informasi Pribadi</h3></div>
            <div class="info-card-body">
                <table class="info-table">
                    <tr><td class="label-col">Nama Lengkap</td><td class="value-col">{{ $user->name }}</td></tr>
                    <tr><td class="label-col">NIP</td><td class="value-col">@if($user->nip){{ $user->nip }}@else<span class="empty-text">Belum diisi</span>@endif</td></tr>
                    <tr><td class="label-col">Jabatan</td><td class="value-col">{{ $user->jabatan ?? 'Kepala BPS' }}</td></tr>
                    <tr><td class="label-col">Golongan</td><td class="value-col">@if($user->golongan){{ $user->golongan }}@else<span class="empty-text">Belum diisi</span>@endif</td></tr>
                </table>
            </div>
        </div>
        <div class="info-card">
            <div class="info-card-header"><div class="info-card-icon"><i class="bi bi-envelope"></i></div><h3 class="info-card-title">Informasi Kontak</h3></div>
            <div class="info-card-body">
                <table class="info-table">
                    <tr><td class="label-col">No. HP</td><td class="value-col">@if($user->phone){{ $user->phone }}@else<span class="empty-text">Belum diisi</span>@endif</td></tr>
                    <tr><td class="label-col">Email</td><td class="value-col">{{ $user->email }}</td></tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Edit Photo Modal -->
    <div class="modal fade" id="editPhotoModal" tabindex="-1" aria-labelledby="editPhotoModalLabel" aria-hidden="true">
        <div class="modal-dialog"><div class="modal-content">
            <div class="modal-header"><h5 class="modal-title" id="editPhotoModalLabel"><i class="bi bi-camera"></i><span>Edit Foto Profile</span></h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
            <form action="{{ route($routePrefix . '.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <input type="hidden" name="update_type" value="photo">
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <div class="profile-avatar-banner mx-auto mb-3">
                            @if($user->photo && file_exists(public_path('storage/' . $user->photo)))
                                <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}">
                            @else
                                <i class="bi bi-person"></i>
                            @endif
                        </div>
                        <p class="text-muted">Foto saat ini</p>
                    </div>
                    <div class="mb-3"><label for="photo" class="form-label">Pilih Foto Baru</label><input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*">@error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror<div class="form-text">Format: JPG/PNG/GIF, maks 2MB.</div></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i>Batal</button><button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i>Simpan Foto</button></div>
            </form>
        </div></div>
    </div>

    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"><div class="modal-content">
            <div class="modal-header"><h5 class="modal-title" id="editProfileModalLabel"><i class="bi bi-pencil-square"></i><span>Edit Profile</span></h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
            <form action="{{ route($routePrefix . '.profile.update') }}" method="POST">@csrf @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3"><label for="name" class="form-label">Nama Lengkap</label><input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                        <div class="col-md-6 mb-3"><label for="email" class="form-label">Email</label><input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                        <div class="col-md-6 mb-3"><label for="nip" class="form-label">NIP</label><input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" name="nip" value="{{ old('nip', $user->nip) }}">@error('nip')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                        <div class="col-md-6 mb-3"><label for="jabatan" class="form-label">Jabatan</label><input type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan" name="jabatan" value="{{ old('jabatan', $user->jabatan) }}">@error('jabatan')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                        <div class="col-md-6 mb-3"><label for="golongan" class="form-label">Golongan</label><input type="text" class="form-control @error('golongan') is-invalid @enderror" id="golongan" name="golongan" value="{{ old('golongan', $user->golongan) }}">@error('golongan')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                        <div class="col-md-6 mb-3"><label for="phone" class="form-label">No. HP</label><input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">@error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    </div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i>Batal</button><button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i>Simpan Perubahan</button></div>
            </form>
        </div></div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog"><div class="modal-content">
            <div class="modal-header"><h5 class="modal-title" id="changePasswordModalLabel"><i class="bi bi-shield-lock"></i><span>Ubah Password</span></h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
            <form action="{{ route($routePrefix . '.profile.update') }}" method="POST">@csrf @method('PUT')
                <div class="modal-body">
                    <div class="mb-3"><label for="password" class="form-label">Password Baru</label><input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Masukkan password baru">@error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="mb-3"><label for="password_confirmation" class="form-label">Konfirmasi Password</label><input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi password baru"></div>
                    <div class="alert alert-info"><i class="bi bi-info-circle"></i><span><strong>Catatan:</strong> Kosongkan field password jika tidak ingin mengubah password.</span></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i>Batal</button><button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i>Ubah Password</button></div>
            </form>
        </div></div>
    </div>

    <div class="toast-container"><div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true"><div class="toast-header"><i class="bi bi-check-circle-fill me-2"></i><strong class="me-auto">Berhasil!</strong><button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button></div><div class="toast-body">Profile berhasil diupdate!</div></div></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const photoInput = document.querySelector('#editPhotoModal input[type="file"]');
            if (photoInput) {
                photoInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const previewImg = document.querySelector('#editPhotoModal .profile-avatar-banner img');
                            const previewIcon = document.querySelector('#editPhotoModal .profile-avatar-banner i');
                            if (previewImg) { previewImg.src = e.target.result; }
                            else if (previewIcon) { const container = previewIcon.parentElement; container.innerHTML = '<img src="' + e.target.result + '" alt="Preview">'; }
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        });

        @if(session('success'))
            document.addEventListener('DOMContentLoaded', function() { const toast = new bootstrap.Toast(document.getElementById('successToast')); toast.show(); });
        @endif

        @if($errors->any() && isset($errors) && count($errors) > 0)
            document.addEventListener('DOMContentLoaded', function() {
                const hasPhotoError = {{ $errors->has('photo') ? 'true' : 'false' }};
                const modalId = hasPhotoError ? 'editPhotoModal' : 'editProfileModal';
                const modal = new bootstrap.Modal(document.getElementById(modalId));
                modal.show();
            });
        @endif
    </script>

@endsection
