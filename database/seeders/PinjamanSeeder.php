<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pinjaman;
use App\Models\User;

class PinjamanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get peminjam users
        $peminjams = User::where('role', 'peminjam')->get();

        if ($peminjams->isEmpty()) {
            $this->command->info('No peminjam users found. Please register a user first.');
            return;
        }

        // Sample loan data
        $loanData = [
            [
                'jumlah_pinjaman' => 5000000,
                'tenor_bulan' => 5,
                'cicilan_per_bulan' => 1000000,
                'bulan_terbayar' => 0,
                'sisa_pinjaman' => 5000000,
                'gaji_pokok' => 8000000,
                'status' => 'disetujui',
                'keterangan' => 'Pinjaman untuk keperluan pribadi',
            ],
            [
                'jumlah_pinjaman' => 3000000,
                'tenor_bulan' => 3,
                'cicilan_per_bulan' => 1000000,
                'bulan_terbayar' => 1,
                'sisa_pinjaman' => 2000000,
                'gaji_pokok' => 8000000,
                'status' => 'disetujui',
                'keterangan' => 'Pinjaman untuk renovasi rumah',
            ],
            [
                'jumlah_pinjaman' => 7000000,
                'tenor_bulan' => 7,
                'cicilan_per_bulan' => 1000000,
                'bulan_terbayar' => 7,
                'sisa_pinjaman' => 0,
                'gaji_pokok' => 8000000,
                'status' => 'lunas',
                'keterangan' => 'Pinjaman sudah lunas',
            ],
        ];

        // Create loans for first peminjam user
        $firstPeminjam = $peminjams->first();

        foreach ($loanData as $index => $loan) {
            Pinjaman::create([
                'user_id' => $firstPeminjam->id,
                'jumlah_pinjaman' => $loan['jumlah_pinjaman'],
                'tenor_bulan' => $loan['tenor_bulan'],
                'cicilan_per_bulan' => $loan['cicilan_per_bulan'],
                'bulan_terbayar' => $loan['bulan_terbayar'],
                'sisa_pinjaman' => $loan['sisa_pinjaman'],
                'gaji_pokok' => $loan['gaji_pokok'],
                'status' => $loan['status'],
                'keterangan' => $loan['keterangan'],
                'created_at' => now()->subDays($index * 30),
                'updated_at' => now()->subDays($index * 30),
            ]);
        }

        $this->command->info('Sample loan data created for user: ' . $firstPeminjam->name);
    }
}

