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
<style>
    .admin-card {
        background: white;
        border-radius: 24px;
        border: 1px solid rgba(37, 99, 235, 0.08);
        box-shadow: 0 10px 40px rgba(37, 99, 235, 0.08);
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        backdrop-filter: blur(10px);
        margin-bottom: 2rem;
    }

    .admin-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #2563eb, #60a5fa, #f59e0b, #10b981);
        background-size: 300% 100%;
        animation: gradientShift 3s ease infinite;
    }

    @keyframes gradientShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    .admin-card-header {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-bottom: 1px solid rgba(37, 99, 235, 0.1);
        border-radius: 24px 24px 0 0;
        padding: 1.5rem 2rem;
        position: relative;
        overflow: hidden;
    }

    .admin-card-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }

    .admin-card-body {
        padding: 2rem;
    }

    .search-box-admin {
        max-width: 420px;
    }

    .search-input-pill {
        border-radius: 999px !important;
        border: 2px solid rgba(30, 64, 175, 0.12) !important;
        padding: 0.75rem 1.25rem !important;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05) !important;
        transition: all 0.3s ease !important;
        background: white !important;
    }

    .search-input-pill:focus {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12) !important;
        outline: none !important;
    }

    .btn-primary-admin {
        background: linear-gradient(135deg, #2563eb 0%, #60a5fa 100%);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border-radius: 16px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.3);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        position: relative;
        overflow: hidden;
    }

    .btn-primary-admin::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.6s ease;
    }

    .btn-primary-admin:hover::before {
        left: 100%;
    }

    .btn-primary-admin:hover {
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 12px 32px rgba(37, 99, 235, 0.5);
        background: linear-gradient(135deg, #60a5fa 0%, #2563eb 100%);
        color: white;
    }

    .btn-info-admin {
        background: linear-gradient(135deg, #06b6d4 0%, #67e8f9 100%);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border-radius: 16px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 6px 20px rgba(6, 182, 212, 0.3);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        position: relative;
        overflow: hidden;
    }

    .btn-info-admin::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.6s ease;
    }

    .btn-info-admin:hover::before {
        left: 100%;
    }

    .btn-info-admin:hover {
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 12px 32px rgba(6, 182, 212, 0.5);
        background: linear-gradient(135deg, #67e8f9 0%, #06b6d4 100%);
        color: white;
    }

    .admin-table {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        background: white;
    }

    .admin-table thead th {
        background: linear-gradient(135deg, #2563eb 0%, #60a5fa 100%);
        color: white;
        font-weight: 600;
        padding: 1.25rem 1rem;
        border: none;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-align: left;
        vertical-align: middle;
    }

    .admin-table thead th:last-child {
        text-align: center;
    }

    .admin-table tbody td {
        padding: 1.25rem 1rem;
        border-bottom: 1px solid rgba(37, 99, 235, 0.08);
        vertical-align: middle;
        background: white;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .admin-table tbody tr {
        animation: fadeInUp 0.6s ease-out both;
    }

    .admin-table tbody tr:nth-child(1) { animation-delay: 0.1s; }
    .admin-table tbody tr:nth-child(2) { animation-delay: 0.2s; }
    .admin-table tbody tr:nth-child(3) { animation-delay: 0.3s; }
    .admin-table tbody tr:nth-child(4) { animation-delay: 0.4s; }
    .admin-table tbody tr:nth-child(5) { animation-delay: 0.5s; }
    .admin-table tbody tr:nth-child(6) { animation-delay: 0.6s; }
    .admin-table tbody tr:nth-child(7) { animation-delay: 0.7s; }
    .admin-table tbody tr:nth-child(8) { animation-delay: 0.8s; }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .admin-table tbody tr:hover td {
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.03) 0%, rgba(96, 165, 250, 0.03) 100%);
        transform: scale(1.005);
        box-shadow: 0 4px 20px rgba(37, 99, 235, 0.1);
    }

    .admin-table tbody tr:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 32px rgba(37, 99, 235, 0.15);
    }

    .admin-table tbody tr:last-child td {
        border-bottom: none;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2563eb 0%, #60a5fa 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 0.9rem;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        flex-shrink: 0;
    }

    .user-avatar:hover {
        transform: scale(1.15) rotate(-5deg);
        box-shadow: 0 10px 30px rgba(37, 99, 235, 0.3);
        background: linear-gradient(135deg, #60a5fa 0%, #2563eb 100%);
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .user-details h6 {
        margin: 0;
        font-weight: 600;
        color: #0f172a;
        font-size: 0.95rem;
    }

    .user-details small {
        color: #64748b;
        font-size: 0.8rem;
    }

    .badge-role {
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.75rem;
        border: 1px solid;
        white-space: nowrap;
        display: inline-block;
        transition: all 0.3s ease;
    }

    .badge-role:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
    }

    .badge-role.bg-primary {
        background: linear-gradient(135deg, #2563eb 0%, #60a5fa 100%);
        color: white;
        border-color: rgba(37, 99, 235, 0.3);
    }

    .badge-role.bg-info {
        background: linear-gradient(135deg, #06b6d4 0%, #67e8f9 100%);
        color: white;
        border-color: rgba(6, 182, 212, 0.3);
    }

    .badge-role.bg-success {
        background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        color: white;
        border-color: rgba(16, 185, 129, 0.3);
    }

    .badge-role.bg-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
        color: white;
        border-color: rgba(245, 158, 11, 0.3);
    }

    .badge-role.bg-danger {
        background: linear-gradient(135deg, #ef4444 0%, #f87171 100%);
        color: white;
        border-color: rgba(239, 68, 68, 0.3);
    }

    .btn-action-group {
        display: flex;
        gap: 0.4rem;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-action {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        font-size: 0.85rem;
        text-decoration: none;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .btn-action::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }

    .btn-action:hover::before {
        left: 100%;
    }

    .btn-action-view {
        background: linear-gradient(135deg, #06b6d4 0%, #67e8f9 100%);
        color: white;
    }

    .btn-action-view:hover {
        transform: translateY(-2px) scale(1.15);
        box-shadow: 0 8px 20px rgba(6, 182, 212, 0.5);
        color: white;
    }

    .btn-action-edit {
        background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
        color: white;
    }

    .btn-action-edit:hover {
        transform: translateY(-2px) scale(1.15);
        box-shadow: 0 8px 20px rgba(245, 158, 11, 0.5);
        color: white;
    }

    .btn-action-delete {
        background: linear-gradient(135deg, #ef4444 0%, #f87171 100%);
        color: white;
    }

    .btn-action-delete:hover {
        transform: translateY(-2px) scale(1.15);
        box-shadow: 0 8px 20px rgba(239, 68, 68, 0.5);
        color: white;
    }

    .alert-success-admin {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(52, 211, 153, 0.1) 100%);
        border: 1px solid rgba(16, 185, 129, 0.2);
        color: #059669;
        border-radius: 16px;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        animation: slideInDown 0.6s ease-out;
    }

    .alert-danger-admin {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(248, 113, 113, 0.1) 100%);
        border: 1px solid rgba(239, 68, 68, 0.2);
        color: #dc2626;
        border-radius: 16px;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        animation: slideInDown 0.6s ease-out;
    }

    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #64748b;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        color: #cbd5e1;
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    .empty-state h5 {
        color: #475569;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }

    .empty-state p {
        margin-bottom: 1.5rem;
        color: #64748b;
    }

    @media (max-width: 768px) {
        .admin-card-body {
            padding: 1rem;
        }

        .admin-card-header {
            padding: 1rem;
        }

        .admin-table {
            font-size: 0.85rem;
        }

        .admin-table thead th,
        .admin-table tbody td {
            padding: 0.75rem 0.5rem;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            font-size: 0.8rem;
        }

        .btn-primary-admin,
        .btn-info-admin {
            padding: 0.6rem 1rem;
            font-size: 0.85rem;
        }

        .btn-action-group {
            gap: 0.3rem;
        }

        .btn-action {
            width: 28px;
            height: 28px;
            font-size: 0.75rem;
        }
    }
</style>

<div class="container-fluid">
    <div class="admin-card">
        <div class="admin-card-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <h4 class="admin-card-title mb-0">
                    <i class="bi bi-people me-2"></i>Daftar User
                </h4>
                <div class="d-flex gap-2">
                    <a href="{{ route('administrator.tambah-user') }}" class="btn-primary-admin">
                        <i class="bi bi-person-plus"></i>Tambah User
                    </a>
                </div>
            </div>
        </div>
        <div class="admin-card-body">
            <div class="mb-3">
                <div class="input-group search-box-admin">
                    <input type="text" id="searchUser" class="form-control search-input-pill" placeholder="Cari nama, email, role, NIP" aria-label="Cari">
                </div>
            </div>
            @if(session('success'))
                <div class="alert-success-admin">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert-danger-admin">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                </div>
            @endif

            @if($users->count() > 0)
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th style="width: 5%;">ID</th>
                                <th style="width: 25%;">Nama</th>
                                <th style="width: 20%;">Email</th>
                                <th style="width: 15%;">Role</th>
                                <th style="width: 12%;">NIP</th>
                                <th style="width: 10%;">Daftar</th>
                                <th style="width: 13%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td class="fw-bold text-primary">{{ $user->id }}</td>
                                <td>
                                    <div class="user-info">
                                        <div class="user-avatar">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                        <div class="user-details">
                                            <h6>{{ $user->name }}</h6>
                                            @if($user->jabatan)
                                                <small>{{ $user->jabatan }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @php
                                        $roleColors = [
                                            'anggota' => 'bg-primary',
                                            'kepala_bps' => 'bg-info',
                                            'bendahara_koperasi' => 'bg-success',
                                            'ketua_koperasi' => 'bg-warning',
                                            'administrator' => 'bg-danger'
                                        ];
                                    @endphp
                                    <span class="badge-role {{ $roleColors[$user->role] ?? 'bg-secondary' }}">
                                        {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                    </span>
                                </td>
                                <td>{{ $user->nip ?? '-' }}</td>
                                <td>
                                    <small class="text-muted">{{ $user->created_at->format('d M Y') }}</small>
                                </td>
                                <td>
                                    <div class="btn-action-group">
                                        <a href="{{ route('administrator.detail-user', $user->id) }}"
                                           class="btn-action btn-action-view" title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('administrator.edit-user', $user->id) }}"
                                           class="btn-action btn-action-edit" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        @if($user->id !== auth()->id())
                                        <form id="delete-form-{{ $user->id }}" action="{{ route('administrator.delete-user', $user->id) }}"
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn-action btn-action-delete btn-open-delete"
                                                    data-form="delete-form-{{ $user->id }}"
                                                    data-name="{{ $user->name }}" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($users->hasPages())
                <div class="mt-4">
                    {{ $users->links() }}
                </div>
                @endif
            @else
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <h5>Belum ada user</h5>
                    <p>Mulai dengan menambahkan user baru untuk mengelola sistem.</p>
                    <a href="{{ route('administrator.tambah-user') }}" class="btn-primary-admin">
                        <i class="bi bi-person-plus me-2"></i>Tambah User Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let targetFormId = null;
    const modalEl = document.getElementById('confirmDeleteModal');
    const nameEl = document.getElementById('confirmDeleteName');
    const confirmBtn = document.getElementById('confirmDeleteBtn');
    const bsModal = new bootstrap.Modal(modalEl);

    document.querySelectorAll('.btn-open-delete').forEach(btn => {
        btn.addEventListener('click', function() {
            targetFormId = this.getAttribute('data-form');
            const name = this.getAttribute('data-name');
            nameEl.textContent = name || 'user ini';
            bsModal.show();
        });
    });

    confirmBtn.addEventListener('click', function() {
        if (targetFormId) {
            const form = document.getElementById(targetFormId);
            if (form) form.submit();
        }
    });

    // Searching: filter baris berdasarkan nama, email, role, dan NIP
    const searchInput = document.getElementById('searchUser');
    if (searchInput) {
        const tableBody = document.querySelector('.admin-table tbody');
        const rows = tableBody ? Array.from(tableBody.querySelectorAll('tr')) : [];

        searchInput.addEventListener('keyup', function() {
            const term = this.value.toLowerCase();
            rows.forEach(row => {
                const nama = row.children[1]?.textContent?.toLowerCase() || '';
                const email = row.children[2]?.textContent?.toLowerCase() || '';
                const role = row.children[3]?.textContent?.toLowerCase() || '';
                const nip = row.children[4]?.textContent?.toLowerCase() || '';

                if (nama.includes(term) || email.includes(term) || role.includes(term) || nip.includes(term)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
});
</script>

<!-- Modal Konfirmasi Hapus (Website Style) -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius:16px; border:none; overflow:hidden;">
      <div class="modal-header" style="background: linear-gradient(135deg, #ef4444, #dc2626); color:white; border:none;">
        <h5 class="modal-title"><i class="bi bi-trash me-2"></i>Konfirmasi Penghapusan</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="padding:1.25rem 1.5rem;">
        <p class="mb-0" style="color:#374151;">Anda yakin ingin menghapus <strong id="confirmDeleteName">user ini</strong>? Tindakan ini tidak dapat dibatalkan.</p>
      </div>
      <div class="modal-footer" style="border:none; padding:0 1.5rem 1.25rem;">
        <button type="button" class="btn" data-bs-dismiss="modal" style="background:white;border:1px solid #d1d5db;color:#475569;border-radius:10px;">Batal</button>
        <button type="button" class="btn" id="confirmDeleteBtn" style="background:linear-gradient(135deg,#ef4444,#dc2626); color:white; border:none; border-radius:10px;">Ya, Hapus</button>
      </div>
    </div>
  </div>
</div>
@endpush
