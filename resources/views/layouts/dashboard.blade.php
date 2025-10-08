@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-md-block sidebar p-0">
                <div class="position-sticky pt-4" style="height: 100vh; display: flex; flex-direction: column;">
                    <div class="text-center text-white px-3 mb-4">
                        <div class="icon-box mx-auto mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-person-circle text-white fs-3"></i>
                        </div>
                        <h6 class="fw-bold mb-1">{{ $nama ?? 'User' }}</h6>
                        <small class="opacity-75">{{ $role ?? 'Dashboard' }}</small>
                    </div>

                    <hr class="opacity-25 mx-3">

                    <ul class="nav flex-column px-3 flex-grow-1">
                        <li class="nav-item mb-2">
                            <a class="nav-link {{ request()->is('*dashboard*') ? 'active' : '' }}" href="{{ route($routePrefix . '.dashboard') }}">
                                <i class="bi bi-speedometer2 me-2"></i> Dashboard
                            </a>
                        </li>
                        @if (isset($showAjukan) && $showAjukan)
                            <li class="nav-item mb-2">
                                <a class="nav-link {{ request()->is('*ajukan*') ? 'active' : '' }}" href="{{ route($routePrefix . '.ajukan') }}">
                                    <i class="bi bi-file-earmark-plus me-2"></i> Ajukan Pinjaman
                                </a>
                            </li>
                        @endif
                        @if (isset($showRiwayat) && $showRiwayat)
                            <li class="nav-item mb-2">
                                <a class="nav-link {{ request()->is('*riwayat*') ? 'active' : '' }}" href="{{ route($routePrefix . '.riwayat') }}">
                                    <i class="bi bi-clock-history me-2"></i> Riwayat Pinjaman
                                </a>
                            </li>
                        @endif
                        @if (isset($showLaporan) && $showLaporan)
                            <li class="nav-item mb-2">
                                <a class="nav-link {{ request()->is('*laporan*') ? 'active' : '' }}" href="{{ route($routePrefix . '.laporan') }}">
                                    <i class="bi bi-file-text me-2"></i> Laporan Pinjaman
                                </a>
                            </li>
                        @endif
                        <li class="nav-item mb-2">
                            <a class="nav-link {{ request()->is('*transparansi*') ? 'active' : '' }}"
                                href="{{ route($routePrefix . '.transparansi') }}">
                                <i class="bi bi-eye me-2"></i> Transparansi Keuangan
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-10 ms-sm-auto px-md-4 bg-cream" style="min-height: 100vh;">
                <div class="d-flex justify-content-between align-items-center py-4 mb-4 border-bottom">
                    <div>
                        <h2 class="fw-bold mb-0">@yield('page-title')</h2>
                        <small class="text-muted">Koperasi Amanah BPS Kota Surabaya</small>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="dropdown">
                            <button class="icon-box dropdown-toggle border-0" style="width: 40px; height: 40px; border-radius: 10px;"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person text-white"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route($routePrefix . '.profile') }}">
                                        <i class="bi bi-person-circle me-2"></i>Profile
                                    </a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item text-danger" href="#" onclick="confirmLogout(event)">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </a></li>
                            </ul>
                        </div>
                    </div>
                </div>

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
        </script>
    @endpush
@endsection

@push('styles')
    <style>
        .sidebar {
            background: var(--primary-darker);
            min-height: 100vh;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
            border-radius: 10px;
            padding: 0.75rem 1rem;
        }

        .sidebar .nav-link:hover {
            background: rgba(49, 162, 168, 0.2);
            color: white;
        }

        .sidebar .nav-link.active {
            background: linear-gradient(135deg, var(--primary-teal) 0%, var(--primary-light) 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(49, 162, 168, 0.3);
        }

        .sidebar .nav-link i {
            width: 20px;
        }

        main {
            background: var(--cream);
        }

        .card-dashboard {
            background: white;
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(11, 73, 98, 0.08);
            transition: all 0.3s ease;
        }

        .card-dashboard:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 30px rgba(49, 162, 168, 0.15);
        }

        .stat-card {
            background: linear-gradient(135deg, var(--primary-teal) 0%, var(--primary-light) 100%);
            border-radius: 16px;
            padding: 1.5rem;
            color: white;
            box-shadow: 0 4px 20px rgba(49, 162, 168, 0.2);
        }

        .stat-card-orange {
            background: linear-gradient(135deg, var(--accent-orange) 0%, #ff7028 100%);
            box-shadow: 0 4px 20px rgba(255, 140, 66, 0.2);
        }
    </style>
@endpush
