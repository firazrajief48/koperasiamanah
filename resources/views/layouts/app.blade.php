<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Koperasi Amanah BPS Kota Surabaya')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    @stack('styles')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        :root {
            --primary-dark: #0b4962;
            --primary-teal: #31a2a8;
            --primary-light: #4db8bd;
            --primary-darker: #083845;
            --cream: #fdfaf5;
            --accent-orange: #ff8c42;
        }

        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: var(--cream);
        }

        .navbar {
            background: var(--primary-darker) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(8, 56, 69, 0.15);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.25rem;
            letter-spacing: -0.5px;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-teal) 0%, var(--primary-light) 100%);
            border: none;
            color: white;
            font-weight: 600;
            padding: 0.75rem 2rem;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 15px rgba(49, 162, 168, 0.3);
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(49, 162, 168, 0.4);
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-teal) 100%);
        }

        .btn-accent {
            background: var(--accent-orange);
            border: none;
            color: white;
            font-weight: 600;
            padding: 0.75rem 2rem;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .btn-accent:hover {
            background: #e67a35;
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
            color: var(--primary-teal);
        }

        .card-modern {
            background: white;
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(11, 73, 98, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        .card-modern:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 60px rgba(49, 162, 168, 0.15);
        }

        .gradient-bg {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-teal) 50%, var(--primary-light) 100%);
        }

        .gradient-text {
            background: linear-gradient(135deg, var(--primary-teal) 0%, var(--accent-orange) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .section-divider {
            width: 80px;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-teal) 0%, var(--accent-orange) 100%);
            border-radius: 10px;
        }

        .icon-box {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-teal) 0%, var(--primary-light) 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 20px rgba(49, 162, 168, 0.3);
        }

        footer {
            background: var(--primary-darker);
            color: white;
            position: relative;
            overflow: hidden;
        }

        footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-teal) 0%, var(--primary-light) 50%, var(--accent-orange) 100%);
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
            background: rgba(49, 162, 168, 0.2);
        }

        .sidebar .nav-link.active {
            background: linear-gradient(135deg, var(--primary-teal) 0%, var(--primary-light) 100%);
        }

        .nav-link {
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .badge-custom {
            background: linear-gradient(135deg, var(--primary-teal) 0%, var(--primary-light) 100%);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
        }

        .bg-cream {
            background: var(--cream);
        }

        .text-primary-teal {
            color: var(--primary-teal);
        }

        .text-accent {
            color: var(--accent-orange);
        }
    </style>
    @stack('styles')
</head>

<body>
    @yield('content')

    <!-- Footer -->
    <footer class="py-5 mt-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="fw-bold mb-3">Koperasi Amanah BPS Kota Surabaya</h5>
                    <p class="opacity-75 mb-0">Membangun kesejahteraan anggota melalui layanan koperasi yang amanah dan profesional dengan teknologi
                        terkini.</p>
                </div>
                <div class="col-lg-3 offset-lg-1">
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
