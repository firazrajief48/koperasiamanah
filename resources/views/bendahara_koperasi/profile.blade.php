@extends('layouts.dashboard')

@section('title', 'Profile')
@section('page-title', 'Profile Akun')

@php
    $role = 'Bendahara Koperasi';
    $nama = $user->name;
    $routePrefix = 'bendahara_koperasi';
    $showLaporan = true;
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

        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #f0f9ff 0%, #e0e7ff 100%); min-height: 100vh; }

        .welcome-banner { background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #6366f1 100%); border-radius: 20px; padding: 1.5rem 2rem; margin-bottom: 1.5rem; position: relative; overflow: hidden; box-shadow: 0 10px 30px rgba(30, 64, 175, 0.2); animation: slideDown 0.6s ease-out; }
        .welcome-banner::before { content: ''; position: absolute; top: -50%; right: -10%; width: 400px; height: 400px; background: radial-gradient(circle, rgba(255, 255, 255, 0.08) 0%, transparent 70%); border-radius: 50%; animation: float 20s infinite ease-in-out; }
        @keyframes float { 0%, 100% { transform: translate(0, 0) rotate(0deg); } 33% { transform: translate(20px, -20px) rotate(3deg); } 66% { transform: translate(-15px, 15px) rotate(-3deg); } }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-20px);} to { opacity: 1; transform: translateY(0);} }
        .welcome-content { position: relative; z-index: 2; display: flex; align-items: center; gap: 1.25rem; }
        .profile-avatar-banner { width: 80px; height: 80px; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); border-radius: 20px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; overflow: hidden; }
        .profile-avatar-banner img { width: 100%; height: 100%; object-fit: cover; }
        .profile-avatar-banner i { font-size: 2.5rem; color: white; }
        .welcome-banner h2 { color: white; font-size: 1.5rem; font-weight: 700; margin-bottom: 0.25rem; }
        .welcome-banner p { color: rgba(255, 255, 255, 0.9); font-size: 0.875rem; margin-bottom: 0; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px);} to { opacity: 1; transform: translateY(0);} }

        .action-buttons-card { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(30px); border-radius: 20px; padding: 1.5rem 2rem; margin-bottom: 1.5rem; box-shadow: 0 10px 40px rgba(30, 64, 175, 0.1); border: 2px solid rgba(255, 255, 255, 0.6); animation: fadeInUp 0.6s ease-out 0.1s both; }
        .action-buttons-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; }
        .btn-action { background: white; border: 2px solid #e2e8f0; color: #475569; padding: 1rem 1.5rem; border-radius: 12px; font-weight: 600; font-size: 0.875rem; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05); }
        .btn-action:hover { background: #f8fafc; border-color: #cbd5e1; color: #475569; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); }
        .btn-action.primary { background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%); border: none; color: white; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3); }
        .btn-action.primary:hover { background: linear-gradient(135deg, #2563eb 0%, #4f46e5 100%); color: white; transform: translateY(-3px); box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4); }

        .info-cards-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 1.5rem; }
        .info-card { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(30px); border-radius: 20px; overflow: hidden; box-shadow: 0 10px 40px rgba(30, 64, 175, 0.1); border: 2px solid rgba(255, 255, 255, 0.6); animation: fadeInUp 0.6s ease-out both; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .info-card:nth-child(1) { animation-delay: 0.2s; } .info-card:nth-child(2) { animation-delay: 0.3s; }
        .info-card:hover { transform: translateY(-4px); box-shadow: 0 15px 45px rgba(30, 64, 175, 0.15); }
        .info-card-header { background: linear-gradient(135deg, rgba(30, 64, 175, 0.08) 0%, rgba(99, 102, 241, 0.08) 100%); padding: 1.5rem 2rem; border-bottom: 2px solid rgba(30, 64, 175, 0.1); display: flex; align-items: center; gap: 0.75rem; }
        .info-card-icon { width: 40px; height: 40px; border-radius: 12px; background: linear-gradient(135deg, var(--primary-blue), var(--primary-light)); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.125rem; }
        .info-card-title { font-size: 1.125rem; font-weight: 700; color: var(--dark-navy); margin: 0; }
        .info-card-body { padding: 2rem; }
        .info-table { width: 100%; border-collapse: collapse; }
        .info-table tr { border-bottom: 1px solid rgba(226, 232, 240, 0.5); }
        .info-table tr:last-child { border-bottom: none; }
        .info-table td { padding: 0.875rem 0; vertical-align: top; }
        .label-col { font-weight: 600; color: #64748b; width: 35%; font-size: 0.875rem; padding-right: 1rem; }
        .value-col { color: #1f2937; font-weight: 500; font-size: 0.875rem; word-break: break-word; }
        .value-col .empty-text { color: #9ca3af; font-style: italic; font-weight: 400; }

        .modal-content { border-radius: 16px; border: none; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15); }
        .modal-header { background: linear-gradient(135deg, rgba(248, 250, 252, 0.9) 0%, rgba(241, 245, 249, 0.9) 100%); border-bottom: 2px solid rgba(226, 232, 240, 0.5); border-radius: 16px 16px 0 0; padding: 1.5rem 2rem; }
        .modal-title { font-weight: 700; color: var(--dark-navy); font-size: 1.125rem; display: flex; align-items: center; gap: 0.5rem; }
        .modal-body { padding: 2rem; }
        .form-label { font-weight: 600; color: #475569; margin-bottom: 0.5rem; font-size: 0.875rem; }
        .form-control, .form-select { border-radius: 12px; padding: 0.75rem 1rem; border: 2px solid rgba(30, 64, 175, 0.1); font-size: 0.875rem; transition: all 0.3s ease; background: white; }
        .form-control:focus, .form-select:focus { border-color: var(--primary-blue); box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); background: white; }
        .modal-footer { border-top: 2px solid rgba(226, 232, 240, 0.5); padding: 1.5rem 2rem; gap: 0.75rem; background: linear-gradient(135deg, rgba(248, 250, 252, 0.5) 0%, rgba(241, 245, 249, 0.5) 100%); }
        .modal-footer .btn { padding: 0.75rem 1.75rem; border-radius: 12px; font-weight: 600; font-size: 0.875rem; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); display: inline-flex; align-items: center; gap: 0.5rem; border: none; }
        .modal-footer .btn-primary { background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%); color: white; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3); }
        .modal-footer .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4); background: linear-gradient(135deg, #2563eb 0%, #4f46e5 100%); }
        .modal-footer .btn-secondary { background: white; border: 2px solid #e2e8f0; color: #475569; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05); }
        .modal-footer .btn-secondary:hover { background: #f8fafc; border-color: #cbd5e1; transform: translateY(-2px); }

        .alert-info { background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(99, 102, 241, 0.1) 100%); border: 2px solid rgba(59, 130, 246, 0.3); border-radius: 12px; color: var(--primary-blue); padding: 1rem 1.25rem; font-size: 0.875rem; display: flex; align-items: center; gap: 0.75rem; }

        .toast-container { position: fixed; top: 20px; right: 20px; z-index: 9999; }
        .toast { background: linear-gradient(135deg, #10b981 0%, #34d399 100%); color: white; border: none; border-radius: 12px; box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3); min-width: 300px; }
        .toast-header { background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(255, 255, 255, 0.2); color: white; border-radius: 12px 12px 0 0; }
        .toast-body { color: white; font-weight: 500; }

        @media (max-width: 768px) { .welcome-banner { padding: 1.25rem 1.5rem; } .welcome-content { flex-direction: column; align-items: flex-start; gap: 0.75rem; } .welcome-banner h2 { font-size: 1.25rem; } .action-buttons-card { padding: 1.25rem 1.5rem; } .action-buttons-grid { grid-template-columns: 1fr; } .info-cards-grid { grid-template-columns: 1fr; } .info-card-header, .info-card-body { padding: 1.25rem 1.5rem; } }
        @media (max-width: 600px) { .info-cards-grid { grid-template-columns: 1fr; } }
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
                <p>{{ $user->jabatan ?? 'Bendahara Koperasi' }} • Kelola informasi akun Anda</p>
            </div>
        </div>
    </div>

    <div class="action-buttons-card">
        <div class="action-buttons-grid">
            <button class="btn-action primary" data-bs-toggle="modal" data-bs-target="#editPhotoModal">
                <i class="bi bi-camera"></i>
                Edit Foto
            </button>
            <button class="btn-action" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                <i class="bi bi-pencil-square"></i>
                Edit Profile
            </button>
            <button class="btn-action" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                <i class="bi bi-shield-lock"></i>
                Ubah Password
            </button>
        </div>
    </div>

    <div class="info-cards-grid">
        <div class="info-card">
            <div class="info-card-header">
                <div class="info-card-icon"><i class="bi bi-person"></i></div>
                <h3 class="info-card-title">Informasi Pribadi</h3>
            </div>
            <div class="info-card-body">
                <table class="info-table">
                    <tr><td class="label-col">Nama Lengkap</td><td class="value-col">{{ $user->name }}</td></tr>
                    <tr><td class="label-col">NIP</td><td class="value-col">@if($user->nip){{ $user->nip }}@else<span class="empty-text">Belum diisi</span>@endif</td></tr>
                    <tr><td class="label-col">Jabatan</td><td class="value-col">{{ $user->jabatan ?? 'Bendahara Koperasi' }}</td></tr>
                    <tr><td class="label-col">Golongan</td><td class="value-col">@if($user->golongan){{ $user->golongan }}@else<span class="empty-text">Belum diisi</span>@endif</td></tr>
                </table>
            </div>
        </div>
        <div class="info-card">
            <div class="info-card-header">
                <div class="info-card-icon"><i class="bi bi-envelope"></i></div>
                <h3 class="info-card-title">Informasi Kontak</h3>
            </div>
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPhotoModalLabel"><i class="bi bi-camera"></i><span>Edit Foto Profile</span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route($routePrefix . '.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
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
                        <div class="mb-3">
                            <label for="photo" class="form-label">Pilih Foto Baru</label>
                            <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*">
                            @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="form-text">Format yang didukung: JPG, PNG, GIF. Maksimal 2MB.</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i>Batal</button>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i>Simpan Foto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel"><i class="bi bi-pencil-square"></i><span>Edit Profile</span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route($routePrefix . '.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
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
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title" id="changePasswordModalLabel"><i class="bi bi-shield-lock"></i><span>Ubah Password</span></h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
                <form action="{{ route($routePrefix . '.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3"><label for="password" class="form-label">Password Baru</label><input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Masukkan password baru">@error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                        <div class="mb-3"><label for="password_confirmation" class="form-label">Konfirmasi Password</label><input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi password baru"></div>
                        <div class="alert alert-info"><i class="bi bi-info-circle"></i><span><strong>Catatan:</strong> Kosongkan field password jika tidak ingin mengubah password.</span></div>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i>Batal</button><button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i>Ubah Password</button></div>
                </form>
            </div>
        </div>
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
