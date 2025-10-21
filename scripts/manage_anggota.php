<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use App\Models\User;

// Bootstrap Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== MANAJEMEN DATABASE ANGGOTA ===\n\n";

while (true) {
    echo "Pilih opsi:\n";
    echo "1. Lihat semua anggota\n";
    echo "2. Lihat detail anggota\n";
    echo "3. Hapus anggota\n";
    echo "4. Reset semua anggota\n";
    echo "5. Keluar\n";
    echo "Pilihan: ";

    $choice = trim(fgets(STDIN));

    switch ($choice) {
        case '1':
            $anggota = User::where('role', 'peminjam')->get(['id', 'name', 'email', 'nip', 'jabatan', 'created_at']);
            echo "\n=== DAFTAR ANGGOTA ===\n";
            if ($anggota->count() == 0) {
                echo "Belum ada anggota terdaftar.\n\n";
            } else {
                foreach ($anggota as $a) {
                    echo "ID: {$a->id} | {$a->name} | {$a->email} | NIP: {$a->nip} | {$a->jabatan} | Daftar: {$a->created_at}\n";
                }
                echo "\nTotal: " . $anggota->count() . " anggota\n\n";
            }
            break;

        case '2':
            echo "Masukkan ID anggota: ";
            $id = trim(fgets(STDIN));
            $anggota = User::where('role', 'peminjam')->where('id', $id)->first();
            if ($anggota) {
                echo "\n=== DETAIL ANGGOTA ===\n";
                echo "ID: {$anggota->id}\n";
                echo "Nama: {$anggota->name}\n";
                echo "Email: {$anggota->email}\n";
                echo "NIP: {$anggota->nip}\n";
                echo "Golongan: {$anggota->golongan}\n";
                echo "Jabatan: {$anggota->jabatan}\n";
                echo "No HP: {$anggota->phone}\n";
                echo "Daftar: {$anggota->created_at}\n";
                echo "Update: {$anggota->updated_at}\n\n";
            } else {
                echo "Anggota tidak ditemukan!\n\n";
            }
            break;

        case '3':
            echo "Masukkan ID anggota yang akan dihapus: ";
            $id = trim(fgets(STDIN));
            $anggota = User::where('role', 'peminjam')->where('id', $id)->first();
            if ($anggota) {
                echo "Yakin hapus {$anggota->name} ({$anggota->email})? (y/n): ";
                $confirm = trim(fgets(STDIN));
                if (strtolower($confirm) == 'y') {
                    $anggota->delete();
                    echo "Anggota berhasil dihapus!\n\n";
                } else {
                    echo "Dibatalkan.\n\n";
                }
            } else {
                echo "Anggota tidak ditemukan!\n\n";
            }
            break;

        case '4':
            echo "Yakin hapus SEMUA anggota? (y/n): ";
            $confirm = trim(fgets(STDIN));
            if (strtolower($confirm) == 'y') {
                $count = User::where('role', 'peminjam')->count();
                User::where('role', 'peminjam')->delete();
                echo "Semua {$count} anggota berhasil dihapus!\n\n";
            } else {
                echo "Dibatalkan.\n\n";
            }
            break;

        case '5':
            echo "Keluar...\n";
            exit(0);

        default:
            echo "Pilihan tidak valid!\n\n";
    }
}
