@extends('layouts.app')

@section('title', 'Koperasi Amanah BPS Kota Surabaya - Beranda')

@section('content')
    <style>
        .table-responsive::-webkit-scrollbar {
            height: 6px;
        }
        .table-responsive::-webkit-scrollbar-thumb {
            background-color: rgba(0,0,0,0.1);
            border-radius: 3px;
        }
        .table-responsive::-webkit-scrollbar-track {
            background-color: rgba(0,0,0,0.05);
        }
    </style>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <div class="icon-box me-2" style="width: 40px; height: 40px; border-radius: 8px;">
                    <i class="bi bi-bank2 text-white fs-6"></i>
                </div>
                <span class="fs-6 fw-semibold">Koperasi Amanah</span>
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
                        <button class="btn btn-light btn-sm px-4 py-2 rounded-pill w-100" data-bs-toggle="modal" data-bs-target="#loginModal">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="beranda" class="gradient-bg text-white" style="padding-top: 160px; padding-bottom: 60px;">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="badge-custom text-white mb-3" style="font-size: 0.875rem;">
                        <i class="bi bi-stars me-2"></i>Platform Koperasi Digital
                    </div>
                    <h1 class="display-4 fw-bold mb-3" style="line-height: 1.2; font-size: clamp(2rem, 5vw, 3rem);">
                        Koperasi Amanah BPS Kota Surabaya
                    </h1>
                    <p class="fs-5 mb-4 opacity-90" style="line-height: 1.6;">
                        {{ $profil['deskripsi'] ?? 'Wujudkan impian finansial Anda bersama koperasi yang terpercaya dan transparan. Layanan modern untuk kesejahteraan bersama.' }}
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <button class="btn btn-accent btn-lg px-4 py-3 rounded-pill shadow-lg" data-bs-toggle="modal" data-bs-target="#loginModal"
                            style="font-weight: 600; font-size: 1rem;">
                            Mulai Sekarang
                            <i class="bi bi-arrow-right ms-2"></i>
                        </button>
                        <button class="btn btn-outline-custom btn-lg px-4 py-3 rounded-pill" style="font-size: 1rem;"
                            onclick="document.getElementById('tentang').scrollIntoView({behavior: 'smooth'})">
                            Pelajari Lebih Lanjut
                        </button>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="position-relative">
                        <img src="{{ asset('images/hero.webp') }}" alt="Hero Koperasi" class="img-fluid rounded-4 shadow-lg">
                        <div class="position-absolute bottom-0 start-0 m-3 bg-white rounded-3 p-3 shadow-lg" style="max-width: 220px;">
                            <div class="d-flex align-items-center">
                                <div class="icon-box me-3" style="width: 45px; height: 45px;">
                                    <i class="bi bi-people-fill text-white fs-6"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0 fw-bold text-primary-teal" style="font-size: 1.25rem;">500+</h5>
                                    <small class="text-muted" style="font-size: 0.813rem;">Anggota Aktif</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card-modern p-4 h-100 text-center transition-all">
                        <div class="icon-box mx-auto mb-3" style="width: 70px; height: 70px;">
                            <i class="bi bi-lightning-charge-fill text-white fs-3"></i>
                        </div>
                        <h5 class="fw-bold mb-3" style="font-size: 1.125rem;">Proses Cepat</h5>
                        <p class="text-muted mb-0" style="font-size: 0.938rem; line-height: 1.6;">Pengajuan dan pencairan dana yang efisien dengan sistem digital terintegrasi</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-modern p-4 h-100 text-center transition-all">
                        <div class="icon-box mx-auto mb-3" style="width: 70px; height: 70px;">
                            <i class="bi bi-shield-fill-check text-white fs-3"></i>
                        </div>
                        <h5 class="fw-bold mb-3" style="font-size: 1.125rem;">Aman & Terpercaya</h5>
                        <p class="text-muted mb-0" style="font-size: 0.938rem; line-height: 1.6;">Keamanan data terjamin dengan enkripsi tingkat tinggi dan transparansi penuh</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-modern p-4 h-100 text-center transition-all">
                        <div class="icon-box mx-auto mb-3" style="width: 70px; height: 70px;">
                            <i class="bi bi-headset text-white fs-3"></i>
                        </div>
                        <h5 class="fw-bold mb-3" style="font-size: 1.125rem;">Dukungan 24/7</h5>
                        <p class="text-muted mb-0" style="font-size: 0.938rem; line-height: 1.6;">Tim customer service siap membantu Anda kapan saja dengan respon cepat</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Visi Misi Section -->
    <section id="tentang" class="py-5 bg-white">
        <div class="container py-4">
            <div class="text-center mb-5">
                <h2 class="display-6 fw-bold gradient-text mb-3">Visi & Misi</h2>
                <div class="section-divider mx-auto mb-3"></div>
                <p class="text-muted fs-6">Komitmen kami untuk memberikan layanan terbaik</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="card-modern p-4 h-100" style="border-left: 4px solid var(--primary-teal);">
                        <div class="d-flex align-items-start mb-3">
                            <div class="icon-box me-3" style="width: 55px; height: 55px;">
                                <i class="bi bi-eye-fill text-white fs-4"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-3" style="font-size: 1.375rem;">Visi Kami</h4>
                                <p class="text-muted mb-0" style="font-size: 0.938rem; line-height: 1.7;">
                                    {{ $profil['visi'] ?? 'Menjadi koperasi terdepan yang memberikan pelayanan prima, inovatif, dan membawa kesejahteraan berkelanjutan bagi seluruh anggota dengan teknologi digital terkini.' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card-modern p-4 h-100" style="border-left: 4px solid var(--accent-orange);">
                        <div class="d-flex align-items-start mb-3">
                            <div class="icon-box me-3" style="width: 55px; height: 55px; background: linear-gradient(135deg, var(--accent-orange) 0%, #ff7028 100%);">
                                <i class="bi bi-bullseye text-white fs-4"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h4 class="fw-bold mb-3" style="font-size: 1.375rem;">Misi Kami</h4>
                                @if (isset($profil['misi']) && is_array($profil['misi']))
                                    <div class="d-flex flex-column gap-3">
                                        @foreach ($profil['misi'] as $index => $misi)
                                            <div class="d-flex align-items-start">
                                                <div class="badge-custom me-3 flex-shrink-0"
                                                    style="min-width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 0.813rem;">
                                                    {{ $index + 1 }}
                                                </div>
                                                <p class="text-muted mb-0" style="font-size: 0.938rem; line-height: 1.7;">{{ $misi }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="d-flex flex-column gap-3">
                                        <div class="d-flex align-items-start">
                                            <div class="badge-custom me-3 flex-shrink-0"
                                                style="min-width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 0.813rem;">
                                                1</div>
                                            <p class="text-muted mb-0" style="font-size: 0.938rem; line-height: 1.7;">Memberikan layanan keuangan yang amanah, profesional dan berbasis teknologi
                                            </p>
                                        </div>
                                        <div class="d-flex align-items-start">
                                            <div class="badge-custom me-3 flex-shrink-0"
                                                style="min-width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 0.813rem;">
                                                2</div>
                                            <p class="text-muted mb-0" style="font-size: 0.938rem; line-height: 1.7;">Meningkatkan kesejahteraan anggota secara berkelanjutan dan inklusif</p>
                                        </div>
                                        <div class="d-flex align-items-start">
                                            <div class="badge-custom me-3 flex-shrink-0"
                                                style="min-width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 0.813rem;">
                                                3</div>
                                            <p class="text-muted mb-0" style="font-size: 0.938rem; line-height: 1.7;">Menerapkan prinsip koperasi dengan transparan, akuntabel dan digital</p>
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

    <!-- Tabel Pinjaman & Angsuran -->
    <div class="container py-5">
        <div class="text-center mb-4">
            <h2 class="fw-bold mb-3" style="font-size: 1.75rem;">Tabel Pinjaman & Angsuran</h2>
            <p class="text-muted" style="font-size: 0.938rem;">Simulasi angsuran berdasarkan jumlah pinjaman dan tenor yang dipilih</p>
        </div>

        <div class="alert alert-info mb-4" style="border-radius: 12px;">
            <h6 class="fw-bold mb-2"><i class="bi bi-info-circle me-2"></i>Informasi Penting</h6>
            <ul class="mb-0" style="font-size: 0.938rem;">
                <li>Biaya Administrasi: <strong>5%</strong> dari jumlah pinjaman</li>
                <li>Bunga: <strong>0%</strong> (Tanpa bunga)</li>
                <li>Metode: Pemotongan gaji otomatis atau transfer manual</li>
            </ul>
        </div>

                <div class="table-responsive" style="border-radius: 12px; overflow-x: auto; -webkit-overflow-scrolling: touch; box-shadow: 0 2px 12px rgba(0,0,0,0.08);">
            <table class="table table-bordered table-hover mb-0" style="font-size: 0.875rem; min-width: 1200px; white-space: nowrap;">
                <thead>
                    <tr class="table-primary text-center">
                        <th colspan="12">Besar Pinjaman</th>
                    </tr>
                    <tr class="table-light">
                        <th></th>
                        <th>3,000,000</th>
                        <th>3,500,000</th>
                        <th>4,000,000</th>
                        <th>4,500,000</th>
                        <th>5,000,000</th>
                        <th>5,500,000</th>
                        <th>6,000,000</th>
                        <th>7,000,000</th>
                        <th>8,000,000</th>
                        <th>9,000,000</th>
                        <th>10,000,000</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <tr class="table-secondary">
                        <td>Adm 5%</td>
                        <td>150,000</td>
                        <td>175,000</td>
                        <td>200,000</td>
                        <td>225,000</td>
                        <td>250,000</td>
                        <td>275,000</td>
                        <td>300,000</td>
                        <td>350,000</td>
                        <td>400,000</td>
                        <td>450,000</td>
                        <td>500,000</td>
                    </tr>
                    <tr class="table-info">
                        <td>Terima</td>
                        <td>2,850,000</td>
                        <td>3,325,000</td>
                        <td>3,800,000</td>
                        <td>4,275,000</td>
                        <td>4,750,000</td>
                        <td>5,225,000</td>
                        <td>5,700,000</td>
                        <td>6,650,000</td>
                        <td>7,600,000</td>
                        <td>8,550,000</td>
                        <td>9,500,000</td>
                    </tr>
                    <tr class="table-primary">
                        <td colspan="12" class="text-center fw-bold">Angsuran</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>1,500,000</td>
                        <td>1,750,000</td>
                        <td>2,000,000</td>
                        <td>2,250,000</td>
                        <td>2,500,000</td>
                        <td>2,750,000</td>
                        <td>3,000,000</td>
                        <td>3,500,000</td>
                        <td>4,000,000</td>
                        <td>4,500,000</td>
                        <td>5,000,000</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>1,000,000</td>
                        <td>1,166,667</td>
                        <td>1,333,333</td>
                        <td>1,500,000</td>
                        <td>1,666,667</td>
                        <td>1,833,333</td>
                        <td>2,000,000</td>
                        <td>2,333,333</td>
                        <td>2,666,667</td>
                        <td>3,000,000</td>
                        <td>3,333,333</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>750,000</td>
                        <td>875,000</td>
                        <td>1,000,000</td>
                        <td>1,125,000</td>
                        <td>1,250,000</td>
                        <td>1,375,000</td>
                        <td>1,500,000</td>
                        <td>1,750,000</td>
                        <td>2,000,000</td>
                        <td>2,250,000</td>
                        <td>2,500,000</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>600,000</td>
                        <td>700,000</td>
                        <td>800,000</td>
                        <td>900,000</td>
                        <td>1,000,000</td>
                        <td>1,100,000</td>
                        <td>1,200,000</td>
                        <td>1,400,000</td>
                        <td>1,600,000</td>
                        <td>1,800,000</td>
                        <td>2,000,000</td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td class="table-secondary">-</td>
                        <td>583,333</td>
                        <td>666,667</td>
                        <td>750,000</td>
                        <td>833,333</td>
                        <td>916,667</td>
                        <td>1,000,000</td>
                        <td>1,166,667</td>
                        <td>1,333,333</td>
                        <td>1,500,000</td>
                        <td>1,666,667</td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td class="table-secondary">-</td>
                        <td>500,000</td>
                        <td>571,429</td>
                        <td>642,857</td>
                        <td>714,286</td>
                        <td>785,714</td>
                        <td>857,143</td>
                        <td>1,000,000</td>
                        <td>1,142,857</td>
                        <td>1,285,714</td>
                        <td>1,428,571</td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td>500,000</td>
                        <td>562,500</td>
                        <td>625,000</td>
                        <td>687,500</td>
                        <td>750,000</td>
                        <td>875,000</td>
                        <td>1,000,000</td>
                        <td>1,125,000</td>
                        <td>1,250,000</td>
                    </tr>
                    <tr>
                        <td>9</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td>500,000</td>
                        <td>555,556</td>
                        <td>611,111</td>
                        <td>666,667</td>
                        <td>777,778</td>
                        <td>888,889</td>
                        <td>1,000,000</td>
                        <td>1,111,111</td>
                    </tr>
                    <tr>
                        <td>10</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td>500,000</td>
                        <td>550,000</td>
                        <td>600,000</td>
                        <td>700,000</td>
                        <td>800,000</td>
                        <td>900,000</td>
                        <td>1,000,000</td>
                    </tr>
                    <tr>
                        <td>11</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td>500,000</td>
                        <td>545,455</td>
                        <td>636,364</td>
                        <td>727,273</td>
                        <td>818,182</td>
                        <td>909,091</td>
                    </tr>
                    <tr>
                        <td>12</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td>500,000</td>
                        <td>583,333</td>
                        <td>666,667</td>
                        <td>750,000</td>
                        <td>833,333</td>
                    </tr>
                    <tr>
                        <td>15</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td>466,667</td>
                        <td>533,333</td>
                        <td>600,000</td>
                        <td>666,667</td>
                    </tr>
                    <tr>
                        <td>16</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td>500,000</td>
                        <td>562,500</td>
                        <td>625,000</td>
                    </tr>
                    <tr>
                        <td>17</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td>529,412</td>
                        <td>588,235</td>
                    </tr>
                    <tr>
                        <td>18</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td>500,000</td>
                        <td>555,556</td>
                    </tr>
                    <tr>
                        <td>19</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td>526,316</td>
                    </tr>
                    <tr>
                        <td>20</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td class="table-secondary">-</td>
                        <td>500,000</td>
                    </tr>
                <tbody>
            </table>
        </div>

        <div class="alert alert-warning mt-4" style="border-radius: 12px;">
            <h6 class="fw-bold mb-2"><i class="bi bi-exclamation-triangle me-2"></i>Catatan Penting</h6>
            <p class="mb-0" style="font-size: 0.938rem;">Angsuran dalam Rupiah per bulan. Tanda (-) berarti kombinasi tidak tersedia.</p>
        </div>
    </div>

    <!-- Susunan Pengurus -->
    <section id="pengurus" class="py-5 bg-cream">
        <div class="container py-4">
            <div class="text-center mb-5">
                <h2 class="display-6 fw-bold gradient-text mb-3">Pengurus Koperasi</h2>
                <div class="section-divider mx-auto mb-3"></div>
                <p class="text-muted fs-6">Tim profesional yang berpengalaman dan berdedikasi</p>
            </div>
            <div class="row g-4">
                @if (isset($staf) && count($staf) > 0)
                    @foreach ($staf as $s)
                        <div class="col-md-6 col-lg-4">
                            <div class="card-modern p-4 h-100 text-center transition-all">
                                <div class="position-relative d-inline-block mb-3">
                                    <img src="{{ $s['foto'] }}" class="rounded-circle shadow-lg" alt="{{ $s['nama'] }}"
                                        style="width: 120px; height: 120px; object-fit: cover; border: 4px solid white;">
                                    <div class="position-absolute bottom-0 end-0 rounded-circle"
                                        style="width: 20px; height: 20px; border: 3px solid white; background: var(--primary-teal);"></div>
                                </div>
                                <h5 class="fw-bold mb-2" style="font-size: 1.125rem;">{{ $s['nama'] }}</h5>
                                <div class="badge-custom d-inline-block mb-2" style="font-size: 0.813rem;">{{ $s['jabatan'] }}</div>
                                <p class="text-muted small mb-0" style="font-size: 0.875rem;">Siap melayani dengan sepenuh hati</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-md-6 col-lg-4">
                        <div class="card-modern p-4 h-100 text-center transition-all">
                            <div class="position-relative d-inline-block mb-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                    style="width: 120px; height: 120px; background: linear-gradient(135deg, var(--primary-teal) 0%, var(--primary-light) 100%);">
                                    <i class="bi bi-person text-white" style="font-size: 3.5rem;"></i>
                                </div>
                                <div class="position-absolute bottom-0 end-0 rounded-circle"
                                    style="width: 20px; height: 20px; border: 3px solid white; background: var(--primary-teal);"></div>
                            </div>
                            <h5 class="fw-bold mb-2" style="font-size: 1.125rem;">Ahmad Budi Santoso</h5>
                            <div class="badge-custom d-inline-block mb-2" style="font-size: 0.813rem;">Ketua Koperasi</div>
                            <p class="text-muted small mb-0" style="font-size: 0.875rem;">Memimpin dengan integritas dan dedikasi</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card-modern p-4 h-100 text-center transition-all">
                            <div class="position-relative d-inline-block mb-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                    style="width: 120px; height: 120px; background: linear-gradient(135deg, var(--primary-teal) 0%, var(--primary-light) 100%);">
                                    <i class="bi bi-person text-white" style="font-size: 3.5rem;"></i>
                                </div>
                                <div class="position-absolute bottom-0 end-0 rounded-circle"
                                    style="width: 20px; height: 20px; border: 3px solid white; background: var(--primary-teal);"></div>
                            </div>
                            <h5 class="fw-bold mb-2" style="font-size: 1.125rem;">Siti Nur Azizah</h5>
                            <div class="badge-custom d-inline-block mb-2" style="font-size: 0.813rem;">Bendahara Koperasi</div>
                            <p class="text-muted small mb-0" style="font-size: 0.875rem;">Mengelola keuangan dengan cermat</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card-modern p-4 h-100 text-center transition-all">
                            <div class="position-relative d-inline-block mb-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                    style="width: 120px; height: 120px; background: linear-gradient(135deg, var(--primary-teal) 0%, var(--primary-light) 100%);">
                                    <i class="bi bi-person text-white" style="font-size: 3.5rem;"></i>
                                </div>
                                <div class="position-absolute bottom-0 end-0 rounded-circle"
                                    style="width: 20px; height: 20px; border: 3px solid white; background: var(--primary-teal);"></div>
                            </div>
                            <h5 class="fw-bold mb-2" style="font-size: 1.125rem;">Rina Pratiwi</h5>
                            <div class="badge-custom d-inline-block mb-2" style="font-size: 0.813rem;">Sekretaris Koperasi</div>
                            <p class="text-muted small mb-0" style="font-size: 0.875rem;">Mengorganisir dengan profesional</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="gradient-bg text-white py-5">
        <div class="container py-4 text-center">
            <h2 class="display-6 fw-bold mb-3">Siap Bergabung dengan Kami?</h2>
            <p class="fs-6 mb-4 opacity-90" style="line-height: 1.6;">Daftarkan diri Anda sekarang dan nikmati berbagai kemudahan layanan koperasi digital</p>
            <button class="btn btn-accent btn-lg px-5 py-3 rounded-pill shadow-lg" data-bs-toggle="modal" data-bs-target="#loginModal"
                style="font-weight: 600; font-size: 1rem;">
                Daftar Sekarang
                <i class="bi bi-arrow-right ms-2"></i>
            </button>
        </div>
    </section>

    <!-- Modal Login -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content" style="border-radius: 20px; border: none; overflow: hidden;">
                <div class="row g-0">
                    <!-- Left Side - Image/Branding -->
                    <div class="col-md-5 gradient-bg text-white p-4 p-md-5 d-none d-md-flex flex-column justify-content-center">
                        <div class="icon-box mb-4" style="width: 60px; height: 60px;">
                            <i class="bi bi-bank2 text-white fs-2"></i>
                        </div>
                        <h4 class="fw-bold mb-3" style="font-size: 1.5rem;">Selamat Datang</h4>
                        <p class="opacity-90 mb-4" style="font-size: 0.938rem; line-height: 1.6;">Akses akun Anda untuk menikmati berbagai layanan koperasi digital yang mudah dan aman</p>
                        <div class="mt-auto">
                            <p class="small opacity-75 mb-0" style="font-size: 0.813rem;">© 2025 Koperasi Amanah</p>
                        </div>
                    </div>

                    <!-- Right Side - Form -->
                    <div class="col-md-7">
                        <div class="p-4 p-md-5">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="fw-bold mb-0" style="font-size: 1.25rem;">Akses Akun</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <ul class="nav nav-pills mb-4" role="tablist">
                                <li class="nav-item flex-fill" role="presentation">
                                    <button class="nav-link active w-100 rounded-pill" id="login-tab" data-bs-toggle="tab" data-bs-target="#login"
                                        type="button" role="tab" style="font-size: 0.938rem; padding: 0.625rem 1rem;">
                                        Login
                                    </button>
                                </li>
                                <li class="nav-item flex-fill" role="presentation">
                                    <button class="nav-link w-100 rounded-pill" id="register-tab" data-bs-toggle="tab" data-bs-target="#register"
                                        type="button" role="tab" style="font-size: 0.938rem; padding: 0.625rem 1rem;">
                                        Register
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <!-- Login Tab -->
                                <div class="tab-pane fade show active" id="login" role="tabpanel">
                                    <form id="loginForm">
                                        <div class="mb-3">
                                            <label for="loginEmail" class="form-label fw-semibold" style="font-size: 0.938rem;">Email / Username</label>
                                            <input type="text" class="form-control form-control-lg" id="loginEmail"
                                                placeholder="Masukkan email atau username" required
                                                style="border-radius: 10px; padding: 0.75rem 1rem; font-size: 0.938rem;">
                                        </div>
                                        <div class="mb-3">
                                            <label for="loginPassword" class="form-label fw-semibold" style="font-size: 0.938rem;">Password</label>
                                            <input type="password" class="form-control form-control-lg" id="loginPassword"
                                                placeholder="Masukkan password" required style="border-radius: 10px; padding: 0.75rem 1rem; font-size: 0.938rem;">
                                        </div>
                                        <div class="mb-4">
                                            <label for="roleSelect" class="form-label fw-semibold" style="font-size: 0.938rem;">Login Sebagai</label>
                                            <select class="form-select form-select-lg" id="roleSelect"
                                                style="border-radius: 10px; padding: 0.75rem 1rem; font-size: 0.938rem;">
                                                <option value="peminjam">Peminjam</option>
                                                <option value="bendahara-kantor">Bendahara Kantor</option>
                                                <option value="bendahara-koperasi">Bendahara Koperasi</option>
                                                <option value="kepala-koperasi">Kepala Koperasi</option>
                                            </select>
                                        </div>
                                        <button type="button" class="btn btn-primary-custom w-100 btn-lg mb-3" onclick="doLogin()"
                                            style="padding: 0.75rem; font-size: 1rem; border-radius: 10px;">
                                            Login Sekarang
                                        </button>
                                        <div class="text-center">
                                            <small class="text-muted" style="font-size: 0.875rem;">Lupa password? <a href="#"
                                                    class="text-decoration-none fw-semibold text-primary-teal">Reset di sini</a></small>
                                        </div>
                                    </form>
                                </div>

                                <!-- Register Tab -->
                                <div class="tab-pane fade" id="register" role="tabpanel">
                                    <form id="registerForm">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label for="regNama" class="form-label fw-semibold" style="font-size: 0.938rem;">Nama Lengkap</label>
                                                <input type="text" class="form-control" id="regNama"
                                                    placeholder="Nama lengkap Anda" required style="border-radius: 10px; padding: 0.625rem 1rem; font-size: 0.938rem;">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="regNip" class="form-label fw-semibold" style="font-size: 0.938rem;">NIP</label>
                                                <input type="text" class="form-control" id="regNip"
                                                    placeholder="Nomor Induk Pegawai" required style="border-radius: 10px; padding: 0.625rem 1rem; font-size: 0.938rem;">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="regGolongan" class="form-label fw-semibold" style="font-size: 0.938rem;">Golongan</label>
                                                <input type="text" class="form-control" id="regGolongan" placeholder="Golongan"
                                                    required style="border-radius: 10px; padding: 0.625rem 1rem; font-size: 0.938rem;">
                                            </div>
                                            <div class="col-12">
                                                <label for="regJabatan" class="form-label fw-semibold" style="font-size: 0.938rem;">Jabatan</label>
                                                <input type="text" class="form-control" id="regJabatan" placeholder="Jabatan Anda"
                                                    required style="border-radius: 10px; padding: 0.625rem 1rem; font-size: 0.938rem;">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="regHp" class="form-label fw-semibold" style="font-size: 0.938rem;">No HP</label>
                                                <input type="tel" class="form-control" id="regHp" placeholder="08xxxxxxxxxx"
                                                    required style="border-radius: 10px; padding: 0.625rem 1rem; font-size: 0.938rem;">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="regEmail" class="form-label fw-semibold" style="font-size: 0.938rem;">Email</label>
                                                <input type="email" class="form-control" id="regEmail"
                                                    placeholder="email@example.com" required style="border-radius: 10px; padding: 0.625rem 1rem; font-size: 0.938rem;">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="regPassword" class="form-label fw-semibold" style="font-size: 0.938rem;">Password</label>
                                                <input type="password" class="form-control" id="regPassword"
                                                    placeholder="Min. 8 karakter" required style="border-radius: 10px; padding: 0.625rem 1rem; font-size: 0.938rem;">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="regConfirmPassword" class="form-label fw-semibold" style="font-size: 0.938rem;">Konfirmasi Password</label>
                                                <input type="password" class="form-control" id="regConfirmPassword"
                                                    placeholder="Ulangi password" required style="border-radius: 10px; padding: 0.625rem 1rem; font-size: 0.938rem;">
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
        function doLogin() {
            const role = document.getElementById('roleSelect').value;
            // Simulasi login - ganti dengan AJAX request untuk production
            window.location.href = '/' + role + '/dashboard';
        }

        // Form validation untuk register
        document.getElementById('registerForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const password = document.getElementById('regPassword').value;
            const confirmPassword = document.getElementById('regConfirmPassword').value;

            if (password.length < 8) {
                alert('Password minimal 8 karakter!');
                return;
            }

            if (password !== confirmPassword) {
                alert('Password dan Konfirmasi Password tidak sama!');
                return;
            }

            // Submit form - ganti dengan AJAX request untuk production
            alert('Registrasi berhasil! Silakan login dengan akun Anda.');
            document.getElementById('login-tab').click();
            document.getElementById('registerForm').reset();
        });

        // Smooth scroll untuk navbar fixed
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

        // Navbar background on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.boxShadow = '0 4px 30px rgba(8, 56, 69, 0.3)';
            } else {
                navbar.style.boxShadow = '0 4px 20px rgba(8, 56, 69, 0.15)';
            }
        });

        // Add hover effects to cards
        document.querySelectorAll('.card-modern').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
                this.style.transition = 'all 0.3s ease';
            });
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Auto close mobile menu on link click
        document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
            link.addEventListener('click', function() {
                const navbarCollapse = document.getElementById('navbarNav');
                if (navbarCollapse.classList.contains('show')) {
                    const bsCollapse = new bootstrap.Collapse(navbarCollapse);
                    bsCollapse.hide();
                }
            });
        });
    </script>
@endpush