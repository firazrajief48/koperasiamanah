@extends('layouts.dashboard')

@section('title', 'Tambah User')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: var(--dark-navy);">
                <i class="bi bi-person-plus me-2"></i>Tambah User Baru
            </h2>
            <p class="text-muted mb-0">Tambahkan user baru ke sistem koperasi</p>
        </div>
        <a href="{{ route('administrator.kelola-user') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-header bg-transparent border-0 p-4">
                    <h5 class="fw-bold mb-0" style="color: var(--dark-navy);">
                        <i class="bi bi-form me-2"></i>Form Tambah User
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('administrator.store-user') }}">
                        @csrf

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="name" class="form-label fw-semibold">
                                    <i class="bi bi-person me-1"></i>Nama Lengkap
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold">
                                    <i class="bi bi-envelope me-1"></i>Email
                                </label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="role" class="form-label fw-semibold">
                                    <i class="bi bi-person-badge me-1"></i>Role
                                </label>
                                <select class="form-select @error('role') is-invalid @enderror"
                                        id="role" name="role" required>
                                    <option value="">Pilih Role</option>
                                    <option value="peminjam" {{ old('role') == 'peminjam' ? 'selected' : '' }}>Anggota</option>
                                    <option value="kepala_bps" {{ old('role') == 'kepala_bps' ? 'selected' : '' }}>Kepala BPS</option>
                                    <option value="bendahara_koperasi" {{ old('role') == 'bendahara_koperasi' ? 'selected' : '' }}>Bendahara Koperasi</option>
                                    <option value="ketua_koperasi" {{ old('role') == 'ketua_koperasi' ? 'selected' : '' }}>Ketua Koperasi</option>
                                    <option value="administrator" {{ old('role') == 'administrator' ? 'selected' : '' }}>Administrator</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="nip" class="form-label fw-semibold">
                                    <i class="bi bi-card-text me-1"></i>NIP
                                </label>
                                <input type="text" class="form-control @error('nip') is-invalid @enderror"
                                       id="nip" name="nip" value="{{ old('nip') }}">
                                @error('nip')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="golongan" class="form-label fw-semibold">
                                    <i class="bi bi-award me-1"></i>Golongan
                                </label>
                                <input type="text" class="form-control @error('golongan') is-invalid @enderror"
                                       id="golongan" name="golongan" value="{{ old('golongan') }}">
                                @error('golongan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="jabatan" class="form-label fw-semibold">
                                    <i class="bi bi-briefcase me-1"></i>Jabatan
                                </label>
                                <input type="text" class="form-control @error('jabatan') is-invalid @enderror"
                                       id="jabatan" name="jabatan" value="{{ old('jabatan') }}">
                                @error('jabatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-semibold">
                                    <i class="bi bi-telephone me-1"></i>No HP
                                </label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                       id="phone" name="phone" value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password" class="form-label fw-semibold">
                                    <i class="bi bi-lock me-1"></i>Password
                                </label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                       id="password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="password_confirmation" class="form-label fw-semibold">
                                    <i class="bi bi-lock-fill me-1"></i>Konfirmasi Password
                                </label>
                                <input type="password" class="form-control"
                                       id="password_confirmation" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="d-flex gap-3 mt-4">
                            <button type="submit" class="btn btn-primary px-4 py-2">
                                <i class="bi bi-check-lg me-1"></i>Simpan User
                            </button>
                            <a href="{{ route('administrator.kelola-user') }}" class="btn btn-outline-secondary px-4 py-2">
                                <i class="bi bi-x-lg me-1"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
