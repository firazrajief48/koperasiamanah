@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar Overlay for Mobile -->
            <div class="sidebar-overlay" id="sidebarOverlay"></div>

            <nav class="col-md-2 d-md-block sidebar p-0" id="sidebar">
                <div class="sidebar-inner">
                    <!-- Toggle Button inside Sidebar -->
                    <div class="sidebar-toggle-inner">
                        <button class="btn-toggle-sidebar" id="sidebarToggleBtnInner" title="Toggle Sidebar">
                            <i class="bi bi-list"></i>
                        </button>
                    </div>

                    <div class="sidebar-profile">
                        <a href="{{ route($routePrefix . '.profile') }}" class="sidebar-profile-link">
                            <div class="profile-avatar">
                                <i class="bi bi-person-circle"></i>
                            </div>
                            <h6 class="sidebar-name sidebar-text">{{ $nama ?? 'User' }}</h6>
                            <small class="sidebar-role sidebar-text">{{ $role ?? 'Dashboard' }}</small>
                        </a>
                    </div>

                    <hr class="sidebar-divider">

                    <ul class="nav flex-column sidebar-nav flex-grow-1">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('*dashboard*') ? 'active' : '' }}" href="{{ route($routePrefix . '.dashboard') }}" data-tooltip="Dashboard">
                                <i class="bi bi-speedometer2"></i>
                                <span class="sidebar-text">Dashboard</span>
                            </a>
                        </li>
                        @if (isset($showAjukan) && $showAjukan)
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('*ajukan*') ? 'active' : '' }}" href="{{ route($routePrefix . '.ajukan') }}" data-tooltip="Ajukan Pinjaman">
                                    <i class="bi bi-file-earmark-plus"></i>
                                    <span class="sidebar-text">Ajukan Pinjaman</span>
                                </a>
                            </li>
                        @endif
                        @if (isset($showRiwayat) && $showRiwayat)
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('*riwayat*') ? 'active' : '' }}" href="{{ route($routePrefix . '.riwayat') }}" data-tooltip="Riwayat Pinjaman">
                                    <i class="bi bi-clock-history"></i>
                                    <span class="sidebar-text">Riwayat Pinjaman</span>
                                </a>
                            </li>
                        @endif
                        @if (isset($showLaporan) && $showLaporan)
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs($routePrefix . '.laporan') && !request()->routeIs($routePrefix . '.laporan_keuangan') ? 'active' : '' }}" href="{{ route($routePrefix . ($routePrefix === 'administrator' ? '.laporan-user' : '.laporan')) }}" data-tooltip="Laporan {{ $routePrefix === 'administrator' ? 'User' : 'Pinjaman' }}">
                                    <i class="bi bi-file-text"></i>
                                    <span class="sidebar-text">Laporan {{ $routePrefix === 'administrator' ? 'User' : 'Pinjaman' }}</span>
                                </a>
                            </li>
                        @endif
                        @if (isset($routePrefix) && $routePrefix === 'administrator')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('administrator/pengurus-koperasi*') ? 'active' : '' }}" href="{{ route('administrator.pengurus-koperasi.index') }}" data-tooltip="Kelola Pengurus">
                                    <i class="bi bi-people-fill"></i>
                                    <span class="sidebar-text">Kelola Pengurus</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('administrator/kelola-user*') ? 'active' : '' }}" href="{{ route('administrator.kelola-user') }}" data-tooltip="Kelola User">
                                    <i class="bi bi-person-gear"></i>
                                    <span class="sidebar-text">Kelola User</span>
                                </a>
                            </li>
                        @endif
                        @if (isset($routePrefix) && $routePrefix === 'bendahara_koperasi')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('bendahara-koperasi/iuran-pegawai*') ? 'active' : '' }}" href="{{ route('bendahara_koperasi.iuran_pegawai') }}" data-tooltip="Iuran Pegawai">
                                    <i class="bi bi-wallet2"></i>
                                    <span class="sidebar-text">Iuran Pegawai</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('bendahara-koperasi/laporan-keuangan*') ? 'active' : '' }}" href="{{ route('bendahara_koperasi.laporan_keuangan') }}" data-tooltip="Laporan Keuangan">
                                    <i class="bi bi-graph-up-arrow"></i>
                                    <span class="sidebar-text">Laporan Keuangan</span>
                                </a>
                            </li>
                        @endif
                        @if (!isset($routePrefix) || $routePrefix !== 'administrator')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('*transparansi*') ? 'active' : '' }}"
                                    href="{{ route($routePrefix . '.transparansi') }}" data-tooltip="Transparansi Keuangan">
                                    <i class="bi bi-eye"></i>
                                    <span class="sidebar-text">Transparansi Keuangan</span>
                                </a>
                            </li>
                        @endif
                    </ul>

                    <div class="sidebar-footer">
                        <button class="btn-logout" data-bs-toggle="modal" data-bs-target="#logoutModal" data-tooltip="Logout">
                            <i class="bi bi-box-arrow-right"></i>
                            <span class="sidebar-text">Logout</span>
                        </button>
                    </div>
                </div>
            </nav>

            <main class="main-content">
                <div class="main-header">
                    <div class="main-header-left">
                        <!-- Mobile Toggle Button -->
                        <button class="btn-toggle-sidebar d-md-none" id="sidebarToggleBtnMobile" title="Toggle Menu">
                            <i class="bi bi-list"></i>
                        </button>
                        <div class="main-header-content">
                            <h1 class="page-title">@yield('page-title')</h1>
                            <p class="page-subtitle">Koperasi Amanah BPS Kota Surabaya</p>
                        </div>
                    </div>
                </div>
                <div class="page-separator"></div>

                <div class="main-content-wrapper">
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
                // Sidebar Toggle Functionality
                const sidebar = document.getElementById('sidebar');
                const sidebarOverlay = document.getElementById('sidebarOverlay');
                const toggleBtnInner = document.getElementById('sidebarToggleBtnInner');
                const toggleBtnMobile = document.getElementById('sidebarToggleBtnMobile');
                const mainContent = document.querySelector('.main-content');
                
                // Check localStorage for saved sidebar state
                const savedState = localStorage.getItem('sidebarCollapsed');
                const isMobile = window.innerWidth < 768;
                
                // Initialize sidebar state
                if (!isMobile && savedState === 'true') {
                    document.body.classList.add('sidebar-collapsed');
                }

                function toggleSidebar() {
                    const isMobile = window.innerWidth < 768;
                    
                    if (isMobile) {
                        // Mobile: toggle drawer
                        sidebar.classList.toggle('show');
                        sidebarOverlay.classList.toggle('active');
                        document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
                    } else {
                        // Desktop: toggle collapsed
                        document.body.classList.toggle('sidebar-collapsed');
                        const isCollapsed = document.body.classList.contains('sidebar-collapsed');
                        localStorage.setItem('sidebarCollapsed', isCollapsed);
                    }
                }

                // Event listeners for toggle buttons
                if (toggleBtnInner) {
                    toggleBtnInner.addEventListener('click', toggleSidebar);
                }
                
                if (toggleBtnMobile) {
                    toggleBtnMobile.addEventListener('click', toggleSidebar);
                }

                // Close sidebar on overlay click (mobile)
                if (sidebarOverlay) {
                    sidebarOverlay.addEventListener('click', function() {
                        sidebar.classList.remove('show');
                        sidebarOverlay.classList.remove('active');
                        document.body.style.overflow = '';
                    });
                }

                // Close sidebar on window resize if switching from mobile to desktop
                let resizeTimer;
                window.addEventListener('resize', function() {
                    clearTimeout(resizeTimer);
                    resizeTimer = setTimeout(function() {
                        const isMobile = window.innerWidth < 768;
                        
                        if (!isMobile) {
                            // Desktop: remove mobile classes
                            sidebar.classList.remove('show');
                            sidebarOverlay.classList.remove('active');
                            document.body.style.overflow = '';
                        } else {
                            // Mobile: remove collapsed class
                            document.body.classList.remove('sidebar-collapsed');
                        }
                    }, 250);
                });

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
            box-shadow: 2px 0 12px rgba(0, 0, 0, 0.08);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            z-index: 1000;
            overflow-y: auto;
            overflow-x: hidden;
            scrollbar-width: thin;
            scrollbar-color: rgba(37, 99, 235, 0.3) transparent;
        }

        .sidebar-inner {
            display: flex;
            flex-direction: column;
            height: 100vh;
            padding: 1.5rem 0;
            position: relative;
        }

        /* Sidebar Overlay for Mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.active {
            display: block;
            opacity: 1;
        }

        /* Toggle Button Styles */
        .btn-toggle-sidebar {
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
            border: none;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.25);
            flex-shrink: 0;
        }

        .btn-toggle-sidebar:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 16px rgba(16, 185, 129, 0.35);
            background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
        }

        .btn-toggle-sidebar:active {
            transform: scale(0.95);
        }

        .btn-toggle-sidebar i {
            font-size: 1.25rem;
            transition: transform 0.3s ease;
        }

        /* Collapsed sidebar styles */
        body.sidebar-collapsed .sidebar {
            width: 80px;
        }

        body.sidebar-collapsed .sidebar .sidebar-text,
        body.sidebar-collapsed .sidebar .sidebar-divider,
        body.sidebar-collapsed .sidebar .sidebar-name,
        body.sidebar-collapsed .sidebar .sidebar-role {
            opacity: 0;
            width: 0;
            height: 0;
            overflow: hidden;
            margin: 0;
            padding: 0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: none;
        }

        body.sidebar-collapsed .sidebar .nav-link span.sidebar-text {
            display: none;
        }

        body.sidebar-collapsed .sidebar .nav-link {
            justify-content: center;
            padding: 0.875rem;
            margin: 0 0.5rem 0.5rem;
            width: calc(100% - 1rem);
            position: relative;
            transform: none;
        }

        body.sidebar-collapsed .sidebar .nav-link i {
            margin: 0 !important;
            width: auto;
        }

        body.sidebar-collapsed .sidebar .profile-avatar { 
            width: 48px; 
            height: 48px;
            margin: 0 auto 0.75rem;
        }

        body.sidebar-collapsed .sidebar .sidebar-profile {
            padding: 0;
            margin-top: 5rem;
            margin-bottom: 1.5rem;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }

        body.sidebar-collapsed .sidebar .sidebar-profile-link {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }

        body.sidebar-collapsed .sidebar .sidebar-toggle-inner {
            top: 1rem;
            left: 50%;
            transform: translateX(-50%) !important;
            right: auto;
        }
        
        body.sidebar-collapsed .sidebar .btn-toggle-sidebar {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            margin: 0 auto;
        }
        
        body.sidebar-collapsed .sidebar .btn-toggle-sidebar i {
            font-size: 1.25rem;
        }

        /* Hamburger icon doesn't need rotation */

        body.sidebar-collapsed .sidebar .sidebar-nav {
            padding: 0 0.5rem;
        }

        body.sidebar-collapsed .sidebar .sidebar-footer {
            padding: 1rem 0.75rem;
        }

        body.sidebar-collapsed .sidebar .btn-logout {
            padding: 0.875rem;
            justify-content: center;
        }

        body.sidebar-collapsed .sidebar .btn-logout .sidebar-text {
            display: none;
        }

        /* Tooltip for collapsed sidebar */
        body.sidebar-collapsed .sidebar .nav-link::after,
        body.sidebar-collapsed .sidebar .btn-logout::after {
            content: attr(data-tooltip);
            position: absolute;
            left: calc(100% + 12px);
            top: 50%;
            transform: translateY(-50%);
            background: #1f2937;
            color: white;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            font-size: 0.813rem;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s ease;
            z-index: 1001;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        body.sidebar-collapsed .sidebar .nav-link::before,
        body.sidebar-collapsed .sidebar .btn-logout::before {
            content: '';
            position: absolute;
            left: calc(100% + 8px);
            top: 50%;
            transform: translateY(-50%);
            border: 6px solid transparent;
            border-right-color: #1f2937;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s ease;
            z-index: 1002;
        }

        body.sidebar-collapsed .sidebar .nav-link:hover::after,
        body.sidebar-collapsed .sidebar .nav-link:hover::before,
        body.sidebar-collapsed .sidebar .btn-logout:hover::after,
        body.sidebar-collapsed .sidebar .btn-logout:hover::before {
            opacity: 1;
        }

        body.sidebar-collapsed .sidebar .btn-logout {
            position: relative;
        }

        /* Toggle button inside sidebar */
        .sidebar-toggle-inner {
            position: absolute;
            top: 1rem;
            right: 0.75rem;
            z-index: 10;
        }

        /* Sidebar Profile Section */
        .sidebar-profile {
            padding: 0 1rem 1.5rem;
            text-align: center;
            margin-top: 3rem;
        }

        .sidebar-profile-link {
            display: block;
            text-decoration: none;
            transition: transform 0.2s ease;
        }

        .sidebar-profile-link:hover {
            transform: translateY(-2px);
        }

        .sidebar-name {
            font-weight: 600;
            font-size: 0.95rem;
            color: #1f2937;
            margin: 0.75rem 0 0.25rem;
            line-height: 1.4;
            transition: all 0.3s ease;
        }

        .sidebar-role {
            font-size: 0.813rem;
            color: #6b7280;
            transition: all 0.3s ease;
        }

        .sidebar-divider {
            margin: 0 1rem 1.25rem;
            border: none;
            border-top: 1px solid var(--gray-200);
            opacity: 0.6;
            transition: all 0.3s ease;
        }

        /* Sidebar Navigation */
        .sidebar-nav {
            padding: 0 1rem;
            margin: 0;
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            list-style: none;
            width: 100%;
            box-sizing: border-box;
        }

        .sidebar-nav .nav-item {
            margin: 0;
            padding: 0;
            width: 100%;
            display: block;
        }

        .sidebar-nav .nav-item:not(:last-child) {
            margin-bottom: 0.5rem;
        }

        /* Sidebar Footer */
        .sidebar-footer {
            padding: 1.25rem 1rem 1rem;
            margin-top: auto;
            border-top: 1px solid var(--gray-200);
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
            width: 72px;
            height: 72px;
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-light) 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 16px rgba(37, 99, 235, 0.25);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin: 0 auto;
        }

        .profile-avatar i {
            font-size: 2rem;
            color: white;
        }

        .sidebar-profile-link:hover .profile-avatar {
            box-shadow: 0 8px 24px rgba(37, 99, 235, 0.35);
        }

        .sidebar .nav-link {
            color: #4b5563;
            transition: background-color 0.2s ease, color 0.2s ease;
            border-radius: 12px;
            padding: 0.875rem 1rem;
            font-weight: 500;
            font-size: 0.938rem;
            position: relative;
            overflow: visible;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 0;
            width: 100%;
            box-sizing: border-box;
            text-decoration: none;
        }

        /* Removed shimmer effect to prevent animation */

        .sidebar .nav-link:hover {
            background: linear-gradient(135deg, #eff6ff 0%, #f0f9ff 100%);
            color: var(--primary-blue);
        }

        .sidebar .nav-link.active {
            background: linear-gradient(135deg, var(--accent-orange) 0%, #fb923c 100%);
            color: white;
            box-shadow: 0 4px 16px rgba(249, 115, 22, 0.25);
        }

        .sidebar .nav-link.active::before {
            display: none;
        }

        .sidebar .nav-link i {
            width: 22px;
            min-width: 22px;
            flex-shrink: 0;
            font-size: 1.125rem;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar .nav-link .sidebar-text {
            transition: opacity 0.3s ease, width 0.3s ease;
            white-space: nowrap;
            overflow: hidden;
            flex: 1;
        }

        .btn-logout {
            background: linear-gradient(135deg, #ef4444 0%, #f87171 100%);
            color: white;
            border: none;
            font-weight: 600;
            border-radius: 12px;
            padding: 0.875rem 1.25rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.25);
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-size: 0.938rem;
        }

        .btn-logout:hover {
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.35);
            background: linear-gradient(135deg, #f87171 0%, #ef4444 100%);
            color: white;
        }

        .btn-logout i {
            font-size: 1.125rem;
        }

        /* Main Content */
        .main-content {
            position: relative;
            z-index: 1;
            margin-left: 280px;
            min-height: 100vh;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 2rem 2.5rem 4rem;
            width: calc(100% - 280px);
            box-sizing: border-box;
            overflow-x: hidden;
        }

        .main-content-wrapper {
            padding-bottom: 4rem;
            min-height: calc(100vh - 200px);
        }

        /* Desktop: adjust main content margin based on sidebar state */
        @media (min-width: 992px) {
            .main-content {
                margin-left: 280px !important;
                width: calc(100% - 280px) !important;
            }

            body.sidebar-collapsed .main-content {
                margin-left: 80px !important;
                width: calc(100% - 80px) !important;
            }
        }

        /* Main Header */
        .main-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-top: 0.5rem;
        }

        .main-header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .main-header-content {
            flex: 1;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            margin: 0 0 0.5rem;
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--accent-orange) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.5px;
            line-height: 1.2;
        }

        .page-subtitle {
            font-size: 0.938rem;
            color: #6b7280;
            margin: 0;
            font-weight: 400;
        }

        .page-separator {
            height: 2px;
            width: 100%;
            background: linear-gradient(90deg, transparent, rgba(0, 0, 0, 0.05), transparent);
            margin: 0 0 2rem;
            border: none;
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

        /* === GLOBAL THEME UI - Konsisten untuk semua role === */

        /* Page Header Modern (untuk semua halaman) */
        .page-header-modern {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #6366f1 100%);
            border-radius: 20px;
            padding: 1.25rem 1.5rem;
            margin-bottom: 1.5rem;
            color: white;
            box-shadow: 0 10px 30px rgba(30, 64, 175, 0.15);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-header-modern .icon-box {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .page-header-modern h2 {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
            color: white;
        }

        .page-header-modern small {
            opacity: 0.9;
            font-size: 0.875rem;
        }

        /* Card Modern Konsisten */
        .card-modern, .card[style*="border-radius"] {
            border-radius: 20px !important;
            border: none !important;
            box-shadow: 0 10px 40px rgba(30, 64, 175, 0.08) !important;
        }

        .card-header-modern, .card-header {
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.08) 0%, rgba(99, 102, 241, 0.08) 100%) !important;
            border: none !important;
            border-radius: 20px 20px 0 0 !important;
            padding: 1.5rem 2rem;
        }

        .card-header-modern h5, .card-header h5 {
            color: #1f2937;
            font-weight: 700;
            margin: 0;
        }

        /* Form Controls Konsisten */
        .form-control, .form-select {
            border-radius: 12px !important;
            border: 2px solid rgba(30, 64, 175, 0.12) !important;
            padding: 0.75rem 1rem !important;
            font-size: 0.925rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12) !important;
            outline: none;
        }

        /* Button Konsisten */
        .btn-gradient, .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%) !important;
            color: white !important;
            border: none !important;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .btn-gradient:hover, .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%) !important;
            color: white !important;
        }

        .btn-outline-info {
            border: 2px solid #06b6d4 !important;
            color: #06b6d4 !important;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-info:hover {
            background: #06b6d4 !important;
            color: white !important;
            transform: translateY(-2px);
        }

        .btn-outline-secondary {
            border: 2px solid #d1d5db !important;
            color: #6b7280 !important;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-secondary:hover {
            background: #f8fafc !important;
            border-color: #cbd5e1 !important;
            transform: translateY(-2px);
        }

        /* Badge Konsisten */
        .badge {
            border-radius: 999px !important;
            font-weight: 600;
            padding: 0.5rem 1rem;
        }

        /* Table Konsisten */
        .table {
            border-radius: 16px;
            overflow: hidden;
        }

        .table thead {
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.08), rgba(99, 102, 241, 0.08));
        }

        .table thead th {
            border: none;
            color: #1f2937;
            font-weight: 700;
            padding: 1rem;
        }

        .table tbody tr {
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: rgba(59, 130, 246, 0.05);
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

        /* Responsive Design */
        @media (max-width: 991.98px) {
            .main-content {
                margin-left: 0 !important;
                width: 100% !important;
                padding: 1.5rem 1.5rem 3rem !important;
            }
            
            .main-content-wrapper {
                padding-bottom: 3rem;
            }

            .page-title {
                font-size: 1.75rem !important;
            }

            .main-header {
                margin-bottom: 1.5rem;
            }

            .sidebar {
                z-index: 1000;
            }

            /* Disable tooltips on mobile */
            body.sidebar-collapsed .sidebar .nav-link::after,
            body.sidebar-collapsed .sidebar .nav-link::before,
            body.sidebar-collapsed .sidebar .btn-logout::after,
            body.sidebar-collapsed .sidebar .btn-logout::before {
                display: none;
            }
        }

        @media (max-width: 767.98px) {
            .sidebar {
                position: fixed;
                z-index: 1000;
                width: 280px;
                left: -280px;
                transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                height: 100vh;
            }

            .sidebar.show {
                left: 0;
            }

            .main-content {
                margin-left: 0 !important;
                width: 100% !important;
                padding: 1rem 1rem 3rem !important;
                overflow-x: hidden;
            }
            
            .main-content-wrapper {
                padding-bottom: 2rem;
            }

            /* On mobile, ignore collapsed class and use drawer behavior */
            body.sidebar-collapsed .sidebar { 
                width: 280px; 
                left: -280px;
            }

            body.sidebar-collapsed .sidebar.show {
                left: 0;
            }

            .sidebar-toggle-inner {
                display: none !important;
            }

            .btn-toggle-sidebar {
                width: 42px;
                height: 42px;
            }

            .page-title {
                font-size: 1.5rem !important;
                word-wrap: break-word;
            }

            .page-subtitle {
                font-size: 0.875rem !important;
            }

            .main-header {
                margin-bottom: 1.25rem;
                padding-top: 0.25rem;
            }

            .main-header-left {
                gap: 0.75rem;
                flex-wrap: wrap;
            }

            .page-separator {
                margin-bottom: 1.5rem;
            }

            /* Ensure no content overflow */
            .main-content > * {
                max-width: 100%;
                box-sizing: border-box;
            }
        }

        @media (max-width: 575.98px) {
            .main-content {
                padding: 0.75rem !important;
            }

            .page-title {
                font-size: 1.25rem !important;
            }

            .page-subtitle {
                font-size: 0.813rem !important;
            }

            .main-header {
                margin-bottom: 1rem;
            }

            .sidebar-profile {
                padding: 0 1.25rem 1.25rem;
                margin-top: 2.5rem;
            }

            .profile-avatar {
                width: 64px;
                height: 64px;
            }

            .profile-avatar i {
                font-size: 1.75rem;
            }

            .sidebar-nav {
                padding: 0 0.75rem;
            }

            .sidebar .nav-link {
                padding: 0.75rem 0.875rem;
                font-size: 0.875rem;
            }
        }

        /* Tablet adjustments */
        @media (min-width: 768px) and (max-width: 991.98px) {
            .sidebar {
                width: 240px;
            }

            .main-content {
                margin-left: 240px !important;
            }

            body.sidebar-collapsed .sidebar {
                width: 80px;
            }

            body.sidebar-collapsed .main-content {
                margin-left: 80px !important;
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
