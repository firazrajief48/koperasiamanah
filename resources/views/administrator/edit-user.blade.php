@extends('layouts.dashboard')

@section('title', 'Edit User')
@section('page-title', 'Edit User')

@php
    $role = 'Administrator';
    $nama = auth()->user()->name;
    $routePrefix = 'administrator';
    $showLaporan = true;
@endphp

@section('main-content')
<div class="container-fluid">
    <style>
        :root { --primary-blue:#1e40af; --primary-light:#3b82f6; --dark-navy:#0f172a; }
        .page-header-modern{background:linear-gradient(135deg,#1e40af 0%,#3b82f6 50%,#6366f1 100%);border-radius:20px;padding:1.25rem 1.5rem;margin-bottom:1.25rem;color:white;box-shadow:0 10px 30px rgba(30,64,175,.15)}
        .icon-box{width:48px;height:48px;border-radius:12px;background:linear-gradient(135deg,#3b82f6,#1e40af);display:flex;align-items:center;justify-content:center;color:white}
        .card[style*="border-radius"]{border-radius:20px!important}
        .card-header{background:linear-gradient(135deg, rgba(30,64,175,.08), rgba(99,102,241,.08)); border:none}
        .btn-gradient{background:linear-gradient(135deg,#3b82f6,#1e40af);color:#fff;border:none}
        .form-control,.form-select{border-radius:12px;border:2px solid rgba(30,64,175,.12);padding:.75rem 1rem;font-size:.925rem}
        .form-control:focus,.form-select:focus{border-color:#3b82f6;box-shadow:0 0 0 3px rgba(59,130,246,.12)}
        .card-shadow{box-shadow:0 10px 40px rgba(30,64,175,.08)!important}
    </style>
    <!-- Header -->
    <div class="page-header-modern d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <div class="icon-box"><i class="bi bi-pencil"></i></div>
            <div>
                <h2 class="fw-bold mb-0">Edit User</h2>
                <small class="opacity-75">Edit informasi user {{ $user->name }}</small>
            </div>
        </div>

    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 card-shadow" style="border-radius: 20px;">
                <div class="card-header border-0 p-4" style="border-radius:20px 20px 0 0;">
                    <h5 class="fw-bold mb-0" style="color:#1f2937"><i class="bi bi-ui-checks-grid me-2"></i>Form Edit User</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('administrator.update-user', $user->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="name" class="form-label fw-semibold">
                                    <i class="bi bi-person me-1"></i>Nama Lengkap
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold">
                                    <i class="bi bi-envelope me-1"></i>Email
                                </label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email', $user->email) }}" required>
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
                                    <option value="anggota" {{ old('role', $user->role) == 'anggota' ? 'selected' : '' }}>Anggota</option>
                                    <option value="kepala_bps" {{ old('role', $user->role) == 'kepala_bps' ? 'selected' : '' }}>Kepala BPS</option>
                                    <option value="bendahara_koperasi" {{ old('role', $user->role) == 'bendahara_koperasi' ? 'selected' : '' }}>Bendahara Koperasi</option>
                                    <option value="ketua_koperasi" {{ old('role', $user->role) == 'ketua_koperasi' ? 'selected' : '' }}>Ketua Koperasi</option>
                                    <option value="administrator" {{ old('role', $user->role) == 'administrator' ? 'selected' : '' }}>Administrator</option>
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
                                       id="nip" name="nip" value="{{ old('nip', $user->nip) }}">
                                @error('nip')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="golongan" class="form-label fw-semibold">
                                    <i class="bi bi-award me-1"></i>Golongan
                                </label>
                                <input type="text" class="form-control @error('golongan') is-invalid @enderror"
                                       id="golongan" name="golongan" value="{{ old('golongan', $user->golongan) }}">
                                @error('golongan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="jabatan" class="form-label fw-semibold">
                                    <i class="bi bi-briefcase me-1"></i>Jabatan
                                </label>
                                <input type="text" class="form-control @error('jabatan') is-invalid @enderror"
                                       id="jabatan" name="jabatan" value="{{ old('jabatan', $user->jabatan) }}">
                                @error('jabatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="phone" class="form-label fw-semibold">
                                    <i class="bi bi-telephone me-1"></i>No HP
                                </label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                       id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex gap-3 mt-4">
                            <button type="submit" class="btn btn-gradient px-4 py-2">
                                <i class="bi bi-check-lg me-1"></i>Update User
                            </button>
                            <a href="{{ route('administrator.detail-user', $user->id) }}" class="btn btn-outline-info px-4 py-2">
                                <i class="bi bi-eye me-1"></i>Detail
                            </a>
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
