@extends('layouts.dashboard')

@section('title', 'Kelola User')
@section('page-title', 'Kelola User')

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
                <i class="bi bi-people me-2"></i>Kelola User
            </h2>
            <p class="text-muted mb-0">Kelola semua user yang terdaftar di sistem</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('administrator.tambah-user') }}" class="btn btn-primary">
                <i class="bi bi-person-plus me-1"></i>Tambah User
            </a>
            <a href="{{ route('administrator.laporan-user') }}" class="btn btn-info">
                <i class="bi bi-graph-up me-1"></i>Laporan
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- User Table -->
    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-header bg-transparent border-0 p-4">
            <h5 class="fw-bold mb-0" style="color: var(--dark-navy);">
                <i class="bi bi-table me-2"></i>Daftar User
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                        <tr>
                            <th class="border-0 py-3 px-4">ID</th>
                            <th class="border-0 py-3 px-4">Nama</th>
                            <th class="border-0 py-3 px-4">Email</th>
                            <th class="border-0 py-3 px-4">Role</th>
                            <th class="border-0 py-3 px-4">NIP</th>
                            <th class="border-0 py-3 px-4">Daftar</th>
                            <th class="border-0 py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td class="py-3 px-4">{{ $user->id }}</td>
                            <td class="py-3 px-4">
                                <div class="d-flex align-items-center">
                                    <div class="icon-box me-2" style="width: 35px; height: 35px;">
                                        <i class="bi bi-person-fill text-white"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-semibold">{{ $user->name }}</h6>
                                        <small class="text-muted">{{ $user->jabatan ?? '-' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4">{{ $user->email }}</td>
                            <td class="py-3 px-4">
                                @php
                                    $roleColors = [
                                        'peminjam' => 'bg-primary',
                                        'kepala_bps' => 'bg-info',
                                        'bendahara_koperasi' => 'bg-success',
                                        'ketua_koperasi' => 'bg-warning',
                                        'administrator' => 'bg-danger'
                                    ];
                                @endphp
                                <span class="badge {{ $roleColors[$user->role] ?? 'bg-secondary' }} px-3 py-2">
                                    {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                </span>
                            </td>
                            <td class="py-3 px-4">{{ $user->nip ?? '-' }}</td>
                            <td class="py-3 px-4">
                                <small class="text-muted">{{ $user->created_at->format('d M Y') }}</small>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('administrator.detail-user', $user->id) }}"
                                       class="btn btn-sm btn-outline-primary" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('administrator.edit-user', $user->id) }}"
                                       class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @if($user->id !== auth()->id())
                                    <form action="{{ route('administrator.delete-user', $user->id) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Yakin hapus user {{ $user->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                    <h5>Belum ada user</h5>
                                    <p>Mulai dengan menambahkan user baru</p>
                                    <a href="{{ route('administrator.tambah-user') }}" class="btn btn-primary">
                                        <i class="bi bi-person-plus me-1"></i>Tambah User
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($users->hasPages())
        <div class="card-footer bg-transparent border-0 p-4">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
