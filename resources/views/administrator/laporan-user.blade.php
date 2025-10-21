@extends('layouts.dashboard')

@section('title', 'Laporan User')
@section('page-title', 'Laporan User')

@php
    $role = 'Administrator';
    $nama = auth()->user()->name;
    $routePrefix = 'administrator';
    $showLaporan = true;
@endphp

@section('main-content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: var(--dark-navy);">
                <i class="bi bi-graph-up me-2"></i>Laporan User
            </h2>
            <p class="text-muted mb-0">Statistik dan analisis data user sistem koperasi</p>
        </div>
        <a href="{{ route('administrator.kelola-user') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <!-- Stats Overview -->
    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="icon-box me-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <i class="bi bi-people-fill text-white fs-4"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0" style="color: var(--dark-navy);">{{ $users_by_role->sum('total') }}</h3>
                            <p class="text-muted mb-0">Total User</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="icon-box me-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                            <i class="bi bi-person-check-fill text-white fs-4"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0" style="color: var(--dark-navy);">{{ $users_by_role->where('role', 'peminjam')->first()->total ?? 0 }}</h3>
                            <p class="text-muted mb-0">Anggota</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="icon-box me-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                            <i class="bi bi-person-badge-fill text-white fs-4"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0" style="color: var(--dark-navy);">{{ $users_by_role->whereIn('role', ['kepala_bps', 'bendahara_koperasi', 'ketua_koperasi'])->sum('total') }}</h3>
                            <p class="text-muted mb-0">Admin</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="icon-box me-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                            <i class="bi bi-shield-check text-white fs-4"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0" style="color: var(--dark-navy);">{{ $users_by_role->where('role', 'administrator')->first()->total ?? 0 }}</h3>
                            <p class="text-muted mb-0">Administrator</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Role Distribution -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-header bg-transparent border-0 p-4">
                    <h5 class="fw-bold mb-0" style="color: var(--dark-navy);">
                        <i class="bi bi-pie-chart me-2"></i>Distribusi Role
                    </h5>
                </div>
                <div class="card-body p-4">
                    @foreach($users_by_role as $role)
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            @php
                                $roleColors = [
                                    'peminjam' => 'bg-primary',
                                    'kepala_bps' => 'bg-info',
                                    'bendahara_koperasi' => 'bg-success',
                                    'ketua_koperasi' => 'bg-warning',
                                    'administrator' => 'bg-danger'
                                ];
                            @endphp
                            <span class="badge {{ $roleColors[$role->role] ?? 'bg-secondary' }} me-3 px-3 py-2">
                                {{ ucfirst(str_replace('_', ' ', $role->role)) }}
                            </span>
                        </div>
                        <div class="text-end">
                            <h5 class="fw-bold mb-0">{{ $role->total }}</h5>
                            <small class="text-muted">user</small>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-header bg-transparent border-0 p-4">
                    <h5 class="fw-bold mb-0" style="color: var(--dark-navy);">
                        <i class="bi bi-calendar me-2"></i>Registrasi Bulanan
                    </h5>
                </div>
                <div class="card-body p-4">
                    @if($users_by_month->count() > 0)
                        @foreach($users_by_month as $month)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h6 class="fw-semibold mb-0">
                                    {{ \Carbon\Carbon::create()->month($month->month)->format('F') }} {{ $month->year }}
                                </h6>
                            </div>
                            <div class="text-end">
                                <h5 class="fw-bold mb-0">{{ $month->total }}</h5>
                                <small class="text-muted">user baru</small>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                            <p>Belum ada data registrasi bulanan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Statistics -->
    <div class="row g-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-header bg-transparent border-0 p-4">
                    <h5 class="fw-bold mb-0" style="color: var(--dark-navy);">
                        <i class="bi bi-bar-chart me-2"></i>Statistik Detail
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        @foreach($users_by_role as $role)
                        <div class="col-md-4">
                            <div class="text-center p-4 rounded"
                                 style="background: linear-gradient(135deg,
                                 @if($role->role == 'peminjam') #667eea 0%, #764ba2 100%
                                 @elseif($role->role == 'kepala_bps') #4facfe 0%, #00f2fe 100%
                                 @elseif($role->role == 'bendahara_koperasi') #43e97b 0%, #38f9d7 100%
                                 @elseif($role->role == 'ketua_koperasi') #f093fb 0%, #f5576c 100%
                                 @else #ff6b6b 0%, #ee5a24 100%
                                 @endif); color: white;">
                                <h2 class="fw-bold mb-2">{{ $role->total }}</h2>
                                <h6 class="mb-0">{{ ucfirst(str_replace('_', ' ', $role->role)) }}</h6>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
