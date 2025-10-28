<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>@yield('title', 'Koperasi Amanah BPS Kota Surabaya')</title>
    @stack('meta')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/pengurus-enhanced.css') }}?v={{ time() }}">
    @stack('styles')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        :root {
            --primary-blue: #2196F3;
            --primary-light: #4DB6E8;
            --primary-darker: #1976D2;
            --primary-green: #7AC143;
            --accent-orange: #F39C12;
            --accent-yellow: #FFC107;
            --dark-navy: #0f172a;
            --cream: #fef3c7;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
        }

        * {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
        }

        body {
            background: var(--cream);
            margin: 0;
            padding: 0;
        }

        .navbar {
            background: var(--primary-darker) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(25, 118, 210, 0.15);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.25rem;
            letter-spacing: -0.5px;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-light) 100%);
            border: none;
            color: white;
            font-weight: 600;
            padding: 0.75rem 2rem;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 15px rgba(33, 150, 243, 0.3);
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(33, 150, 243, 0.4);
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary-blue) 100%);
        }

        .btn-accent {
            background: linear-gradient(135deg, var(--accent-orange) 0%, var(--primary-green) 100%);
            border: none;
            color: white;
            font-weight: 600;
            padding: 0.75rem 2rem;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .btn-accent:hover {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--accent-orange) 100%);
            color: white;
            transform: translateY(-2px);
        }

        .btn-outline-custom {
            border: 2px solid white;
            color: white;
            background: transparent;
            font-weight: 600;
            padding: 0.75rem 2rem;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .btn-outline-custom:hover {
            background: white;
            color: var(--primary-blue);
        }

        .card-modern {
            background: white;
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(33, 150, 243, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        .card-modern:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 60px rgba(33, 150, 243, 0.15);
        }

        .gradient-bg {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-light) 50%, var(--primary-green) 100%);
        }

        .gradient-bg-orange {
            background: linear-gradient(135deg, var(--accent-orange) 0%, var(--primary-green) 100%);
        }

        .gradient-text {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-green) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .section-divider {
            width: 80px;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-blue) 0%, var(--accent-orange) 100%);
            border-radius: 10px;
        }

        .icon-box {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-light) 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 20px rgba(33, 150, 243, 0.3);
        }

        footer {
            background: var(--primary-darker);
            color: white;
            position: relative;
            overflow: hidden;
            margin: 0;
            padding: 0;
        }

        footer .container {
            text-align: center;
        }

        footer .row {
            justify-content: center;
        }

        footer .col-lg-4,
        footer .col-lg-3,
        footer .col-lg-2 {
            text-align: center;
            margin-bottom: 2rem;
        }

        footer h5,
        footer h6 {
            text-align: center;
            margin-bottom: 1rem;
        }

        footer .d-flex {
            justify-content: center;
        }

        footer .list-unstyled {
            display: inline-block;
            text-align: left;
        }

        footer .btn {
            margin: 0 0.25rem;
        }

        @media (min-width: 992px) {
            footer .col-lg-4,
            footer .col-lg-3,
            footer .col-lg-2 {
                text-align: left;
            }

            footer h5,
            footer h6 {
                text-align: left;
            }

            footer .d-flex {
                justify-content: flex-start;
            }
        }

        footer::before {
            display: none;
        }

        .sidebar {
            min-height: 100vh;
            background: var(--primary-darker);
        }

        .sidebar .nav-link {
            color: #fff;
            transition: all 0.3s ease;
            border-radius: 10px;
            margin: 0.25rem 0;
        }

        .sidebar .nav-link:hover {
            background: rgba(77, 182, 232, 0.2);
        }

        .sidebar .nav-link.active {
            background: linear-gradient(135deg, var(--accent-orange) 0%, var(--primary-green) 100%);
        }

        .nav-link {
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .badge-custom {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-light) 100%);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
        }

        .bg-cream {
            background: var(--cream);
        }

        .text-primary-teal {
            color: var(--primary-blue);
        }

        .text-accent {
            color: var(--accent-orange);
        }

        body > *:last-child {
            margin-bottom: 0 !important;
        }

        footer {
            margin-top: 0 !important;
            padding-top: 3rem !important;
        }

        .gradient-bg.join-section,
        .join-section {
            padding-top: 4rem !important;
            padding-bottom: 4rem !important;
            margin-bottom: 0 !important;
        }

        @media (min-width: 768px) {
            .gradient-bg.join-section,
            .join-section {
                padding-top: 5rem !important;
                padding-bottom: 5rem !important;
            }
        }

        section:not(.join-section):last-of-type {
            margin-bottom: 0 !important;
        }

        .container:last-child {
            margin-bottom: 0 !important;
        }
    </style>
    @stack('styles')
</head>

<body>
    @yield('content')

    <footer class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="fw-bold mb-3">Koperasi Amanah BPS Kota Surabaya</h5>
                    <p class="opacity-75 mb-0">Membangun kesejahteraan anggota melalui layanan koperasi yang amanah dan profesional dengan teknologi
                        terkini.</p>
                </div>
                <div class="col-lg-3">
                    <h6 class="fw-bold mb-3">Kontak Kami</h6>
                    <div class="d-flex align-items-center mb-2 opacity-75">
                        <i class="bi bi-telephone-fill me-2"></i>
                        <span>(031) 123-4567</span>
                    </div>
                    <div class="d-flex align-items-center mb-2 opacity-75">
                        <i class="bi bi-envelope-fill me-2"></i>
                        <span>info@koperasiamanah.id</span>
                    </div>
                    <div class="d-flex align-items-center opacity-75">
                        <i class="bi bi-geo-alt-fill me-2"></i>
                        <span>Surabaya, Jawa Timur</span>
                    </div>
                </div>
                <div class="col-lg-2">
                    <h6 class="fw-bold mb-3">Menu</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white opacity-75 text-decoration-none">Tentang</a></li>
                        <li class="mb-2"><a href="#" class="text-white opacity-75 text-decoration-none">Layanan</a></li>
                        <li class="mb-2"><a href="#" class="text-white opacity-75 text-decoration-none">Kontak</a></li>
                    </ul>
                </div>
                <div class="col-lg-2">
                    <h6 class="fw-bold mb-3">Sosial Media</h6>
                    <div class="d-flex gap-2">
                        <a href="#" class="btn btn-sm btn-outline-light rounded-circle"
                            style="width: 36px; height: 36px; padding: 0; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-outline-light rounded-circle"
                            style="width: 36px; height: 36px; padding: 0; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-outline-light rounded-circle"
                            style="width: 36px; height: 36px; padding: 0; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>
            <hr class="my-4 opacity-25">
            <div class="text-center opacity-75">
                <small>&copy; {{ date('Y') }} Koperasi Amanah BPS Kota Surabaya. Hak Cipta Dilindungi.</small>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
