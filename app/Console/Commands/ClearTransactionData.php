<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Pinjaman;
use App\Models\Pembayaran;
use App\Models\Iuran;

class ClearTransactionData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:clear-transactions {--force : Force the operation without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all transaction data (pinjamans, pembayarans, iurans) while keeping users intact';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!$this->option('force')) {
            if (!$this->confirm('Apakah Anda yakin ingin menghapus semua data transaksi? (pinjamans, pembayarans, iurans)')) {
                $this->info('Operasi dibatalkan.');
                return 0;
            }
        }

        $this->info('Mulai menghapus data transaksi...');

        try {
            // Disable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            // Clear pembayarans first (because it might have foreign key to pinjamans)
            $pembayaranCount = Pembayaran::count();
            DB::table('pembayarans')->truncate();
            $this->info("✓ Dihapus {$pembayaranCount} data pembayaran");

            // Clear pinjamans
            $pinjamanCount = Pinjaman::count();
            DB::table('pinjamans')->truncate();
            $this->info("✓ Dihapus {$pinjamanCount} data pinjaman");

            // Clear iurans
            $iuranCount = Iuran::count();
            DB::table('iurans')->truncate();
            $this->info("✓ Dihapus {$iuranCount} data iuran");

            // Clear sessions (optional - untuk logout semua user)
            $sessionCount = DB::table('sessions')->count();
            DB::table('sessions')->truncate();
            $this->info("✓ Dihapus {$sessionCount} data session");

            // Re-enable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            $this->newLine();
            $this->info('✓ Semua data transaksi berhasil dihapus!');
            $this->info('✓ Data users tetap tersimpan dan dapat digunakan untuk login.');
            
            return 0;
        } catch (\Exception $e) {
            // Re-enable foreign key checks in case of error
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            
            $this->error('Terjadi kesalahan: ' . $e->getMessage());
            return 1;
        }
    }
}
