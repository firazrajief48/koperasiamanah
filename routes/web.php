<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\BendaharaKantorController;
use App\Http\Controllers\BendaharaKoperasiController;
use App\Http\Controllers\KepalaKoperasiController;

// Landing Page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Download PDF
Route::get('/download-pdf/{filename}', function ($filename) {
    $path = public_path('pdf/' . $filename);
    if (file_exists($path)) {
        return response()->download($path);
    }
    abort(404);
})->name('download.pdf');

// Peminjam Routes
Route::prefix('anggota')->name('anggota.')->group(function () {
    Route::get('/dashboard', [AnggotaController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [AnggotaController::class, 'profile'])->name('profile');
    Route::get('/ajukan-pinjaman', [AnggotaController::class, 'ajukanPinjaman'])->name('ajukan');
    Route::get('/riwayat-pinjaman', [AnggotaController::class, 'riwayatPinjaman'])->name('riwayat');
    Route::get('/transparansi', [AnggotaController::class, 'transparansi'])->name('transparansi');
});

// Bendahara Kantor Routes
Route::prefix('bendahara-kantor')->name('bendahara_kantor.')->group(function () {
    Route::get('/dashboard', [BendaharaKantorController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [BendaharaKantorController::class, 'profile'])->name('profile');
    Route::get('/detail-pengajuan/{id}', [BendaharaKantorController::class, 'detailPengajuan'])->name('detail');
    Route::get('/laporan-pinjaman', [BendaharaKantorController::class, 'laporanPinjaman'])->name('laporan');
    Route::get('/transparansi', [BendaharaKantorController::class, 'transparansi'])->name('transparansi');
});

// Bendahara Koperasi Routes
Route::prefix('bendahara-koperasi')->name('bendahara_koperasi.')->group(function () {
    Route::get('/dashboard', [BendaharaKoperasiController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [BendaharaKoperasiController::class, 'profile'])->name('profile');
    Route::get('/detail-pengajuan/{id}', [BendaharaKoperasiController::class, 'detailPengajuan'])->name('detail');
    Route::get('/laporan-pinjaman', [BendaharaKoperasiController::class, 'laporanPinjaman'])->name('laporan');
    Route::get('/transparansi', [BendaharaKoperasiController::class, 'transparansi'])->name('transparansi');
});

// Kepala Koperasi Routes
Route::prefix('kepala-koperasi')->name('kepala_koperasi.')->group(function () {
    Route::get('/dashboard', [KepalaKoperasiController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [KepalaKoperasiController::class, 'profile'])->name('profile');
    Route::get('/detail-pengajuan/{id}', [KepalaKoperasiController::class, 'detailPengajuan'])->name('detail');
    Route::get('/laporan-pinjaman', [KepalaKoperasiController::class, 'laporanPinjaman'])->name('laporan');
    Route::get('/transparansi', [KepalaKoperasiController::class, 'transparansi'])->name('transparansi');
});
