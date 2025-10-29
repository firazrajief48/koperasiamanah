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
                        @if (isset($routePrefix) && $routePrefix === 'administrator')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('administrator/pengurus-koperasi*') ? 'active' : '' }}" href="{{ route('administrator.pengurus-koperasi.index') }}">
                                    <i class="bi bi-people-fill me-3"></i>
                                    <span>Kelola Pengurus</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('administrator/kelola-user*') ? 'active' : '' }}" href="{{ route('administrator.kelola-user') }}">
                                    <i class="bi bi-person-gear me-3"></i>
                                    <span>Kelola User</span>
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

                    <div class="px-3 pb-3 mt-auto" style="margin-top: auto !important; margin-bottom: 1rem;">
                        <button class="btn-logout w-100" data-bs-toggle="modal" data-bs-target="#logoutModal">
                            <i class="bi bi-box-arrow-right me-2"></i>
                            Logout
                        </button>
                    </div>
                </div>
            </nav>

            <main class="col-md-10 ms-sm-auto px-md-4" style="min-height: 100vh; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); margin-left: 280px;">
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


    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
            <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);">
                <div class="modal-header" style="background: white; border: none; padding: 1.5rem; border-radius: 16px 16px 0 0;">
                    <div class="d-flex align-items-center gap-2">
                        <div style="width: 52px; height: 52px; background: linear-gradient(135deg, #ef4444 0%, #f87171 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="bi bi-box-arrow-right text-white" style="font-size: 1.375rem;"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold mb-0" id="logoutModalLabel" style="color: #1f2937; font-size: 1.125rem;">Konfirmasi Logout</h5>
                            <small style="color: #9ca3af; font-size: 0.813rem;">Keluar dari sistem</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 2.5rem 2rem; text-align: center; background: white;">
                    <div style="width: 72px; height: 72px; border: 5px solid #fbbf24; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem;">
                        <span style="font-size: 2.75rem; color: #fbbf24; font-weight: 700; line-height: 1;">?</span>
                    </div>
                    <h6 style="color: #1f2937; font-weight: 600; margin-bottom: 0.5rem; font-size: 1.063rem;">Apakah Anda yakin ingin keluar?</h6>
                    <p class="mb-0" style="color: #6b7280; font-size: 0.875rem; line-height: 1.5;">Anda akan keluar dari sistem dan perlu login kembali untuk<br>mengakses dashboard.</p>
                </div>
                <div class="modal-footer" style="border: none; padding: 0 1.5rem 1.5rem; gap: 0.75rem; background: white; border-radius: 0 0 16px 16px; display: flex; justify-content: stretch;">
                    <button type="button" class="btn" data-bs-dismiss="modal" style="flex: 1; background: white; border: 1.5px solid #d1d5db; color: #6b7280; border-radius: 8px; padding: 0.75rem 1rem; font-weight: 500; font-size: 0.938rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem; transition: all 0.2s;">
                        <i class="bi bi-x-circle" style="font-size: 1.125rem;"></i>
                        <span>Batal</span>
                    </button>
                    <button type="button" class="btn" id="confirmLogoutBtn" style="flex: 1; background: linear-gradient(135deg, #ef4444 0%, #f87171 100%); border: none; color: white; border-radius: 8px; padding: 0.75rem 1rem; font-weight: 500; font-size: 0.938rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem; transition: all 0.2s;">
                        <i class="bi bi-box-arrow-right" style="font-size: 1.125rem;"></i>
                        <span>Ya, Logout</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Handle logout confirmation
                const confirmLogoutBtn = document.getElementById('confirmLogoutBtn');
                if (confirmLogoutBtn) {
                    confirmLogoutBtn.addEventListener('click', function() {
                        // Show loading state
                        const originalText = this.innerHTML;
                        this.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Logging out...';
                        this.disabled = true;

                        // Add loading animation
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

                // Move modals to body if needed
                try {
                    document.querySelectorAll('.modal').forEach(function(modalEl) {
                        if (modalEl.parentElement !== document.body) {
                            document.body.appendChild(modalEl);
                        }
                    });
                } catch (e) {
                    console.error('Error moving modals to body', e);
                }

                // Add smooth animations to modal
                const logoutModal = document.getElementById('logoutModal');
                if (logoutModal) {
                    logoutModal.addEventListener('show.bs.modal', function() {
                        // Add entrance animation
                        const modalContent = this.querySelector('.modal-content');
                        modalContent.style.transform = 'scale(0.8)';
                        modalContent.style.opacity = '0';

                        setTimeout(() => {
                            modalContent.style.transition = 'all 0.3s ease';
                            modalContent.style.transform = 'scale(1)';
                            modalContent.style.opacity = '1';
                        }, 10);
                    });

                    logoutModal.addEventListener('hide.bs.modal', function() {
                        // Add exit animation
                        const modalContent = this.querySelector('.modal-content');
                        modalContent.style.transition = 'all 0.2s ease';
                        modalContent.style.transform = 'scale(0.8)';
                        modalContent.style.opacity = '0';
                    });
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
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            z-index: 1000;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: rgba(37, 99, 235, 0.3) transparent;
        }

        /* Collapsed sidebar styles */
        body.sidebar-collapsed .sidebar {
            width: 80px;
        }
        body.sidebar-collapsed .sidebar .text-center h6,
        body.sidebar-collapsed .sidebar .text-center small,
        body.sidebar-collapsed .sidebar hr {
            display: none !important;
        }
        body.sidebar-collapsed .sidebar .nav-link span {
            display: none;
        }
        body.sidebar-collapsed .sidebar .nav-link {
            justify-content: center;
        }
        body.sidebar-collapsed .sidebar .profile-avatar { width: 48px; height: 48px; }
        body.sidebar-collapsed main { margin-left: 80px !important; }
        /* Toggle button placement hint for fixed sidebar width changes */
        @media (min-width: 769px) {
            #sidebarToggleBtn { margin-left: 0.5rem; }
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(37, 99, 235, 0.3);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(37, 99, 235, 0.5);
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
        }

        /* Logout Modal Styles */
        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }

        .modal-content {
            border: none;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .btn-outline-secondary:hover {
            background-color: #f8fafc;
            border-color: #d1d5db;
            color: #374151;
            transform: translateY(-1px);
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        }

        .logout-icon {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(239, 68, 68, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
            }
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

            main {
                margin-left: 0 !important;
            }
            /* On mobile, ignore collapsed class and use drawer behavior */
            body.sidebar-collapsed .sidebar { width: 280px; }
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
