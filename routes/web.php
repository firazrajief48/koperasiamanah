<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PeminjamController;
use App\Http\Controllers\BendaharaKantorController;
use App\Http\Controllers\BendaharaKoperasiController;
use App\Http\Controllers\KepalaKoperasiController;
use App\Http\Controllers\AdminController;

// Landing Page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Authentication Routes (popup in landing page)
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Download PDF
Route::get('/download-pdf/{filename}', function ($filename) {
    $path = public_path('pdf/' . $filename);
    if (file_exists($path)) {
        return response()->download($path);
    }
    abort(404);
})->name('download.pdf');

// Peminjam Routes (protected)
Route::prefix('peminjam')->name('peminjam.')->middleware(['auth', 'role:peminjam'])->group(function () {
    Route::get('/dashboard', [PeminjamController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [PeminjamController::class, 'profile'])->name('profile');
    Route::get('/ajukan-pinjaman', [PeminjamController::class, 'ajukanPinjaman'])->name('ajukan');
    Route::get('/riwayat-pinjaman', [PeminjamController::class, 'riwayatPinjaman'])->name('riwayat');
    Route::get('/transparansi', [PeminjamController::class, 'transparansi'])->name('transparansi');
});

// Kepala BPS Routes (protected)
Route::prefix('kepala-bps')->name('kepala_bps.')->middleware(['auth', 'role:kepala_bps'])->group(function () {
    Route::get('/dashboard', [BendaharaKantorController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [BendaharaKantorController::class, 'profile'])->name('profile');
    Route::get('/detail-pengajuan/{id}', [BendaharaKantorController::class, 'detailPengajuan'])->name('detail');
    Route::get('/laporan-pinjaman', [BendaharaKantorController::class, 'laporanPinjaman'])->name('laporan');
    Route::get('/transparansi', [BendaharaKantorController::class, 'transparansi'])->name('transparansi');
});

// Redirect old bendahara-kantor URLs to new kepala-bps URLs
Route::redirect('/bendahara-kantor', '/kepala-bps');
Route::redirect('/bendahara-kantor/{any}', '/kepala-bps/{any}')->where('any', '.*');

// Bendahara Koperasi Routes (protected)
Route::prefix('bendahara-koperasi')->name('bendahara_koperasi.')->middleware(['auth', 'role:bendahara_koperasi'])->group(function () {
    Route::get('/dashboard', [BendaharaKoperasiController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [BendaharaKoperasiController::class, 'profile'])->name('profile');
    Route::get('/detail-pengajuan/{id}', [BendaharaKoperasiController::class, 'detailPengajuan'])->name('detail');
    Route::get('/laporan-pinjaman', [BendaharaKoperasiController::class, 'laporanPinjaman'])->name('laporan');
    Route::get('/transparansi', [BendaharaKoperasiController::class, 'transparansi'])->name('transparansi');
    Route::get('/iuran-pegawai', [BendaharaKoperasiController::class, 'kelolaIuran'])->name('iuran_pegawai');
});

// Legacy redirects: keep old kepala-koperasi URLs working -> ketua-koperasi
Route::redirect('/kepala-koperasi', '/ketua-koperasi');
Route::redirect('/kepala-koperasi/{any}', '/ketua-koperasi/{any}')->where('any', '.*');

// Ketua Koperasi Routes (protected)
Route::prefix('ketua-koperasi')->name('ketua_koperasi.')->middleware(['auth', 'role:ketua_koperasi'])->group(function () {
    Route::get('/dashboard', [KepalaKoperasiController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [KepalaKoperasiController::class, 'profile'])->name('profile');
    Route::get('/detail-pengajuan/{id}', [KepalaKoperasiController::class, 'detailPengajuan'])->name('detail');
    Route::get('/laporan-pinjaman', [KepalaKoperasiController::class, 'laporanPinjaman'])->name('laporan');
    Route::get('/transparansi', [KepalaKoperasiController::class, 'transparansi'])->name('transparansi');
});

// Administrator Routes (protected)
Route::prefix('administrator')->name('administrator.')->middleware(['auth', 'role:administrator'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::get('/kelola-user', [AdminController::class, 'kelolaUser'])->name('kelola-user');
    Route::get('/tambah-user', [AdminController::class, 'tambahUser'])->name('tambah-user');
    Route::post('/store-user', [AdminController::class, 'storeUser'])->name('store-user');
    Route::get('/detail-user/{id}', [AdminController::class, 'detailUser'])->name('detail-user');
    Route::get('/edit-user/{id}', [AdminController::class, 'editUser'])->name('edit-user');
    Route::put('/update-user/{id}', [AdminController::class, 'updateUser'])->name('update-user');
    Route::delete('/delete-user/{id}', [AdminController::class, 'deleteUser'])->name('delete-user');
    Route::get('/laporan-user', [AdminController::class, 'laporanUser'])->name('laporan-user');
    Route::get('/transparansi', [AdminController::class, 'transparansi'])->name('transparansi');
});
