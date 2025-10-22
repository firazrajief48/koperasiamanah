@extends('layouts.dashboard')

@section('title', 'Detail Pengurus Koperasi')
@section('page-title', 'Detail Pengurus Koperasi')

@php
    $role = 'Administrator';
    $nama = auth()->user()->name;
    $routePrefix = 'administrator';
    $showLaporan = true;
@endphp

@section('main-content')
<style>
    .admin-detail-card {
        background: white;
        border-radius: 20px;
        border: 1px solid rgba(37, 99, 235, 0.08);
        box-shadow: 0 8px 32px rgba(37, 99, 235, 0.08);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .admin-detail-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 16px 48px rgba(37, 99, 235, 0.12);
        border-color: rgba(37, 99, 235, 0.15);
    }

    .admin-detail-header {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-bottom: 1px solid rgba(37, 99, 235, 0.1);
        border-radius: 20px 20px 0 0;
        padding: 1.5rem 2rem;
    }

    .admin-detail-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }

    .admin-detail-body {
        padding: 2rem;
    }

    .detail-photo {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid white;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        margin: 0 auto 1.5rem;
        display: block;
        transition: all 0.3s ease;
    }

    .detail-photo:hover {
        transform: scale(1.05);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
    }

    .detail-photo-placeholder {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2563eb 0%, #60a5fa 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 2.5rem;
        border: 4px solid white;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        margin: 0 auto 1.5rem;
        transition: all 0.3s ease;
    }

    .detail-photo-placeholder:hover {
        transform: scale(1.05);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
    }

    .detail-info {
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.02) 0%, rgba(96, 165, 250, 0.02) 100%);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border: 1px solid rgba(37, 99, 235, 0.1);
    }

    .detail-label {
        font-weight: 600;
        color: #374151;
        font-size: 0.9rem;
        margin-bottom: 0.25rem;
    }

    .detail-value {
        color: #0f172a;
        font-size: 1rem;
        margin-bottom: 1rem;
    }

    .detail-value:last-child {
        margin-bottom: 0;
    }

    .badge-jabatan-detail {
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(96, 165, 250, 0.1) 100%);
        color: #2563eb;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9rem;
        border: 1px solid rgba(37, 99, 235, 0.2);
        display: inline-block;
    }

    .badge-status-aktif-detail {
        background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.8rem;
        display: inline-block;
    }

    .badge-status-nonaktif-detail {
        background: linear-gradient(135deg, #ef4444 0%, #f87171 100%);
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.8rem;
        display: inline-block;
    }

    .btn-primary-admin {
        background: linear-gradient(135deg, #2563eb 0%, #60a5fa 100%);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.75rem 2rem;
        border-radius: 12px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 16px rgba(37, 99, 235, 0.3);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary-admin:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(37, 99, 235, 0.4);
        background: linear-gradient(135deg, #60a5fa 0%, #2563eb 100%);
        color: white;
    }

    .btn-secondary-admin {
        background: linear-gradient(135deg, #64748b 0%, #94a3b8 100%);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.75rem 2rem;
        border-radius: 12px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 16px rgba(100, 116, 139, 0.3);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-secondary-admin:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(100, 116, 139, 0.4);
        background: linear-gradient(135deg, #94a3b8 0%, #64748b 100%);
        color: white;
    }

    .btn-warning-admin {
        background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.75rem 2rem;
        border-radius: 12px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 16px rgba(245, 158, 11, 0.3);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-warning-admin:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(245, 158, 11, 0.4);
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        color: white;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid rgba(37, 99, 235, 0.1);
    }

    .contact-info {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.05) 0%, rgba(52, 211, 153, 0.05) 100%);
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid rgba(16, 185, 129, 0.1);
    }

    .contact-item {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
        color: #374151;
    }

    .contact-item:last-child {
        margin-bottom: 0;
    }

    .contact-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        margin-right: 1rem;
        font-size: 1.1rem;
    }

    .contact-text {
        font-weight: 500;
    }

    .contact-link {
        color: #059669;
        text-decoration: none;
        font-weight: 600;
    }

    .contact-link:hover {
        color: #047857;
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .admin-detail-body {
            padding: 1rem;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-primary-admin,
        .btn-secondary-admin,
        .btn-warning-admin {
            width: 100%;
            justify-content: center;
        }

        .detail-photo,
        .detail-photo-placeholder {
            width: 120px;
            height: 120px;
            font-size: 2rem;
        }
    }
</style>

<div class="admin-detail-card">
    <div class="admin-detail-header">
        <h4 class="admin-detail-title mb-0">
            <i class="bi bi-person-circle me-2"></i>Detail Pengurus Koperasi
        </h4>
    </div>
    <div class="admin-detail-body">
        <div class="text-center">
            @if($pengurus->foto)
                <img src="{{ asset('storage/' . $pengurus->foto) }}" alt="{{ $pengurus->nama }}"
                     class="detail-photo">
            @else
                <div class="detail-photo-placeholder">
                    {{ substr($pengurus->nama, 0, 2) }}
                </div>
            @endif

            <h3 class="fw-bold mb-2" style="color: #0f172a;">{{ $pengurus->nama }}</h3>
            <div class="mb-3">
                <span class="badge-jabatan-detail">{{ $pengurus->jabatan }}</span>
            </div>
            <div class="mb-3">
                @if($pengurus->aktif)
                    <span class="badge-status-aktif-detail">Aktif</span>
                @else
                    <span class="badge-status-nonaktif-detail">Tidak Aktif</span>
                @endif
            </div>
        </div>

        <div class="detail-info">
            <div class="detail-label">Deskripsi</div>
            <div class="detail-value">
                @if($pengurus->deskripsi)
                    {{ $pengurus->deskripsi }}
                @else
                    <span class="text-muted">Tidak ada deskripsi</span>
                @endif
            </div>
        </div>

        @if($pengurus->email || $pengurus->telepon)
            <div class="contact-info">
                <h5 class="fw-bold mb-3" style="color: #059669;">
                    <i class="bi bi-telephone-fill me-2"></i>Informasi Kontak
                </h5>

                @if($pengurus->email)
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="bi bi-envelope-fill"></i>
                        </div>
                        <div>
                            <div class="contact-text">Email</div>
                            <a href="mailto:{{ $pengurus->email }}" class="contact-link">{{ $pengurus->email }}</a>
                        </div>
                    </div>
                @endif

                @if($pengurus->telepon)
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="bi bi-telephone-fill"></i>
                        </div>
                        <div>
                            <div class="contact-text">Telepon</div>
                            <a href="tel:{{ $pengurus->telepon }}" class="contact-link">{{ $pengurus->telepon }}</a>
                        </div>
                    </div>
                @endif
            </div>
        @endif

        <div class="detail-info">
            <div class="row">
                <div class="col-md-6">
                    <div class="detail-label">Urutan Tampil</div>
                    <div class="detail-value">{{ $pengurus->urutan }}</div>
                </div>
                <div class="col-md-6">
                    <div class="detail-label">Tanggal Dibuat</div>
                    <div class="detail-value">{{ $pengurus->created_at->format('d M Y, H:i') }}</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="detail-label">Terakhir Diupdate</div>
                    <div class="detail-value">{{ $pengurus->updated_at->format('d M Y, H:i') }}</div>
                </div>
                <div class="col-md-6">
                    <div class="detail-label">Status</div>
                    <div class="detail-value">
                        @if($pengurus->aktif)
                            <span class="badge-status-aktif-detail">Ditampilkan di halaman depan</span>
                        @else
                            <span class="badge-status-nonaktif-detail">Tidak ditampilkan</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="action-buttons">
            <a href="{{ route('administrator.pengurus-koperasi.index') }}" class="btn-secondary-admin">
                <i class="bi bi-arrow-left"></i>Kembali
            </a>
            <a href="{{ route('administrator.pengurus-koperasi.edit', $pengurus->id) }}" class="btn-warning-admin">
                <i class="bi bi-pencil"></i>Edit Data
            </a>
        </div>
    </div>
</div>
@endsection
