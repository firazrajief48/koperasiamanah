<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PeminjamController extends Controller
{
    public function dashboard()
    {
        $data = [
            'nama' => 'Andi Wijaya',
            'nip' => '199001012020',
            'kas_pribadi' => 15000000,
            'jumlah_pinjaman' => 20000000,
            'sisa_pinjaman' => 12000000,
            'simulasi' => [
                ['bulan' => 1, 'angsuran' => 2000000, 'sisa' => 18000000],
                ['bulan' => 2, 'angsuran' => 2000000, 'sisa' => 16000000],
                ['bulan' => 3, 'angsuran' => 2000000, 'sisa' => 14000000],
                ['bulan' => 4, 'angsuran' => 2000000, 'sisa' => 12000000],
                ['bulan' => 5, 'angsuran' => 2000000, 'sisa' => 10000000],
            ]
        ];

        return view('peminjam.dashboard', compact('data'));
    }

    public function ajukanPinjaman()
    {
        $peminjam = [
            'nama' => 'Andi Wijaya',
            'nip' => '199001012020',
            'jabatan' => 'Staff IT',
            'golongan' => 'III/A',
            'no_hp' => '081234567890',
            'email' => 'andi.wijaya@example.com'
        ];

        return view('peminjam.ajukan', compact('peminjam'));
    }

    public function riwayatPinjaman()
    {
        $riwayat = [
            [
                'id' => 1,
                'tanggal' => '2024-01-15',
                'jumlah' => 20000000,
                'tenor' => '12 Bulan',
                'status' => 'Disetujui',
                'sisa' => 12000000
            ],
            [
                'id' => 2,
                'tanggal' => '2023-06-20',
                'jumlah' => 15000000,
                'tenor' => '10 Bulan',
                'status' => 'Lunas',
                'sisa' => 0
            ],
            [
                'id' => 3,
                'tanggal' => '2024-10-02',
                'jumlah' => 5000000,
                'tenor' => '6 Bulan',
                'status' => 'Menunggu Verifikasi',
                'sisa' => 5000000
            ]
        ];

        return view('peminjam.riwayat', compact('riwayat'));
    }

    public function transparansi()
    {
        $pinjaman = [
            ['nama' => 'Andi Wijaya', 'nip' => '199001012020', 'jumlah' => 20000000, 'sisa' => 12000000, 'status' => 'Berjalan'],
            ['nama' => 'Budi Santoso', 'nip' => '199002022021', 'jumlah' => 15000000, 'sisa' => 0, 'status' => 'Lunas'],
            ['nama' => 'Citra Dewi', 'nip' => '199003032022', 'jumlah' => 25000000, 'sisa' => 18000000, 'status' => 'Berjalan'],
            ['nama' => 'Dedi Kurniawan', 'nip' => '199004042023', 'jumlah' => 18000000, 'sisa' => 5000000, 'status' => 'Berjalan'],
            ['nama' => 'Eka Putri', 'nip' => '199005052024', 'jumlah' => 12000000, 'sisa' => 0, 'status' => 'Lunas'],
        ];

        return view('peminjam.transparansi', compact('pinjaman'));
    }

    public function profile()
    {
        $user = [
            'nama' => 'Andi Wijaya',
            'nip' => '199001012020',
            'jabatan' => 'Staff IT',
            'golongan' => 'III/A',
            'no_hp' => '081234567890',
            'email' => 'andi.wijaya@example.com',
            'foto' => 'https://ui-avatars.com/api/?name=Andi+Wijaya&size=200&background=0D8ABC&color=fff'
        ];

        return view('peminjam.profile', compact('user'));
    }
}
