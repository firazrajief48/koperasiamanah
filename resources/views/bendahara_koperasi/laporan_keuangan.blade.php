@extends('layouts.dashboard')

@section('title', 'Laporan Keuangan')
@section('page-title', 'Laporan Keuangan')

@php
    $role = 'Bendahara Koperasi';
    $nama = auth()->user()->name;
    $routePrefix = 'bendahara_koperasi';
    $showLaporan = true;
@endphp

@section('main-content')
    <style>
        :root {
            --primary-blue: #1e40af;
            --primary-light: #3b82f6;
            --accent-orange: #f97316;
            --dark-navy: #0f172a;
            --success-green: #10b981;
            --gradient-1: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-2: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --gradient-3: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        body {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0e7ff 100%);
            min-height: 100vh;
        }

        /* Page Header dengan animasi */
        .page-header-modern {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #6366f1 100%);
            border-radius: 24px;
            padding: 2rem 2.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 20px 60px rgba(30, 64, 175, 0.25);
            animation: slideDown 0.8s ease-out;
            position: relative;
            overflow: hidden;
        }

        .page-header-modern::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            animation: pulse 4s ease-in-out infinite;
        }

        .page-header-modern::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.08) 0%, transparent 70%);
            border-radius: 50%;
            animation: pulse 3s ease-in-out infinite reverse;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                opacity: 0.5;
            }
            50% {
                transform: scale(1.2);
                opacity: 0.8;
            }
        }

        .page-header-modern .icon-box {
            width: 64px;
            height: 64px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        .page-header-modern h2 {
            color: white;
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            text-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 1;
        }

        .page-header-modern small {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1rem;
            font-weight: 400;
            position: relative;
            z-index: 1;
        }

        /* Embed Container dengan styling modern dan menarik */
        .embed-container {
            background: white;
            border-radius: 28px;
            box-shadow: 0 25px 80px rgba(30, 64, 175, 0.2), 0 0 0 1px rgba(59, 130, 246, 0.1);
            overflow: hidden;
            animation: fadeInUp 0.8s ease-out 0.2s both;
            position: relative;
            border: 2px solid rgba(59, 130, 246, 0.15);
            transition: all 0.3s ease;
        }

        .embed-container:hover {
            box-shadow: 0 30px 100px rgba(30, 64, 175, 0.25), 0 0 0 1px rgba(59, 130, 246, 0.2);
            transform: translateY(-4px);
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

        .embed-header {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 50%, #f1f5f9 100%);
            padding: 2rem 2.5rem;
            border-bottom: 3px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .embed-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 6px;
            height: 100%;
            background: linear-gradient(135deg, #3b82f6 0%, #6366f1 50%, #8b5cf6 100%);
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.5);
        }

        .embed-header::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .embed-header h3 {
            color: var(--dark-navy);
            font-size: 1.625rem;
            font-weight: 800;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 1rem;
            position: relative;
            z-index: 1;
            letter-spacing: -0.5px;
        }

        .embed-header h3 i {
            color: var(--primary-blue);
            font-size: 2rem;
            filter: drop-shadow(0 2px 4px rgba(59, 130, 246, 0.3));
            animation: iconPulse 2s ease-in-out infinite;
        }

        @keyframes iconPulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        .embed-header .badge-live {
            background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%);
            color: white;
            padding: 0.625rem 1.25rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.625rem;
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4), 0 0 0 2px rgba(255, 255, 255, 0.2);
            animation: pulse-badge 2s ease-in-out infinite;
            position: relative;
            z-index: 1;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            font-size: 0.75rem;
        }

        @keyframes pulse-badge {
            0%, 100% {
                box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4), 0 0 0 2px rgba(255, 255, 255, 0.2);
                transform: scale(1);
            }
            50% {
                box-shadow: 0 8px 30px rgba(16, 185, 129, 0.6), 0 0 0 4px rgba(255, 255, 255, 0.3);
                transform: scale(1.05);
            }
        }

        .badge-live .dot {
            width: 10px;
            height: 10px;
            background: white;
            border-radius: 50%;
            display: inline-block;
            animation: blink 1.5s ease-in-out infinite;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
        }

        @keyframes blink {
            0%, 100% {
                opacity: 1;
                transform: scale(1);
            }
            50% {
                opacity: 0.4;
                transform: scale(0.8);
            }
        }

        .embed-wrapper {
            position: relative;
            width: 100%;
            height: calc(100vh - 350px);
            min-height: 650px;
            overflow: hidden;
            background: linear-gradient(135deg, #f8fafc 0%, #ffffff 50%, #f8fafc 100%);
            background-size: 200% 200%;
            animation: gradientShift 8s ease infinite;
        }

        @keyframes gradientShift {
            0%, 100% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
        }

        .embed-wrapper iframe {
            width: 100%;
            height: 100%;
            border: none;
            display: block;
            transform: scale(1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: inset 0 0 40px rgba(59, 130, 246, 0.05);
        }

        .embed-wrapper:hover iframe {
            transform: scale(1.002);
        }

        /* Decorative corner accents */
        .embed-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, transparent 100%);
            border-radius: 0 0 0 100%;
            z-index: 1;
            pointer-events: none;
        }

        .embed-wrapper::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 120px;
            height: 120px;
            background: linear-gradient(45deg, rgba(139, 92, 246, 0.1) 0%, transparent 100%);
            border-radius: 0 100% 0 0;
            z-index: 1;
            pointer-events: none;
        }

        /* Loading State */
        .embed-loading {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 50%, #e0e7ff 100%);
            background-size: 200% 200%;
            animation: gradientShift 3s ease infinite;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 10;
            transition: opacity 0.6s ease;
            backdrop-filter: blur(5px);
        }

        .embed-loading.hidden {
            opacity: 0;
            pointer-events: none;
        }

        .spinner-large {
            width: 72px;
            height: 72px;
            border: 5px solid rgba(59, 130, 246, 0.1);
            border-top-color: var(--primary-blue);
            border-right-color: #6366f1;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin-bottom: 2rem;
            box-shadow: 0 0 30px rgba(59, 130, 246, 0.3);
            position: relative;
        }

        .spinner-large::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 40px;
            height: 40px;
            border: 3px solid rgba(59, 130, 246, 0.1);
            border-bottom-color: #8b5cf6;
            border-radius: 50%;
            animation: spin 1.2s linear infinite reverse;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .embed-loading p {
            color: #475569;
            font-size: 1.125rem;
            font-weight: 600;
            margin: 0;
            letter-spacing: 0.5px;
            animation: fadeInOut 2s ease-in-out infinite;
        }

        @keyframes fadeInOut {
            0%, 100% {
                opacity: 0.6;
            }
            50% {
                opacity: 1;
            }
        }

        /* Info Cards */
        .info-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
            animation: fadeInUp 0.8s ease-out 0.4s both;
        }

        .info-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 8px 30px rgba(30, 64, 175, 0.12), 0 2px 8px rgba(0, 0, 0, 0.05);
            border: 2px solid transparent;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }

        .info-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: var(--gradient-1);
            transition: all 0.4s ease;
            box-shadow: 0 0 20px rgba(102, 126, 234, 0.5);
        }

        .info-card::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 150px;
            height: 150px;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            transition: all 0.4s ease;
        }

        .info-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 15px 50px rgba(30, 64, 175, 0.2), 0 5px 15px rgba(0, 0, 0, 0.1);
            border-color: rgba(59, 130, 246, 0.3);
        }

        .info-card:hover::before {
            width: 100%;
            opacity: 0.08;
        }

        .info-card:hover::after {
            transform: scale(1.5);
            opacity: 0.3;
        }

        .info-card-icon {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.25rem;
            font-size: 1.75rem;
            position: relative;
            z-index: 1;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .info-card:hover .info-card-icon {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .info-card-1 .info-card-icon {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .info-card-2 .info-card-icon {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        .info-card-3 .info-card-icon {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .info-card h4 {
            color: var(--dark-navy);
            font-size: 1.125rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            position: relative;
            z-index: 1;
            letter-spacing: -0.3px;
        }

        .info-card p {
            color: #64748b;
            font-size: 0.938rem;
            margin: 0;
            line-height: 1.7;
            position: relative;
            z-index: 1;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-header-modern {
                padding: 1.5rem 1.5rem;
                border-radius: 16px;
            }

            .page-header-modern h2 {
                font-size: 1.5rem;
            }

            .embed-header {
                padding: 1rem 1.5rem;
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .embed-wrapper {
                height: calc(100vh - 400px);
                min-height: 500px;
            }

            .info-cards {
                grid-template-columns: 1fr;
            }
        }

        /* Scrollbar Styling */
        .embed-wrapper::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .embed-wrapper::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--primary-blue), var(--accent-orange));
            border-radius: 4px;
        }

        .embed-wrapper::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }
    </style>

    <!-- Page Header -->
    <div class="page-header-modern">
        <div class="d-flex align-items-center gap-4">
            <div class="icon-box">
                <i class="bi bi-graph-up-arrow text-white" style="font-size: 1.75rem;"></i>
            </div>
            <div>
                <h2>📊 Laporan Keuangan</h2>
                <small>Laporan keuangan koperasi secara real-time dan transparan</small>
            </div>
        </div>
    </div>

    <!-- Info Cards -->
    <div class="info-cards">
        <div class="info-card info-card-1">
            <div class="info-card-icon">
                <i class="bi bi-clock-history"></i>
            </div>
            <h4>Data Real-Time</h4>
            <p>Laporan keuangan diperbarui secara otomatis dan real-time dari Google Sheets untuk memastikan data selalu terkini.</p>
        </div>
        <div class="info-card info-card-2">
            <div class="info-card-icon">
                <i class="bi bi-shield-check"></i>
            </div>
            <h4>Transparan & Akurat</h4>
            <p>Setiap transaksi keuangan koperasi dicatat dengan detail dan dapat diakses oleh pengurus koperasi.</p>
        </div>
        <div class="info-card info-card-3">
            <div class="info-card-icon">
                <i class="bi bi-pie-chart"></i>
            </div>
            <h4>Analisis Visual</h4>
            <p>Visualisasi data yang mudah dipahami dengan grafik dan chart interaktif untuk analisis keuangan yang lebih baik.</p>
        </div>
    </div>

    <!-- Embed Container -->
    <div class="embed-container">
        <div class="embed-header">
            <h3>
                <i class="bi bi-file-earmark-spreadsheet-fill"></i>
                Spreadsheet Laporan Keuangan
            </h3>
            <span class="badge-live">
                <span class="dot"></span>
                Live Data
            </span>
        </div>
        <div class="embed-wrapper">
            <div class="embed-loading" id="embedLoading">
                <div class="spinner-large"></div>
                <p>Memuat laporan keuangan...</p>
            </div>
            <iframe 
                id="spreadsheetEmbed"
                src="https://docs.google.com/spreadsheets/d/e/2PACX-1vQr5C74fb56evMWYVYh6S8fjOpgM-bdIO67RtYAYIHTfYiad84pRM13ZJhSNSTrykDqnSHWyUl5exbO/pubhtml?widget=true&amp;headers=false"
                frameborder="0"
                allowfullscreen
                onload="hideLoading()">
            </iframe>
        </div>
    </div>

    @push('scripts')
        <script>
            function hideLoading() {
                const loading = document.getElementById('embedLoading');
                if (loading) {
                    setTimeout(() => {
                        loading.classList.add('hidden');
                        setTimeout(() => {
                            loading.style.display = 'none';
                        }, 500);
                    }, 500);
                }
            }

            // Fallback jika iframe tidak load dalam 10 detik
            setTimeout(() => {
                const loading = document.getElementById('embedLoading');
                if (loading && !loading.classList.contains('hidden')) {
                    loading.classList.add('hidden');
                    setTimeout(() => {
                        loading.style.display = 'none';
                    }, 500);
                }
            }, 10000);

            // Refresh embed setiap 30 detik untuk update real-time (optional)
            // setInterval(() => {
            //     const iframe = document.getElementById('spreadsheetEmbed');
            //     if (iframe) {
            //         iframe.src = iframe.src;
            //     }
            // }, 30000);
        </script>
    @endpush
@endsection

