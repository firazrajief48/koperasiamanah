@extends('layouts.app')

@section('title', 'Koperasi Amanah BPS Kota Surabaya - Beranda')

@section('content')
    <style>
        :root {
            --primary-blue: #1e40af;
            --primary-light: #3b82f6;
            --accent-orange: #f97316;
            --accent-yellow: #fbbf24;
            --dark-navy: #0f172a;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            overflow-x: hidden;
        }

        .table-responsive::-webkit-scrollbar {
            height: 8px;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background: linear-gradient(90deg, var(--primary-blue), var(--primary-light));
            border-radius: 10px;
        }

        .table-responsive::-webkit-scrollbar-track {
            background-color: var(--gray-100);
        }

        .navbar {
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.95) !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-bottom: 1px solid rgba(30, 64, 175, 0.1);
        }

        .navbar.scrolled {
            box-shadow: 0 10px 40px rgba(30, 64, 175, 0.15);
            background: rgba(255, 255, 255, 0.98) !important;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--dark-navy) !important;
            transition: transform 0.3s ease;
        }

        .navbar-brand:hover {
            transform: scale(1.05);
        }

        .nav-link {
            color: var(--dark-navy) !important;
            font-weight: 500;
            position: relative;
            transition: all 0.3s ease;
            padding: 0.5rem 1rem !important;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-blue), var(--accent-orange));
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-link:hover::after {
            width: 80%;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #6366f1 100%);
            position: relative;
            overflow: hidden;
            padding-top: 160px !important;
            padding-bottom: 80px !important;
        }

        .gradient-bg::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 20s infinite ease-in-out;
            pointer-events: none;
        }

        .gradient-bg::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(249, 115, 22, 0.2) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 15s infinite ease-in-out reverse;
            pointer-events: none;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(30px, -30px) rotate(5deg); }
            66% { transform: translate(-20px, 20px) rotate(-5deg); }
        }

        .gradient-bg .display-3,
        .gradient-bg .display-5,
        .gradient-bg h1,
        .gradient-bg h2,
        .gradient-bg h3 {
            font-size: 2.6rem !important;
            line-height: 1.08 !important;
        }

        .hero-image img.img-fluid {
            max-width: 480px !important;
            height: auto !important;
        }

        .stats-badge {
            display: block !important;
            max-width: 280px !important;
            padding: .8rem 1rem !important;
            border-radius: 18px !important;
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.95);
            animation: slideInLeft 0.8s ease-out 0.5s both;
        }

        .stats-badge h4 {
            font-size: 1.6rem !important;
        }

        .stats-badge .icon-box {
            width: 56px !important;
            height: 56px !important;
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .btn-accent {
            background: linear-gradient(135deg, var(--accent-orange) 0%, #fb923c 100%);
            color: white;
            border: none;
            font-weight: 600;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            padding: .7rem 2rem !important;
            font-size: 1rem !important;
            border-radius: 40px !important;
            z-index: 20;
        }

        .btn-accent::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-accent:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-accent:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(249, 115, 22, 0.4);
        }

        .btn-outline-custom {
            border: 2px solid white;
            color: white;
            background: transparent;
            font-weight: 600;
            transition: all 0.3s ease;
            padding: .7rem 2rem !important;
            font-size: 1rem !important;
            border-radius: 40px !important;
            z-index: 20;
        }

        .btn-outline-custom:hover {
            background: white;
            color: var(--primary-blue);
            transform: translateY(-2px);
        }

        .gradient-bg .d-flex.gap-3 {
            gap: 1rem !important;
        }

        .card-modern {
            background: white;
            border-radius: 20px;
            border: 1px solid var(--gray-200);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            padding: 1.5rem !important;
            border-radius: 18px !important;
        }

        .card-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.05) 0%, rgba(249, 115, 22, 0.05) 100%);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .card-modern:hover::before {
            opacity: 1;
        }

        .card-modern:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(30, 64, 175, 0.15);
            border-color: var(--primary-light);
        }

        .icon-box {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-light) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
            position: relative;
            transition: all 0.3s ease;
        }

        .icon-box::after {
            content: '';
            position: absolute;
            inset: -2px;
            background: linear-gradient(135deg, var(--accent-orange), var(--accent-yellow));
            border-radius: 16px;
            opacity: 0;
            z-index: -1;
            transition: opacity 0.3s ease;
        }

        .card-modern:hover .icon-box::after {
            opacity: 1;
        }

        .icon-box:hover {
            transform: rotate(10deg) scale(1.1);
        }

        .feature-card .icon-box {
            width: 72px !important;
            height: 72px !important;
        }

        .feature-card h5 {
            font-size: 1.25rem !important;
        }

        .badge-custom {
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.1) 0%, rgba(249, 115, 22, 0.1) 100%);
            color: var(--primary-blue);
            padding: 0.5rem 1.25rem;
            border-radius: 50px;
            font-weight: 600;
            border: 1px solid rgba(30, 64, 175, 0.2);
            display: inline-block;
        }

        .section-divider {
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-blue), var(--accent-orange));
            border-radius: 2px;
        }

        .gradient-text {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--accent-orange) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-image {
            position: relative;
            animation: fadeInUp 1s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .feature-card {
            animation: fadeInUp 0.6s ease-out both;
        }

        .feature-card:nth-child(1) { animation-delay: 0.1s; }
        .feature-card:nth-child(2) { animation-delay: 0.2s; }
        .feature-card:nth-child(3) { animation-delay: 0.3s; }

        .action-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .action-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .action-card:hover::before {
            left: 100%;
        }

        .action-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 50px rgba(30, 64, 175, 0.2);
        }

        .compact-loan-table {
            min-width: 760px !important;
            font-size: .88rem !important;
        }

        .compact-loan-table thead th,
        .compact-loan-table tbody td {
            padding: .35rem .5rem !important;
        }

        .compact-loan-table thead th {
            font-size: .9rem !important;
        }

        .table-bordered th {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-light) 100%);
            color: white;
            font-weight: 600;
            padding: 1rem;
        }

        .table-bordered td {
            padding: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .table-hover tbody tr:hover {
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.05) 0%, rgba(249, 115, 22, 0.05) 100%);
            transform: scale(1.01);
        }

        .modal-content {
            border: none;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.3);
        }

        .modal.fade .modal-dialog {
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.4s ease;
            transform: scale(0.9) translateY(30px);
            opacity: 0;
        }

        .modal.show .modal-dialog {
            transform: scale(1) translateY(0);
            opacity: 1;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 4px rgba(30, 64, 175, 0.1);
        }

        .pengurus-card img,
        .pengurus-card .rounded-circle {
            transition: all 0.4s ease;
        }

        .pengurus-card:hover img,
        .pengurus-card:hover .rounded-circle {
            transform: scale(1.1) rotate(5deg);
        }

        .bg-cream {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 50%, #fbbf24 100%);
            position: relative;
        }

        .bg-cream::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image:
                radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.3) 1px, transparent 1px),
                radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.3) 1px, transparent 1px);
            background-size: 50px 50px;
            opacity: 0.5;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-light) 100%);
            border: none;
            color: white;
            font-weight: 600;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(30, 64, 175, 0.3);
        }

        .nav-pills .nav-link {
            color: var(--primary-blue);
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .nav-pills .nav-link.active {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-light) 100%);
        }

        .nav-pills .nav-link:hover:not(.active) {
            background: rgba(30, 64, 175, 0.1);
        }

        .join-section {
            padding-top: 2.5rem;
            padding-bottom: 2.5rem;
        }

        @media (min-width: 992px) {
            .join-section {
                padding-top: 3.5rem;
                padding-bottom: 3.5rem;
            }
        }

        @media (max-width: 768px) {
            .display-3 {
                font-size: 2rem !important;
            }
            .display-5 {
                font-size: 1.75rem !important;
            }
            .hero-image {
                margin-top: 2rem;
            }
        }

        @media (max-width: 576px) {
            .join-section {
                padding-top: 1.75rem;
                padding-bottom: 1.75rem;
            }
            .join-section .display-5 {
                font-size: 1.6rem;
            }
        }

        body.has-join-section .join-section {
            margin-bottom: 0 !important;
        }

        body.has-join-section footer {
            margin-top: 0 !important;
            padding-top: 2.5rem;
        }

        #tentang, #tabel-pinjaman, #pengurus {
            display: none !important;
        }
    </style>

    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <div class="icon-box me-2" style="width: 45px; height: 45px; border-radius: 12px;">
                    <i class="bi bi-bank2 text-white fs-5"></i>
                </div>
                <span class="fs-5 fw-bold">Koperasi Amanah</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item mx-lg-2 my-2 my-lg-0">
                        <a class="nav-link" href="#beranda">Beranda</a>
                    </li>
                    <li class="nav-item mx-lg-2 my-2 my-lg-0">
                        <a class="nav-link" href="#tentang">Tentang</a>
                    </li>
                    <li class="nav-item mx-lg-2 my-2 my-lg-0">
                        <a class="nav-link" href="#pengurus">Pengurus</a>
                    </li>
                    <li class="nav-item ms-lg-3 my-2 my-lg-0">
                        <button class="btn btn-accent btn-sm px-4 py-2 rounded-pill w-100" data-bs-toggle="modal" data-bs-target="#loginModal">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section id="beranda" class="gradient-bg text-white" style="padding-top: 140px; padding-bottom: 100px;">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="badge-custom text-white mb-4" style="font-size: 0.875rem; animation: fadeInUp 0.6s ease-out;">
                        <i class="bi bi-stars me-2"></i>Platform Koperasi Digital Terpercaya
                    </div>
                    <h1 class="display-3 fw-bold mb-4" style="line-height: 1.2; animation: fadeInUp 0.6s ease-out 0.1s both;">
                        Koperasi Amanah<br>
                        <span style="background: linear-gradient(135deg, #fbbf24 0%, #f97316 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">BPS Kota Surabaya</span>
                    </h1>
                    <p class="fs-5 mb-5 opacity-90" style="line-height: 1.8; animation: fadeInUp 0.6s ease-out 0.2s both;">
                        {{ $profil['deskripsi'] ?? 'Wujudkan impian finansial Anda bersama koperasi yang terpercaya dan transparan. Layanan modern untuk kesejahteraan bersama.' }}
                    </p>
                    <div class="d-flex gap-3 flex-wrap" style="animation: fadeInUp 0.6s ease-out 0.3s both;">
                        <button class="btn btn-accent px-4 py-2 rounded-pill shadow-lg" data-bs-toggle="modal" data-bs-target="#loginModal" style="font-size: 0.95rem; position: relative; z-index: 5;">
                            <span style="position: relative, z-index: 1;">Mulai Sekarang</span>
                            <i class="bi bi-arrow-right ms-2" style="position: relative, z-index: 1;"></i>
                        </button>
                        <button class="btn btn-outline-custom px-4 py-2 rounded-pill" style="font-size: 0.95rem; position: relative; z-index: 5;"
                            onclick="scrollToId('learn-cards')">
                            Pelajari Lebih Lanjut
                        </button>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="position-relative hero-image">
                        <img src="{{ asset('images/hero.webp') }}" alt="Hero Koperasi" class="img-fluid rounded-4 shadow-lg"
                            style="border-radius: 30px !important; box-shadow: 0 25px 80px rgba(0, 0, 0, 0.3) !important;">
                        <div class="position-absolute bottom-0 start-0 m-4 stats-badge rounded-4 p-4 shadow-lg" style="max-width: 250px; border-radius: 20px !important;">
                            <div class="d-flex align-items-center">
                                <div class="icon-box me-3" style="width: 55px; height: 55px;">
                                    <i class="bi bi-people-fill text-white fs-4"></i>
                                </div>
                                <div>
                                    <h4 class="mb-0 fw-bold gradient-text" style="font-size: 1.75rem;">500+</h4>
                                    <small class="text-muted fw-semibold">Anggota Aktif</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5" style="margin-top: 20px; position: relative; z-index: 10;">
        <div class="container">
            <div class="row g-4" id="learn-cards">
                <div class="col-md-4">
                    <div class="card-modern feature-card p-5 h-100 text-center">
                        <div class="icon-box mx-auto mb-4" style="width: 80px; height: 80px;">
                            <i class="bi bi-lightning-charge-fill text-white fs-2"></i>
                        </div>
                        <h5 class="fw-bold mb-3" style="font-size: 1.25rem;">Proses Cepat</h5>
                        <p class="text-muted mb-0" style="line-height: 1.8;">Pengajuan dan pencairan dana yang efisien dengan sistem digital terintegrasi</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-modern feature-card p-5 h-100 text-center">
                        <div class="icon-box mx-auto mb-4" style="width: 80px; height: 80px;">
                            <i class="bi bi-shield-fill-check text-white fs-2"></i>
                        </div>
                        <h5 class="fw-bold mb-3" style="font-size: 1.25rem;">Aman & Terpercaya</h5>
                        <p class="text-muted mb-0" style="line-height: 1.8;">Keamanan data terjamin dengan enkripsi tingkat tinggi dan transparansi penuh</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-modern feature-card p-5 h-100 text-center">
                        <div class="icon-box mx-auto mb-4" style="width: 80px; height: 80px;">
                            <i class="bi bi-headset text-white fs-2"></i>
                        </div>
                        <h5 class="fw-bold mb-3" style="font-size: 1.25rem;">Dukungan 24/7</h5>
                        <p class="text-muted mb-0" style="line-height: 1.8;">Tim customer service siap membantu Anda kapan saja dengan respon cepat</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light" aria-label="Quick actions">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold gradient-text mb-3" style="font-size: 2.5rem;">Akses Cepat</h2>
                <div class="section-divider mx-auto mb-3"></div>
                <p class="text-muted fs-6">Klik salah satu area untuk melihat informasi lengkap</p>
            </div>
            <div class="row g-4 mt-4" id="quickActionsGrid"></div>
        </div>
    </section>

    <section id="tentang" class="py-5 bg-white">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold gradient-text mb-3">Visi & Misi</h2>
                <div class="section-divider mx-auto mb-4"></div>
                <p class="text-muted fs-6">Komitmen kami untuk memberikan layanan terbaik</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="card-modern p-5 h-100" style="border-left: 5px solid var(--primary-blue);">
                        <div class="d-flex align-items-start mb-4">
                            <div class="icon-box me-4" style="width: 70px; height: 70px;">
                                <i class="bi bi-eye-fill text-white fs-3"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-4" style="font-size: 1.25rem; color: var(--dark-navy);">Visi Kami</h4>
                                <p class="text-muted mb-0" style="font-size: 0.9rem; line-height: 1.7;">
                                    {{ $profil['visi'] ?? 'Menjadi koperasi terdepan yang memberikan pelayanan prima, inovatif, dan membawa kesejahteraan berkelanjutan bagi seluruh anggota dengan teknologi digital terkini.' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card-modern p-5 h-100" style="border-left: 5px solid var(--accent-orange);">
                        <div class="d-flex align-items-start mb-4">
                            <div class="icon-box me-4" style="width: 70px; height: 70px; background: linear-gradient(135deg, var(--accent-orange) 0%, #fb923c 100%);">
                                <i class="bi bi-bullseye text-white fs-3"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h4 class="fw-bold mb-4" style="font-size: 1.25rem; color: var(--dark-navy);">Misi Kami</h4>
                                @if (isset($profil['misi']) && is_array($profil['misi']))
                                    <div class="d-flex flex-column gap-3">
                                        @foreach ($profil['misi'] as $index => $misi)
                                            <div class="d-flex align-items-start">
                                                <div class="badge-custom me-3 flex-shrink-0"
                                                    style="min-width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; font-weight: 700;">
                                                    {{ $index + 1 }}
                                                </div>
                                                <p class="text-muted mb-0" style="font-size: 0.9rem; line-height: 1.7;">{{ $misi }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="d-flex flex-column gap-3">
                                        <div class="d-flex align-items-start">
                                            <div class="badge-custom me-3 flex-shrink-0"
                                                style="min-width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; font-weight: 700;">1</div>
                                            <p class="text-muted mb-0" style="font-size: 0.9rem; line-height: 1.7;">Memberikan layanan keuangan yang amanah, profesional dan berbasis teknologi</p>
                                        </div>
                                        <div class="d-flex align-items-start">
                                            <div class="badge-custom me-3 flex-shrink-0"
                                                style="min-width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; font-weight: 700;">2</div>
                                            <p class="text-muted mb-0" style="font-size: 0.9rem; line-height: 1.7;">Meningkatkan kesejahteraan anggota secara berkelanjutan dan inklusif</p>
                                        </div>
                                        <div class="d-flex align-items-start">
                                            <div class="badge-custom me-3 flex-shrink-0"
                                                style="min-width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; font-weight: 700;">3</div>
                                            <p class="text-muted mb-0" style="font-size: 0.9rem; line-height: 1.7;">Menerapkan prinsip koperasi dengan transparan, akuntabel dan digital</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="tabel-pinjaman" class="container py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold gradient-text mb-3" style="font-size: 2.5rem;">Tabel Pinjaman & Angsuran</h2>
            <div class="section-divider mx-auto mb-4"></div>
            <p class="text-muted fs-6">Simulasi angsuran berdasarkan jumlah pinjaman dan tenor yang dipilih</p>
        </div>

        <div class="alert alert-info mb-4" style="border-radius: 16px; border-left: 5px solid var(--primary-blue); background: linear-gradient(135deg, rgba(30, 64, 175, 0.05) 0%, rgba(59, 130, 246, 0.05) 100%);">
            <h6 class="fw-bold mb-3"><i class="bi bi-info-circle me-2"></i>Informasi Penting</h6>
            <ul class="mb-0">
                <li>Biaya Administrasi: <strong>5%</strong> dari jumlah pinjaman</li>
                <li>Bunga: <strong>0%</strong> (Tanpa bunga)</li>
                <li>Metode: Pemotongan gaji otomatis atau transfer manual</li>
            </ul>
        </div>

        <div class="table-responsive" style="border-radius: 16px; overflow-x: auto; -webkit-overflow-scrolling: touch; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">
            <table class="table table-bordered table-hover mb-0 compact-loan-table" style="min-width: 1100px; white-space: nowrap;">
                <thead>
                    <tr class="text-center">
                        <th colspan="12" style="padding: 1.5rem; font-size: 1.25rem;">Besar Pinjaman</th>
                    </tr>
                    <tr style="background: rgba(30, 64, 175, 0.1);">
                        <th style="background: var(--primary-blue);">Tenor</th>
                        <th>3.000.000</th>
                        <th>3.500.000</th>
                        <th>4.000.000</th>
                        <th>4.500.000</th>
                        <th>5.000.000</th>
                        <th>5.500.000</th>
                        <th>6.000.000</th>
                        <th>7.000.000</th>
                        <th>8.000.000</th>
                        <th>9.000.000</th>
                        <th>10.000.000</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <tr style="background: linear-gradient(135deg, rgba(249, 115, 22, 0.1) 0%, rgba(251, 146, 60, 0.1) 100%);">
                        <td class="fw-bold">Adm 5%</td>
                        <td>150.000</td>
                        <td>175.000</td>
                        <td>200.000</td>
                        <td>225.000</td>
                        <td>250.000</td>
                        <td>275.000</td>
                        <td>300.000</td>
                        <td>350.000</td>
                        <td>400.000</td>
                        <td>450.000</td>
                        <td>500.000</td>
                    </tr>
                    <tr style="background: linear-gradient(135deg, rgba(30, 64, 175, 0.1) 0%, rgba(59, 130, 246, 0.1) 100%);">
                        <td class="fw-bold">Terima</td>
                        <td>2.850.000</td>
                        <td>3.325.000</td>
                        <td>3.800.000</td>
                        <td>4.275.000</td>
                        <td>4.750.000</td>
                        <td>5.225.000</td>
                        <td>5.700.000</td>
                        <td>6.650.000</td>
                        <td>7.600.000</td>
                        <td>8.550.000</td>
                        <td>9.500.000</td>
                    </tr>
                    <tr>
                        <td colspan="12" class="text-center fw-bold" style="background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-light) 100%); color: white; padding: 1.25rem; font-size: 1.125rem;">Angsuran Per Bulan</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">2 Bulan</td>
                        <td>1.500.000</td>
                        <td>1.750.000</td>
                        <td>2.000.000</td>
                        <td>2.250.000</td>
                        <td>2.500.000</td>
                        <td>2.750.000</td>
                        <td>3.000.000</td>
                        <td>3.500.000</td>
                        <td>4.000.000</td>
                        <td>4.500.000</td>
                        <td>5.000.000</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">3 Bulan</td>
                        <td>1.000.000</td>
                        <td>1.166.667</td>
                        <td>1.333.333</td>
                        <td>1.500.000</td>
                        <td>1.666.667</td>
                        <td>1.833.333</td>
                        <td>2.000.000</td>
                        <td>2.333.333</td>
                        <td>2.666.667</td>
                        <td>3.000.000</td>
                        <td>3.333.333</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">4 Bulan</td>
                        <td>750.000</td>
                        <td>875.000</td>
                        <td>1.000.000</td>
                        <td>1.125.000</td>
                        <td>1.250.000</td>
                        <td>1.375.000</td>
                        <td>1.500.000</td>
                        <td>1.750.000</td>
                        <td>2.000.000</td>
                        <td>2.250.000</td>
                        <td>2.500.000</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">5 Bulan</td>
                        <td>600.000</td>
                        <td>700.000</td>
                        <td>800.000</td>
                        <td>900.000</td>
                        <td>1.000.000</td>
                        <td>1.100.000</td>
                        <td>1.200.000</td>
                        <td>1.400.000</td>
                        <td>1.600.000</td>
                        <td>1.800.000</td>
                        <td>2.000.000</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">6 Bulan</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td>583.333</td>
                        <td>666.667</td>
                        <td>750.000</td>
                        <td>833.333</td>
                        <td>916.667</td>
                        <td>1.500.000</td>
                        <td>1.666.667</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">7 Bulan</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td>500.000</td>
                        <td>571.429</td>
                        <td>642.857</td>
                        <td>714.286</td>
                        <td>785.714</td>
                        <td>857.143</td>
                        <td>1.000.000</td>
                        <td>1.142.857</td>
                        <td>1.285.714</td>
                        <td>1.428.571</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">8 Bulan</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td>500.000</td>
                        <td>562.500</td>
                        <td>625.000</td>
                        <td>687.500</td>
                        <td>750.000</td>
                        <td>875.000</td>
                        <td>1.000.000</td>
                        <td>1.125.000</td>
                        <td>1.250.000</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">9 Bulan</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td>500.000</td>
                        <td>555.556</td>
                        <td>611.111</td>
                        <td>666.667</td>
                        <td>777.778</td>
                        <td>888.889</td>
                        <td>1.000.000</td>
                        <td>1.111.111</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">10 Bulan</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td>500.000</td>
                        <td>550.000</td>
                        <td>600.000</td>
                        <td>700.000</td>
                        <td>800.000</td>
                        <td>900.000</td>
                        <td>1.000.000</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">11 Bulan</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td>500.000</td>
                        <td>545.455</td>
                        <td>636.364</td>
                        <td>727.273</td>
                        <td>818.182</td>
                        <td>909.091</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">12 Bulan</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td>500.000</td>
                        <td>583.333</td>
                        <td>666.667</td>
                        <td>750.000</td>
                        <td>833.333</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">15 Bulan</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td>466.667</td>
                        <td>533.333</td>
                        <td>600.000</td>
                        <td>666.667</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">16 Bulan</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td>500.000</td>
                        <td>562.500</td>
                        <td>625.000</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">17 Bulan</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td>529.412</td>
                        <td>588.235</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">18 Bulan</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td>500.000</td>
                        <td>555.556</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">19 Bulan</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td>526.316</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">20 Bulan</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td style="background: var(--gray-100); color: #999;">-</td>
                        <td>500.000</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="alert alert-warning mt-4" style="border-radius: 16px; border-left: 5px solid var(--accent-orange); background: linear-gradient(135deg, rgba(249, 115, 22, 0.05) 0%, rgba(251, 146, 60, 0.05) 100%);">
            <h6 class="fw-bold mb-2"><i class="bi bi-exclamation-triangle me-2"></i>Catatan Penting</h6>
            <p class="mb-0">Angsuran dalam Rupiah per bulan. Tanda (-) berarti kombinasi tidak tersedia.</p>
        </div>
    </div>

    <section id="pengurus" class="py-5 bg-cream">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold gradient-text mb-3">Pengurus Koperasi</h2>
                <div class="section-divider mx-auto mb-4"></div>
                <p class="text-muted fs-6">Tim profesional yang berpengalaman dan berdedikasi</p>
            </div>
            <div class="row g-4">
                @if (isset($staf) && count($staf) > 0)
                    @foreach ($staf as $s)
                        <div class="col-md-6 col-lg-4">
                            <div class="card-modern pengurus-card p-5 h-100 text-center">
                                <div class="position-relative d-inline-block mb-4">
                                    <img src="{{ $s['foto'] }}" class="rounded-circle shadow-lg" alt="{{ $s['nama'] }}"
                                        style="width: 140px; height: 140px; object-fit: cover; border: 5px solid white;">
                                    <div class="position-absolute bottom-0 end-0 rounded-circle"
                                        style="width: 30px; height: 30px; border: 4px solid white; background: linear-gradient(135deg, #10b981 0%, #34d399 100%);"></div>
                                </div>
                                <h5 class="fw-bold mb-3" style="font-size: 1.25rem; color: var(--dark-navy);">{{ $s['nama'] }}</h5>
                                <div class="badge-custom d-inline-block mb-3">{{ $s['jabatan'] }}</div>
                                <p class="text-muted small mb-0" style="line-height: 1.6;">Siap melayani dengan sepenuh hati</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-md-6 col-lg-4">
                        <div class="card-modern pengurus-card p-5 h-100 text-center">
                            <div class="position-relative d-inline-block mb-4">
                                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                    style="width: 140px; height: 140px; background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-light) 100%); border: 5px solid white;">
                                    <i class="bi bi-person text-white" style="font-size: 4rem;"></i>
                                </div>
                                <div class="position-absolute bottom-0 end-0 rounded-circle"
                                    style="width: 30px; height: 30px; border: 4px solid white; background: linear-gradient(135deg, #10b981 0%, #34d399 100%);"></div>
                            </div>
                            <h5 class="fw-bold mb-3" style="font-size: 1.25rem; color: var(--dark-navy);">Ahmad Budi Santoso</h5>
                            <div class="badge-custom d-inline-block mb-3">Ketua Koperasi</div>
                            <p class="text-muted small mb-0" style="line-height: 1.6;">Memimpin dengan integritas dan dedikasi</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card-modern pengurus-card p-5 h-100 text-center">
                            <div class="position-relative d-inline-block mb-4">
                                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                    style="width: 140px; height: 140px; background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-light) 100%); border: 5px solid white;">
                                    <i class="bi bi-person text-white" style="font-size: 4rem;"></i>
                                </div>
                                <div class="position-absolute bottom-0 end-0 rounded-circle"
                                    style="width: 30px; height: 30px; border: 4px solid white; background: linear-gradient(135deg, #10b981 0%, #34d399 100%);"></div>
                            </div>
                            <h5 class="fw-bold mb-3" style="font-size: 1.25rem; color: var(--dark-navy);">Siti Nur Azizah</h5>
                            <div class="badge-custom d-inline-block mb-3">Bendahara Koperasi</div>
                            <p class="text-muted small mb-0" style="line-height: 1.6;">Mengelola keuangan dengan cermat</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card-modern pengurus-card p-5 h-100 text-center">
                            <div class="position-relative d-inline-block mb-4">
                                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                    style="width: 140px; height: 140px; background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-light) 100%); border: 5px solid white;">
                                    <i class="bi bi-person text-white" style="font-size: 4rem;"></i>
                                </div>
                                <div class="position-absolute bottom-0 end-0 rounded-circle"
                                    style="width: 30px; height: 30px; border: 4px solid white; background: linear-gradient(135deg, #10b981 0%, #34d399 100%);"></div>
                            </div>
                            <h5 class="fw-bold mb-3" style="font-size: 1.25rem; color: var(--dark-navy);">Rina Pratiwi</h5>
                            <div class="badge-custom d-inline-block mb-3">Sekretaris Koperasi</div>
                            <p class="text-muted small mb-0" style="line-height: 1.6;">Mengorganisir dengan profesional</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <section class="gradient-bg text-white join-section">
        <div class="container text-center">
            <h2 class="display-5 fw-bold mb-4">Siap Bergabung dengan Kami?</h2>
            <p class="fs-5 mb-5 opacity-90" style="line-height: 1.8; max-width: 700px; margin: 0 auto;">Daftarkan diri Anda sekarang dan nikmati berbagai kemudahan layanan koperasi digital</p>
            <button class="btn btn-accent btn-lg px-5 py-3 rounded-pill shadow-lg" data-bs-toggle="modal" data-bs-target="#loginModal">
                <span style="position: relative, z-index: 1;">Daftar Sekarang</span>
                <i class="bi bi-arrow-right ms-2" style="position: relative, z-index: 1;"></i>
            </button>
        </div>
    </section>

    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content" style="border-radius: 24px; border: none; overflow: hidden;">
                <div class="row g-0">
                    <div class="col-md-5 gradient-bg text-white p-5 d-none d-md-flex flex-column justify-content-center">
                        <div class="icon-box mb-4" style="width: 70px; height: 70px;">
                            <i class="bi bi-bank2 text-white fs-2"></i>
                        </div>
                        <h3 class="fw-bold mb-4" style="font-size: 2rem;">Selamat Datang</h3>
                        <p class="opacity-90 mb-5" style="line-height: 1.8;">Akses akun Anda untuk menikmati berbagai layanan koperasi digital yang mudah dan aman</p>
                        <div class="mt-auto">
                            <p class="small opacity-75 mb-0">© 2025 Koperasi Amanah</p>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <div class="p-5">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="fw-bold mb-0" style="color: var(--dark-navy);">Akses Akun</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <ul class="nav nav-pills mb-4" role="tablist" style="gap: 0.5rem;">
                                <li class="nav-item flex-fill" role="presentation">
                                    <button class="nav-link active w-100 rounded-pill" id="login-tab" data-bs-toggle="tab" data-bs-target="#login"
                                        type="button" role="tab" style="padding: 0.75rem 1.5rem; font-weight: 600;">
                                        Login
                                    </button>
                                </li>
                                <li class="nav-item flex-fill" role="presentation">
                                    <button class="nav-link w-100 rounded-pill" id="register-tab" data-bs-toggle="tab" data-bs-target="#register"
                                        type="button" role="tab" style="padding: 0.75rem 1.5rem; font-weight: 600;">
                                        Register
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="login" role="tabpanel">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul class="mb-0">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label for="loginEmail" class="form-label fw-semibold" style="font-size: 0.938rem;">Email</label>
                                                <input type="email" class="form-control" id="loginEmail" name="email"
                                                    placeholder="Masukkan email" required value="{{ old('email') }}"
                                                    style="border-radius: 10px; padding: 0.625rem 1rem; font-size: 0.938rem;">
                                            </div>
                                            <div class="col-12">
                                                <label for="loginPassword" class="form-label fw-semibold" style="font-size: 0.938rem;">Password</label>
                                                <input type="password" class="form-control" id="loginPassword" name="password"
                                                    placeholder="Masukkan password" required
                                                    style="border-radius: 10px; padding: 0.625rem 1rem; font-size: 0.938rem;">
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary-custom w-100 btn-lg mt-4"
                                            style="padding: 0.75rem; font-size: 1rem; border-radius: 10px;">
                                            Login Sekarang
                                        </button>

                                        <div class="text-center mt-3">
                                            <small class="text-muted" style="font-size: 0.875rem;">Lupa password? <a href="#" class="text-decoration-none fw-semibold text-primary-teal">Reset di sini</a></small>
                                        </div>
                                    </form>
                                </div>

                                <div class="tab-pane fade" id="register" role="tabpanel">
                                    <div class="alert alert-info">
                                        <i class="bi bi-info-circle me-2"></i>
                                        <strong>Pendaftaran Anggota Baru</strong><br>
                                        Hanya untuk pegawai BPS Kota Surabaya yang ingin menjadi anggota koperasi.
                                    </div>

                                    <form method="POST" action="{{ route('register') }}">
                                        @csrf
                                        <input type="hidden" name="role" value="peminjam">

                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label for="regNama" class="form-label fw-semibold" style="font-size: 0.938rem;">Nama Lengkap</label>
                                                <input type="text" class="form-control" id="regNama" name="name"
                                                    placeholder="Nama lengkap Anda" required value="{{ old('name') }}"
                                                    style="border-radius: 10px; padding: 0.625rem 1rem; font-size: 0.938rem;">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="regNip" class="form-label fw-semibold" style="font-size: 0.938rem;">NIP</label>
                                                <input type="text" class="form-control" id="regNip" name="nip"
                                                    placeholder="Nomor Induk Pegawai" required value="{{ old('nip') }}"
                                                    style="border-radius: 10px; padding: 0.625rem 1rem; font-size: 0.938rem;">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="regGolongan" class="form-label fw-semibold" style="font-size: 0.938rem;">Golongan</label>
                                                <input type="text" class="form-control" id="regGolongan" name="golongan"
                                                    placeholder="Golongan" required value="{{ old('golongan') }}"
                                                    style="border-radius: 10px; padding: 0.625rem 1rem; font-size: 0.938rem;">
                                            </div>
                                            <div class="col-12">
                                                <label for="regJabatan" class="form-label fw-semibold" style="font-size: 0.938rem;">Jabatan</label>
                                                <input type="text" class="form-control" id="regJabatan" name="jabatan"
                                                    placeholder="Jabatan Anda" required value="{{ old('jabatan') }}"
                                                    style="border-radius: 10px; padding: 0.625rem 1rem; font-size: 0.938rem;">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="regHp" class="form-label fw-semibold" style="font-size: 0.938rem;">No HP</label>
                                                <input type="tel" class="form-control" id="regHp" name="phone"
                                                    placeholder="08xxxxxxxxxx" required value="{{ old('phone') }}"
                                                    style="border-radius: 10px; padding: 0.625rem 1rem; font-size: 0.938rem;">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="regEmail" class="form-label fw-semibold" style="font-size: 0.938rem;">Email</label>
                                                <input type="email" class="form-control" id="regEmail" name="email"
                                                    placeholder="email@example.com" required value="{{ old('email') }}"
                                                    style="border-radius: 10px; padding: 0.625rem 1rem; font-size: 0.938rem;">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="regPassword" class="form-label fw-semibold" style="font-size: 0.938rem;">Password</label>
                                                <input type="password" class="form-control" id="regPassword" name="password"
                                                    placeholder="Min. 8 karakter" required
                                                    style="border-radius: 10px; padding: 0.625rem 1rem; font-size: 0.938rem;">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="regConfirmPassword" class="form-label fw-semibold" style="font-size: 0.938rem;">Konfirmasi Password</label>
                                                <input type="password" class="form-control" id="regConfirmPassword" name="password_confirmation"
                                                    placeholder="Ulangi password" required
                                                    style="border-radius: 10px; padding: 0.625rem 1rem; font-size: 0.938rem;">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary-custom w-100 btn-lg mt-4" style="padding: 0.75rem; font-size: 1rem; border-radius: 10px;">
                                            Daftar Sekarang
                                        </button>
                                        <div class="text-center mt-3">
                                            <small class="text-muted" style="font-size: 0.875rem;">Sudah punya akun? <a href="#"
                                                    class="text-decoration-none fw-semibold text-primary-teal"
                                                    onclick="document.getElementById('login-tab').click(); return false;">Login di sini</a></small>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function scrollToId(id) {
            const el = document.getElementById(id);
            if (!el) return;
            const navbarHeight = document.querySelector('.navbar')?.offsetHeight || 80;
            const rect = el.getBoundingClientRect();
            const absoluteTop = window.pageYOffset + rect.top;
            window.scrollTo({ top: absoluteTop - navbarHeight - 16, behavior: 'smooth' });
        }
        // Function removed - login now handled by form submission

        // Register form now handled by Laravel form submission

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const offset = 80;
                    const targetPosition = target.offsetTop - offset;
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });

        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.boxShadow = '0 4px 30px rgba(8, 56, 69, 0.3)';
            } else {
                navbar.style.boxShadow = '0 4px 20px rgba(8, 56, 69, 0.15)';
            }
        });

        document.querySelectorAll('.card-modern').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
                this.style.transition = 'all 0.3s ease';
            });
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
            link.addEventListener('click', function() {
                const navbarCollapse = document.getElementById('navbarNav');
                if (navbarCollapse.classList.contains('show')) {
                    const bsCollapse = new bootstrap.Collapse(navbarCollapse);
                    bsCollapse.hide();
                }
            });
        });

        (function() {
            const actions = [
                {
                    id: 'visi-misi',
                    title: 'Visi & Misi',
                    icon: 'bi-eye-fill',
                    variant: 'linear-gradient(135deg, #0d9488 0%, #14b8a6 100%)',
                    contentSelector: '#tentang'
                },
                {
                    id: 'tabel-anggota',
                    title: 'Tabel Pinjaman & Angsuran',
                    icon: 'bi-table',
                    variant: 'linear-gradient(135deg, #0ea5e9 0%, #3b82f6 100%)',
                    contentSelector: '#tabel-pinjaman'
                },
                {
                    id: 'info-koperasi',
                    title: 'Informasi Koperasi',
                    icon: 'bi-info-circle',
                    variant: 'linear-gradient(135deg, #f97316 0%, #fb923c 100%)',
                    contentSelector: '#pengurus'
                }
            ];

            const grid = document.getElementById('quickActionsGrid');

            function createActionCard(a) {
                const col = document.createElement('div');
                col.className = 'col-md-4';

                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'action-card w-100 p-4 d-flex flex-column align-items-center text-center';
                btn.style.borderRadius = '16px';
                btn.style.border = 'none';
                btn.style.background = '#fff';
                btn.style.boxShadow = '0 6px 24px rgba(13, 39, 45, 0.06)';
                btn.style.cursor = 'pointer';
                btn.style.minHeight = '200px';
                btn.setAttribute('data-action-id', a.id);

                btn.innerHTML = `
                    <div class="icon-action mb-3" style="width:70px;height:70px;border-radius:14px;display:flex;align-items:center;justify-content:center;background:${a.variant};">
                        <i class="bi ${a.icon} text-white fs-2"></i>
                    </div>
                    <div class="fw-bold mb-2" style="font-size:1.1rem;color:var(--dark-navy);">${a.title}</div>
                    <div class="text-muted small">Klik untuk membuka</div>
                `;

                btn.addEventListener('mouseenter', () => {
                    btn.style.transform = 'translateY(-6px)';
                    btn.style.transition = 'all 0.28s cubic-bezier(.2,.9,.2,1)';
                });
                btn.addEventListener('mouseleave', () => {
                    btn.style.transform = '';
                });

                btn.addEventListener('click', () => openAction(a));

                col.appendChild(btn);
                return col;
            }

            function openAction(a) {
                const modalEl = document.getElementById('actionModal');
                const modalBody = modalEl.querySelector('.modal-body');
                const modalTitle = modalEl.querySelector('.modal-title');

                modalTitle.textContent = a.title;

                if (a.contentSelector) {
                    const node = document.querySelector(a.contentSelector);
                    if (node) {
                        const clone = node.cloneNode(true);
                        if (clone.hasAttribute && clone.hasAttribute('id')) clone.removeAttribute('id');
                        clone.querySelectorAll('[id]').forEach(el => el.removeAttribute('id'));
                        modalBody.innerHTML = '';
                        modalBody.appendChild(clone);
                    } else {
                        modalBody.innerHTML = '<p class="mb-0">Konten tidak ditemukan.</p>';
                    }
                } else if (a.content) {
                    modalBody.innerHTML = a.content;
                } else {
                    modalBody.innerHTML = '<p class="mb-0">Tidak ada konten.</p>';
                }

                const bsModal = new bootstrap.Modal(modalEl);
                modalEl.classList.remove('fade-scale-enter');
                bsModal.show();
            }

            actions.forEach(a => {
                grid.appendChild(createActionCard(a));
            });

            if (!document.getElementById('actionModal')) {
                const div = document.createElement('div');
                div.innerHTML = `\
                <div class="modal fade" id="actionModal" tabindex="-1" aria-hidden="true">\
                  <div class="modal-dialog modal-dialog-centered modal-xl">\
                    <div class="modal-content" style="border-radius:14px;overflow:hidden;">\
                      <div class="modal-header border-0">\
                        <h5 class="modal-title"></h5>\
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>\
                      </div>\
                      <div class="modal-body p-4" style="min-height:120px;">\
                      </div>\
                    </div>\
                  </div>\
                </div>`;
                document.body.appendChild(div.firstElementChild);

                const style = document.createElement('style');
                style.textContent = `
                .modal.fade .modal-dialog { transition: transform 220ms cubic-bezier(.2,.9,.2,1), opacity 220ms ease; transform: translateY(10px) scale(.98); opacity: 0; }
                .modal.show .modal-dialog { transform: translateY(0) scale(1); opacity: 1; }
                .action-card:focus { outline: none; box-shadow: 0 8px 30px rgba(13,39,45,0.08); }
                `;
                document.head.appendChild(style);
            }
        })();

        (function(){
            if (document.querySelector('.join-section')) {
                document.documentElement.classList.add('has-join-section');
                document.body.classList.add('has-join-section');
            }
        })();
    </script>
@endpush
