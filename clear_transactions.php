<?php

/**
 * Script untuk mengosongkan data transaksi
 * Jalankan dengan: php clear_transactions.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\Pinjaman;
use App\Models\Pembayaran;
use App\Models\Iuran;

echo "========================================\n";
echo "  CLEAR TRANSACTION DATA\n";
echo "========================================\n\n";

echo "Mulai menghapus data transaksi...\n\n";

try {
    // Disable foreign key checks
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');

    // Clear pembayarans first (because it might have foreign key to pinjamans)
    $pembayaranCount = Pembayaran::count();
    DB::table('pembayarans')->truncate();
    echo "✓ Dihapus {$pembayaranCount} data pembayaran\n";

    // Clear pinjamans
    $pinjamanCount = Pinjaman::count();
    DB::table('pinjamans')->truncate();
    echo "✓ Dihapus {$pinjamanCount} data pinjaman\n";

    // Clear iurans
    $iuranCount = Iuran::count();
    DB::table('iurans')->truncate();
    echo "✓ Dihapus {$iuranCount} data iuran\n";

    // Clear sessions (optional - untuk logout semua user)
    $sessionCount = DB::table('sessions')->count();
    DB::table('sessions')->truncate();
    echo "✓ Dihapus {$sessionCount} data session\n";

    // Re-enable foreign key checks
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    echo "\n========================================\n";
    echo "✓ Semua data transaksi berhasil dihapus!\n";
    echo "✓ Data users tetap tersimpan dan dapat digunakan untuk login.\n";
    echo "========================================\n";
    
} catch (\Exception $e) {
    // Re-enable foreign key checks in case of error
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    
    echo "\n❌ Terjadi kesalahan: " . $e->getMessage() . "\n";
    exit(1);
}

