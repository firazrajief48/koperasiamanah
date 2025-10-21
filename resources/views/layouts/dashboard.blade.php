@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-md-block sidebar p-0">
                <div class="position-sticky pt-5" style="height: 100vh; display: flex; flex-direction: column;">
                    <div class="text-center px-4 mb-4">
                        <a href="{{ route($routePrefix . '.profile') }}" class="text-decoration-none" style="display: block;">
                            <div class="profile-avatar mx-auto mb-3" style="cursor: pointer; transition: all 0.3s ease;">
                                <i class="bi bi-person-circle text-white fs-2"></i>
                            </div>
                            <h6 class="fw-bold mb-1 text-dark">{{ $nama ?? 'User' }}</h6>
                            <small class="text-secondary opacity-70">{{ $role ?? 'Dashboard' }}</small>
                        </a>
                    </div>

                    <hr class="opacity-15 mx-3 mb-4">

                    <ul class="nav flex-column px-3 flex-grow-1 gap-2">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('*dashboard*') ? 'active' : '' }}" href="{{ route($routePrefix . '.dashboard') }}">
                                <i class="bi bi-speedometer2 me-3"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        @if (isset($showAjukan) && $showAjukan)
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('*ajukan*') ? 'active' : '' }}" href="{{ route($routePrefix . '.ajukan') }}">
                                    <i class="bi bi-file-earmark-plus me-3"></i>
                                    <span>Ajukan Pinjaman</span>
                                </a>
                            </li>
                        @endif
                        @if (isset($showRiwayat) && $showRiwayat)
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('*riwayat*') ? 'active' : '' }}" href="{{ route($routePrefix . '.riwayat') }}">
                                    <i class="bi bi-clock-history me-3"></i>
                                    <span>Riwayat Pinjaman</span>
                                </a>
                            </li>
                        @endif
                        @if (isset($showLaporan) && $showLaporan)
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('*laporan*') ? 'active' : '' }}" href="{{ route($routePrefix . ($routePrefix === 'administrator' ? '.laporan-user' : '.laporan')) }}">
                                    <i class="bi bi-file-text me-3"></i>
                                    <span>Laporan {{ $routePrefix === 'administrator' ? 'User' : 'Pinjaman' }}</span>
                                </a>
                            </li>
                        @endif
                        @if (isset($routePrefix) && $routePrefix === 'bendahara_koperasi')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('bendahara-koperasi/iuran-pegawai*') ? 'active' : '' }}" href="{{ route('bendahara_koperasi.iuran_pegawai') }}">
                                    <i class="bi bi-wallet2 me-3"></i>
                                    <span>Iuran Pegawai</span>
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('*transparansi*') ? 'active' : '' }}"
                                href="{{ route($routePrefix . '.transparansi') }}">
                                <i class="bi bi-eye me-3"></i>
                                <span>Transparansi Keuangan</span>
                            </a>
                        </li>
                    </ul>

                    <hr class="opacity-15 mx-3 my-4">
                    <div class="px-3 pb-3">
                        <button class="btn btn-logout w-100" onclick="confirmLogout(event)" style="cursor: pointer;">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </button>
                    </div>
                </div>
            </nav>

            <main class="col-md-10 ms-sm-auto px-md-4" style="min-height: 100vh; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
                <div class="d-flex justify-content-between align-items-center py-4 mb-2">
                    <div>
                        <h2 class="fw-bold mb-1 gradient-text-modern" style="font-size: 2rem;">@yield('page-title')</h2>
                        <small class="text-secondary opacity-70">Koperasi Amanah BPS Kota Surabaya</small>
                    </div>
                    <div class="d-flex align-items-center">
                        <!-- Profile button removed - now handled by sidebar profile image -->
                    </div>
                </div>
                <div class="page-separator mt-3 mb-4"></div>

                <div class="pb-5">
                    @yield('main-content')
                </div>
            </main>
        </div>
    </div>

    @push('scripts')
        <script>
            function confirmLogout(event) {
                event.preventDefault();
                if (confirm('Apakah Anda yakin ingin keluar?')) {
                    window.location.href = '/';
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                try {
                    document.querySelectorAll('.modal').forEach(function(modalEl) {
                        if (modalEl.parentElement !== document.body) {
                            document.body.appendChild(modalEl);
                        }
                    });
                } catch (e) {
                    console.error('Error moving modals to body', e);
                }
            });
        </script>
    @endpush
@endsection

@push('styles')
    <style>
        :root {
            --primary-blue: #2563eb;
            --primary-light: #60a5fa;
            --primary-darker: #1e40af;
            --accent-orange: #f97316;
            --accent-yellow: #fbbf24;
            --dark-navy: #0f172a;
            --cream: #fef3c7;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
        }

        * {
            font-family: 'Inter', sans-serif;
        }

        /* SIDEBAR MODERN */
        .sidebar {
            background: #ffffff;
            min-height: 100vh;
            border-right: 1px solid var(--gray-200);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .profile-avatar {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-light) 100%);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 24px rgba(37, 99, 235, 0.2);
            transition: all 0.3s ease;
        }

        .profile-avatar:hover {
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 12px 32px rgba(37, 99, 235, 0.3);
        }

        a:hover .profile-avatar {
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 12px 32px rgba(37, 99, 235, 0.3);
        }

        .sidebar .nav-link {
            color: #4b5563;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 12px;
            padding: 0.875rem 1.25rem;
            font-weight: 500;
            font-size: 0.95rem;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
        }

        .sidebar .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(37, 99, 235, 0.08), transparent);
            transition: left 0.5s ease;
        }

        .sidebar .nav-link:hover::before {
            left: 100%;
        }

        .sidebar .nav-link:hover {
            background: linear-gradient(135deg, #eff6ff 0%, #f0f9ff 100%);
            color: var(--primary-blue);
            transform: translateX(6px);
        }

        .sidebar .nav-link.active {
            background: linear-gradient(135deg, var(--accent-orange) 0%, #fb923c 100%);
            color: white;
            box-shadow: 0 6px 20px rgba(249, 115, 22, 0.3);
            transform: translateX(6px);
        }

        .sidebar .nav-link i {
            width: 20px;
            flex-shrink: 0;
            transition: transform 0.3s ease;
            font-size: 1.1rem;
        }

        .sidebar .nav-link:hover i,
        .sidebar .nav-link.active i {
            transform: scale(1.1);
        }

        .btn-logout {
            background: linear-gradient(135deg, #ef4444 0%, #f87171 100%);
            color: white;
            border: none;
            font-weight: 600;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
        }

        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(239, 68, 68, 0.3);
            background: linear-gradient(135deg, #f87171 0%, #ef4444 100%);
            color: white;
        }

        main {
            position: relative;
            z-index: 1;
        }

        .gradient-text-modern {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--accent-orange) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.5px;
        }

        .profile-button {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-light) 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
            cursor: pointer;
        }

        .profile-button:hover {
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3);
        }

        .modern-dropdown {
            border-radius: 12px;
            border: 1px solid var(--gray-200);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1) !important;
            padding: 0.5rem;
            backdrop-filter: blur(10px);
        }

        .modern-dropdown .dropdown-item {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            transition: all 0.2s ease;
            font-weight: 500;
            color: #374151;
        }

        .modern-dropdown .dropdown-item:hover {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(249, 115, 22, 0.1) 100%);
            color: var(--primary-blue);
            transform: translateX(4px);
        }

        .card-modern {
            background: white;
            border: 1px solid rgba(37, 99, 235, 0.08);
            border-radius: 16px;
            box-shadow: 0 6px 24px rgba(37, 99, 235, 0.06);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .card-modern:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 40px rgba(37, 99, 235, 0.12);
            border-color: rgba(37, 99, 235, 0.15);
        }

        .stat-card {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-light) 100%);
            border-radius: 16px;
            padding: 1.75rem;
            color: white;
            box-shadow: 0 8px 24px rgba(37, 99, 235, 0.25);
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            border-radius: 50%;
        }

        .stat-card:hover {
            transform: translateY(-6px) scale(1.02);
            box-shadow: 0 12px 35px rgba(37, 99, 235, 0.35);
        }

        .stat-card-orange {
            background: linear-gradient(135deg, var(--accent-orange) 0%, #fb923c 100%);
            box-shadow: 0 8px 24px rgba(249, 115, 22, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .stat-card-orange:hover {
            box-shadow: 0 12px 35px rgba(249, 115, 22, 0.35);
        }

        .badge-custom {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
            border: none;
        }

        .badge-primary {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(96, 165, 250, 0.1) 100%);
            color: var(--primary-blue);
        }

        .badge-success {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(52, 211, 153, 0.1) 100%);
            color: #059669;
        }

        .badge-warning {
            background: linear-gradient(135deg, rgba(249, 115, 22, 0.1) 0%, rgba(251, 146, 60, 0.1) 100%);
            color: var(--accent-orange);
        }

        .badge-danger {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(248, 113, 113, 0.1) 100%);
            color: #dc2626;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-light) 100%);
            border: none;
            color: white;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary-blue) 100%);
            color: white;
        }

        .btn-accent {
            background: linear-gradient(135deg, var(--accent-orange) 0%, #fb923c 100%);
            border: none;
            color: white;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.2);
        }

        .btn-accent:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(249, 115, 22, 0.3);
            background: linear-gradient(135deg, #fb923c 0%, var(--accent-orange) 100%);
            color: white;
        }

        .table {
            border-collapse: separate;
            border-spacing: 0;
        }

        .table thead th {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.05) 0%, rgba(249, 115, 22, 0.05) 100%);
            border: 1px solid var(--gray-200);
            font-weight: 600;
            color: var(--primary-blue);
            padding: 1rem;
        }

        .table tbody td {
            border: 1px solid var(--gray-200);
            padding: 1rem;
        }

        .table tbody tr {
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.04) 0%, rgba(249, 115, 22, 0.04) 100%);
            transform: scale(1.002);
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                z-index: 1000;
                width: 280px;
                left: -280px;
                transition: left 0.3s ease;
                height: 100vh;
            }

            .sidebar.show {
                left: 0;
            }
        }

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

        .card-modern,
        .stat-card {
            animation: fadeInUp 0.6s ease-out both;
        }

        /* Page header separator */
        .page-separator {
            height: 3px;
            width: 100%;
            background: linear-gradient(90deg, rgba(0,0,0,0.03), rgba(0,0,0,0.06));
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.4);
        }

        .card-modern:nth-child(1) { animation-delay: 0.1s; }
        .card-modern:nth-child(2) { animation-delay: 0.2s; }
        .card-modern:nth-child(3) { animation-delay: 0.3s; }
        .card-modern:nth-child(4) { animation-delay: 0.4s; }
    </style>
@endpush
