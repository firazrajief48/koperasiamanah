@extends('layouts.dashboard')

@section('title', 'Profile')
@section('page-title', 'Profile Akun')

@php
    $role = 'Administrator';
    $nama = $user->name;
    $routePrefix = 'administrator';
    $showLaporan = true;
@endphp

@section('main-content')
    <style>
        .profile-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 2rem;
        }

        .profile-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 700;
            color: white;
            flex-shrink: 0;
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            border-radius: 20px;
            object-fit: cover;
        }

        .profile-info h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0 0 0.5rem 0;
        }

        .profile-info .role {
            font-size: 1rem;
            color: #6b7280;
            font-weight: 500;
        }

        .profile-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-action {
            background: #dc2626;
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
        }

        .btn-action:hover {
            background: #b91c1c;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }

        .btn-action.secondary {
            background: #f8fafc;
            color: #64748b;
            border: 1px solid #e2e8f0;
        }

        .btn-action.secondary:hover {
            background: #f1f5f9;
            color: #475569;
            border-color: #cbd5e1;
        }

        .btn-action.logout {
            background: linear-gradient(135deg, #ef4444 0%, #f87171 100%);
            color: white;
            border: none;
        }

        .btn-action.logout:hover {
            background: linear-gradient(135deg, #f87171 0%, #ef4444 100%);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .logout-icon {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(239, 68, 68, 0); }
            100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
        }

        .info-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .info-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid #f3f4f6;
        }

        .info-card-header {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .info-card-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            margin-right: 0.75rem;
            background: #dc2626;
            color: white;
        }

        .info-card-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1f2937;
            margin: 0;
        }

        .info-table {
            width: 100%;
        }

        .info-table tr {
            border-bottom: 1px solid #f3f4f6;
        }

        .info-table tr:last-child {
            border-bottom: none;
        }

        .info-table td {
            padding: 0.75rem 0.5rem;
            vertical-align: top;
        }

        .label-col {
            font-weight: 500;
            color: #6b7280;
            width: 40%;
            font-size: 0.9rem;
            padding-left: 0;
        }

        .value-col {
            color: #1f2937;
            font-weight: 500;
        }

        .value-col .empty-text {
            color: #9ca3af;
            font-style: italic;
        }

        /* Modal Styles */
        .modal-content {
            border-radius: 12px;
            border: none;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            border-radius: 12px 12px 0 0;
            padding: 1.5rem;
        }

        .modal-title {
            font-weight: 600;
            color: #1f2937;
            font-size: 1.2rem;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .form-label {
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 0.75rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #dc2626;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
        }

        .btn-primary {
            background: #dc2626;
            border: none;
            border-radius: 6px;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #b91c1c;
        }

        .btn-secondary {
            background: #f8fafc;
            border: 1px solid #d1d5db;
            color: #374151;
            border-radius: 6px;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: #f3f4f6;
            border-color: #9ca3af;
        }

        /* Success Toast */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }

        .toast {
            background: #dc2626;
            color: white;
            border: none;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(220, 38, 38, 0.3);
        }

        .toast-header {
            background: rgba(255, 255, 255, 0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .profile-container {
                padding: 1rem;
            }

            .profile-header {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .profile-actions {
                justify-content: center;
            }

            .info-cards {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
        }
    </style>

    <div class="profile-container">
        <!-- Profile Card -->
        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-avatar">
                    @if($user->photo && file_exists(public_path('storage/' . $user->photo)))
                        <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}">
                    @else
                        <i class="bi bi-person"></i>
                    @endif
                </div>
                <div class="profile-info">
                    <h1>{{ $user->name }}</h1>
                    <div class="role">{{ $user->jabatan ?? 'Administrator' }}</div>
                </div>
            </div>
            <div class="profile-actions">
                <button class="btn-action" data-bs-toggle="modal" data-bs-target="#editPhotoModal">
                    <i class="bi bi-camera"></i>
                    Edit Foto
                </button>
                <button class="btn-action secondary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                    <i class="bi bi-pencil-square"></i>
                    Edit Profile
                </button>
                <button class="btn-action secondary" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                    <i class="bi bi-shield-lock"></i>
                    Ubah Password
                </button>
                <button class="btn-action logout" data-bs-toggle="modal" data-bs-target="#logoutModal">
                    <i class="bi bi-box-arrow-right"></i>
                    Logout
                </button>
            </div>
        </div>

        <!-- Information Cards -->
        <div class="info-cards">
            <!-- Personal Information -->
            <div class="info-card">
                <div class="info-card-header">
                    <div class="info-card-icon">
                        <i class="bi bi-person"></i>
                    </div>
                    <h3 class="info-card-title">Informasi Pribadi</h3>
                </div>
                <table class="info-table">
                    <tr>
                        <td class="label-col">Nama Lengkap</td>
                        <td class="value-col">: {{ $user->name }}</td>
                    </tr>
                    <tr>
                        <td class="label-col">NIP</td>
                        <td class="value-col">: {{ $user->nip ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label-col">Jabatan</td>
                        <td class="value-col">: {{ $user->jabatan ?? 'Administrator' }}</td>
                    </tr>
                    <tr>
                        <td class="label-col">Golongan</td>
                        <td class="value-col">: {{ $user->golongan ?? '-' }}</td>
                    </tr>
                </table>
            </div>

            <!-- Contact Information -->
            <div class="info-card">
                <div class="info-card-header">
                    <div class="info-card-icon">
                        <i class="bi bi-envelope"></i>
                    </div>
                    <h3 class="info-card-title">Informasi Kontak</h3>
                </div>
                <table class="info-table">
                    <tr>
                        <td class="label-col">No. HP</td>
                        <td class="value-col">
                            @if($user->phone)
                                {{ $user->phone }}
                            @else
                                <span class="empty-text">Belum diisi</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="label-col">Email</td>
                        <td class="value-col">{{ $user->email }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Edit Photo Modal -->
    <div class="modal fade" id="editPhotoModal" tabindex="-1" aria-labelledby="editPhotoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPhotoModalLabel">
                        <i class="bi bi-camera me-2"></i>Edit Foto Profile
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('administrator.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <div class="profile-avatar mx-auto mb-3" style="width: 80px; height: 80px;">
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
                            <input type="file" class="form-control @error('photo') is-invalid @enderror"
                                   id="photo" name="photo" accept="image/*">
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Format yang didukung: JPG, PNG, GIF. Maksimal 2MB.</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-2"></i>Simpan Foto
                        </button>
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
                    <h5 class="modal-title" id="editProfileModalLabel">
                        <i class="bi bi-pencil-square me-2"></i>Edit Profile
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('administrator.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nip" class="form-label">NIP</label>
                                <input type="text" class="form-control @error('nip') is-invalid @enderror"
                                       id="nip" name="nip" value="{{ old('nip', $user->nip) }}">
                                @error('nip')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="jabatan" class="form-label">Jabatan</label>
                                <input type="text" class="form-control @error('jabatan') is-invalid @enderror"
                                       id="jabatan" name="jabatan" value="{{ old('jabatan', $user->jabatan) }}">
                                @error('jabatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="golongan" class="form-label">Golongan</label>
                                <input type="text" class="form-control @error('golongan') is-invalid @enderror"
                                       id="golongan" name="golongan" value="{{ old('golongan', $user->golongan) }}">
                                @error('golongan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">No. HP</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                       id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">
                        <i class="bi bi-shield-lock me-2"></i>Ubah Password
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('administrator.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password" placeholder="Masukkan password baru">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control"
                                   id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi password baru">
                        </div>
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Catatan:</strong> Kosongkan field password jika tidak ingin mengubah password.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-2"></i>Ubah Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Success Toast -->
    <div class="toast-container">
        <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="bi bi-check-circle-fill me-2"></i>
                <strong class="me-auto">Berhasil!</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Profile berhasil diupdate!
            </div>
        </div>
    </div>

    <script>
        // Show success message if redirected with success
        @if(session('success'))
            document.addEventListener('DOMContentLoaded', function() {
                const toast = new bootstrap.Toast(document.getElementById('successToast'));
                toast.show();
            });
        @endif

        // Show validation errors
        @if($errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                const modal = new bootstrap.Modal(document.getElementById('editProfileModal'));
                modal.show();
            });
        @endif

        // Handle logout confirmation
        document.addEventListener('DOMContentLoaded', function() {
            const logoutModal = document.getElementById('logoutModal');
            if (logoutModal) {
                logoutModal.addEventListener('shown.bs.modal', function() {
                    const confirmLogoutBtn = this.querySelector('#confirmLogoutBtn');
                    if (confirmLogoutBtn && !confirmLogoutBtn.dataset.listenerAttached) {
                        confirmLogoutBtn.dataset.listenerAttached = 'true';
                        confirmLogoutBtn.addEventListener('click', function() {
                            const originalText = this.innerHTML;
                            this.innerHTML = '<i class="bi bi-hourglass-split"></i>Logging out...';
                            this.disabled = true;
                            this.style.opacity = '0.7';

                            // Create form and submit to logout route
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = '{{ route("logout") }}';

                            const csrfToken = document.createElement('input');
                            csrfToken.type = 'hidden';
                            csrfToken.name = '_token';
                            csrfToken.value = '{{ csrf_token() }}';

                            form.appendChild(csrfToken);
                            document.body.appendChild(form);
                            form.submit();
                        });
                    }
                });
            }
        });
    </script>

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);">
                <div class="modal-header" style="border-bottom: 1px solid #e5e7eb; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-radius: 16px 16px 0 0;">
                    <div class="d-flex align-items-center">
                        <div class="logout-icon me-3" style="width: 48px; height: 48px; background: linear-gradient(135deg, #ef4444 0%, #f87171 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-box-arrow-right text-white fs-5"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold mb-0" id="logoutModalLabel" style="color: #1f2937;">Konfirmasi Logout</h5>
                            <small class="text-muted">Keluar dari sistem</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <p class="mb-0" style="color: #4b5563; line-height: 1.6;">Apakah Anda yakin ingin keluar dari sistem?</p>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #e5e7eb; padding: 1.25rem 1.5rem; gap: 0.75rem;">
                    <button type="button" class="btn btn-outline-secondary flex-fill" data-bs-dismiss="modal" style="border-radius: 10px; font-weight: 500; padding: 0.75rem;">
                        <i class="bi bi-x-circle me-2"></i>Batal
                    </button>
                    <button type="button" class="btn btn-danger flex-fill" id="confirmLogoutBtn" style="border-radius: 10px; font-weight: 500; padding: 0.75rem; background: linear-gradient(135deg, #ef4444 0%, #f87171 100%); border: none;">
                        <i class="bi bi-box-arrow-right me-2"></i>Ya, Logout
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
