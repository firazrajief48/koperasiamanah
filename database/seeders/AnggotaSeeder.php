<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AnggotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample data anggota untuk testing
        $anggotaData = [
            [
                'name' => 'Andi Wijaya',
                'email' => 'andi.wijaya@bps.go.id',
                'password' => Hash::make('password'),
                'role' => 'peminjam',
                'nip' => '196512121990031001',
                'golongan' => 'III/a',
                'jabatan' => 'Statistisi Muda',
                'phone' => '081234567890',
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@bps.go.id',
                'password' => Hash::make('password'),
                'role' => 'peminjam',
                'nip' => '197003151990031002',
                'golongan' => 'III/b',
                'jabatan' => 'Statistisi Muda',
                'phone' => '081234567891',
            ],
        ];

        foreach ($anggotaData as $data) {
            User::updateOrCreate(
                ['email' => $data['email']],
                $data
            );
        }

        echo "Sample data anggota berhasil ditambahkan!\n";
    }
}
