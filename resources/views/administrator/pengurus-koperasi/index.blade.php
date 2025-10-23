@extends('layouts.dashboard')

@section('title', 'Kelola Pengurus Koperasi')
@section('page-title', 'Kelola Pengurus Koperasi')

@php
    $role = 'Administrator';
    $nama = auth()->user()->name;
    $routePrefix = 'administrator';
    $showLaporan = true;
@endphp

@section('main-content')
<style>
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        backdrop-filter: blur(10px);
    }

    .loading-spinner {
        width: 50px;
        height: 50px;
        border: 4px solid rgba(37, 99, 235, 0.1);
        border-top: 4px solid #2563eb;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .loading-text {
        margin-top: 1rem;
        color: #2563eb;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .admin-card {
        background: white;
        border-radius: 24px;
        border: 1px solid rgba(37, 99, 235, 0.08);
        box-shadow: 0 10px 40px rgba(37, 99, 235, 0.08);
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        backdrop-filter: blur(10px);
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

    .admin-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 60px rgba(37, 99, 235, 0.15);
        border-color: rgba(37, 99, 235, 0.2);
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

    .admin-card-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, transparent, rgba(37, 99, 235, 0.02), transparent);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .admin-card-header:hover::before {
        opacity: 1;
    }

    .admin-card-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
        position: relative;
        z-index: 1;
    }

    .admin-card-body {
        padding: 2rem;
        position: relative;
        overflow: hidden;
    }

    .admin-card-body::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, transparent, rgba(37, 99, 235, 0.01), transparent);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .admin-card-body:hover::before {
        opacity: 1;
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

    .admin-table {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        background: white;
        position: relative;
    }

    .admin-table::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, transparent, rgba(37, 99, 235, 0.01), transparent);
        pointer-events: none;
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
        position: relative;
        overflow: hidden;
    }

    .admin-table thead th::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transition: left 0.6s ease;
    }

    .admin-table thead:hover th::before {
        left: 100%;
    }

    .admin-table thead th:hover {
        background: linear-gradient(135deg, #1d4ed8 0%, #3b82f6 100%);
        transform: translateY(-1px);
    }

    .admin-table tbody td {
        padding: 1.25rem 1rem;
        border-bottom: 1px solid rgba(37, 99, 235, 0.08);
        vertical-align: middle;
        background: white;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    .admin-table tbody td::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, transparent, rgba(37, 99, 235, 0.02), transparent);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .admin-table tbody tr:hover td::before {
        opacity: 1;
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
        border-color: rgba(37, 99, 235, 0.1);
    }

    .admin-table tbody tr:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 32px rgba(37, 99, 235, 0.15);
    }

    .admin-table tbody tr:last-child td {
        border-bottom: none;
    }

    .pengurus-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid white;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .pengurus-avatar::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .pengurus-avatar:hover::before {
        opacity: 1;
    }

    .pengurus-avatar:hover {
        transform: scale(1.15) rotate(5deg);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        border-color: #2563eb;
    }

    .pengurus-avatar-placeholder {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2563eb 0%, #60a5fa 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.2rem;
        border: 3px solid white;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .pengurus-avatar-placeholder::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .pengurus-avatar-placeholder:hover::before {
        opacity: 1;
    }

    .pengurus-avatar-placeholder:hover {
        transform: scale(1.15) rotate(-5deg);
        box-shadow: 0 10px 30px rgba(37, 99, 235, 0.3);
        background: linear-gradient(135deg, #60a5fa 0%, #2563eb 100%);
    }

    .badge-jabatan {
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(96, 165, 250, 0.1) 100%);
        color: #2563eb;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.75rem;
        border: 1px solid rgba(37, 99, 235, 0.2);
        white-space: nowrap;
        display: inline-block;
        max-width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 1.2;
        transition: all 0.3s ease;
        position: relative;
        backdrop-filter: blur(10px);
    }

    .badge-jabatan:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 16px rgba(37, 99, 235, 0.2);
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.15) 0%, rgba(96, 165, 250, 0.15) 100%);
    }

    .badge-jabatan::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(37, 99, 235, 0.1), transparent);
        transition: left 0.5s ease;
    }

    .badge-jabatan:hover::before {
        left: 100%;
    }

    .badge-urutan {
        background: linear-gradient(135deg, #64748b 0%, #94a3b8 100%);
        color: white;
        padding: 0.3rem 0.6rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.75rem;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .badge-urutan::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }

    .badge-urutan:hover::before {
        left: 100%;
    }

    .badge-urutan:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 16px rgba(100, 116, 139, 0.3);
    }

    .badge-status-aktif {
        background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        color: white;
        padding: 0.3rem 0.6rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.75rem;
        position: relative;
        overflow: hidden;
        animation: pulse 2s infinite;
    }

    .badge-status-aktif::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }

    .badge-status-aktif:hover::before {
        left: 100%;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .badge-status-nonaktif {
        background: linear-gradient(135deg, #ef4444 0%, #f87171 100%);
        color: white;
        padding: 0.3rem 0.6rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.75rem;
        position: relative;
        overflow: hidden;
    }

    .badge-status-nonaktif::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }

    .badge-status-nonaktif:hover::before {
        left: 100%;
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
        font-size: 0.8rem;
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
        position: relative;
        overflow: hidden;
        backdrop-filter: blur(10px);
        animation: slideInDown 0.6s ease-out;
    }

    .alert-success-admin::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(16, 185, 129, 0.1), transparent);
        transition: left 0.6s ease;
    }

    .alert-success-admin:hover::before {
        left: 100%;
    }

    .alert-danger-admin {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(248, 113, 113, 0.1) 100%);
        border: 1px solid rgba(239, 68, 68, 0.2);
        color: #dc2626;
        border-radius: 16px;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        position: relative;
        overflow: hidden;
        backdrop-filter: blur(10px);
        animation: slideInDown 0.6s ease-out;
    }

    .alert-danger-admin::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(239, 68, 68, 0.1), transparent);
        transition: left 0.6s ease;
    }

    .alert-danger-admin:hover::before {
        left: 100%;
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
        padding: 3rem 2rem;
        color: #64748b;
        position: relative;
        overflow: hidden;
    }

    .empty-state::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, transparent, rgba(37, 99, 235, 0.02), transparent);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .empty-state:hover::before {
        opacity: 1;
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
        position: relative;
        z-index: 1;
    }

    .empty-state p {
        margin-bottom: 1.5rem;
        position: relative;
        z-index: 1;
    }

    @media (max-width: 768px) {
        .admin-card-body {
            padding: 1rem;
        }

        .admin-table {
            font-size: 0.75rem;
            border-radius: 16px;
        }

        .admin-table thead th,
        .admin-table tbody td {
            padding: 0.5rem 0.25rem;
        }

        .pengurus-avatar,
        .pengurus-avatar-placeholder {
            width: 35px;
            height: 35px;
            font-size: 0.8rem;
        }

        .badge-jabatan {
            font-size: 0.65rem;
            padding: 0.25rem 0.5rem;
        }

        .btn-action-group {
            flex-direction: row;
            gap: 0.2rem;
            justify-content: center;
        }

        .btn-action {
            width: 28px;
            height: 28px;
            font-size: 0.7rem;
        }

        .admin-table th:nth-child(2),
        .admin-table td:nth-child(2) {
            width: 8%;
        }

        .admin-table th:nth-child(3),
        .admin-table td:nth-child(3) {
            width: 30%;
        }

        .admin-table th:nth-child(4),
        .admin-table td:nth-child(4) {
            width: 20%;
        }

        .admin-table th:nth-child(5),
        .admin-table td:nth-child(5),
        .admin-table th:nth-child(6),
        .admin-table td:nth-child(6) {
            display: none;
        }

        .admin-table th:nth-child(7),
        .admin-table td:nth-child(7),
        .admin-table th:nth-child(8),
        .admin-table td:nth-child(8) {
            width: 12%;
        }

        .admin-table th:nth-child(9),
        .admin-table td:nth-child(9) {
            width: 18%;
        }

        .admin-card {
            border-radius: 20px;
        }

        .admin-card-header {
            border-radius: 20px 20px 0 0;
        }
    }

    @media (max-width: 480px) {
        .admin-table {
            font-size: 0.7rem;
            border-radius: 12px;
        }

        .admin-table thead th,
        .admin-table tbody td {
            padding: 0.4rem 0.2rem;
        }

        .pengurus-avatar,
        .pengurus-avatar-placeholder {
            width: 30px;
            height: 30px;
            font-size: 0.7rem;
        }

        .badge-jabatan {
            font-size: 0.6rem;
            padding: 0.2rem 0.4rem;
        }

        .btn-action {
            width: 24px;
            height: 24px;
            font-size: 0.6rem;
        }

        .admin-card {
            border-radius: 16px;
        }

        .admin-card-header {
            border-radius: 16px 16px 0 0;
        }
    }
</style>

<div class="admin-card">
    <div class="admin-card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="admin-card-title mb-0">
                <i class="bi bi-people-fill me-2"></i>Daftar Pengurus Koperasi
            </h4>
            <a href="{{ route('administrator.pengurus-koperasi.create') }}" class="btn-primary-admin">
                <i class="bi bi-plus-lg"></i>Tambah Pengurus
            </a>
        </div>
    </div>
    <div class="admin-card-body">
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

        @if($pengurus->count() > 0)
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Foto</th>
                            <th width="25%">Nama</th>
                            <th width="15%">Jabatan</th>
                            <th width="15%">Email</th>
                            <th width="10%">Telepon</th>
                            <th width="8%">Urutan</th>
                            <th width="8%">Status</th>
                            <th width="14%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengurus as $index => $p)
                            <tr>
                                <td class="fw-bold">{{ $index + 1 }}</td>
                                <td>
                                    @if($p->foto && file_exists(public_path('storage/' . $p->foto)))
                                        <img src="http://127.0.0.1:8000/storage/{{ $p->foto }}" alt="{{ $p->nama }}"
                                             class="pengurus-avatar">
                                    @else
                                        <div class="pengurus-avatar-placeholder">
                                            {{ substr($p->nama, 0, 2) }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold text-dark mb-1">{{ $p->nama }}</div>
                                    @if($p->deskripsi)
                                        <small class="text-muted">{{ Str::limit($p->deskripsi, 50) }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge-jabatan">{{ $p->jabatan }}</span>
                                </td>
                                <td>
                                    @if($p->email)
                                        <a href="mailto:{{ $p->email }}" class="text-decoration-none text-primary">
                                            {{ Str::limit($p->email, 20) }}
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($p->telepon)
                                        <a href="tel:{{ $p->telepon }}" class="text-decoration-none text-primary">
                                            {{ $p->telepon }}
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge-urutan">{{ $p->urutan }}</span>
                                </td>
                                <td>
                                    @if($p->aktif)
                                        <span class="badge-status-aktif">Aktif</span>
                                    @else
                                        <span class="badge-status-nonaktif">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-action-group">
                                        <a href="{{ route('administrator.pengurus-koperasi.show', $p->id) }}"
                                           class="btn-action btn-action-view" title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('administrator.pengurus-koperasi.edit', $p->id) }}"
                                           class="btn-action btn-action-edit" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('administrator.pengurus-koperasi.destroy', $p->id) }}"
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-action-delete" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <i class="bi bi-people"></i>
                <h5>Belum ada data pengurus koperasi</h5>
                <p>Mulai dengan menambahkan pengurus pertama untuk mengelola informasi koperasi.</p>
                <a href="{{ route('administrator.pengurus-koperasi.create') }}" class="btn-primary-admin">
                    <i class="bi bi-plus-lg me-2"></i>Tambah Pengurus Pertama
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
