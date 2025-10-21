<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BendaharaKantorController extends Controller
{
    public function dashboard()
    {
        $pengajuan = [
            ['id' => 1, 'nama' => 'Andi Wijaya', 'jumlah' => 20000000, 'tanggal' => '2024-09-15', 'status' => 'Menunggu'],
            ['id' => 2, 'nama' => 'Citra Dewi', 'jumlah' => 25000000, 'tanggal' => '2024-09-20', 'status' => 'Menunggu'],
            ['id' => 3, 'nama' => 'Eka Putri', 'jumlah' => 12000000, 'tanggal' => '2024-09-25', 'status' => 'Diverifikasi'],
        ];

    return view('kepala_bps.dashboard', compact('pengajuan'));
    }

    public function detailPengajuan($id)
    {
        $pengajuan = [
            'id' => $id,
            'nama' => 'Andi Wijaya',
            'nip' => '199001012020',
            'jabatan' => 'Staff IT',
            'golongan' => 'III/A',
            'no_hp' => '081234567890',
            'email' => 'andi.wijaya@example.com',
            'jumlah_pinjaman' => 20000000,
            'metode_pembayaran' => 'Potong Gaji',
            'tanggal_pengajuan' => '2024-09-15',
            'tujuan' => 'Renovasi rumah dan kebutuhan mendesak',
            'status' => 'Menunggu Verifikasi'
        ];

    return view('kepala_bps.detail', compact('pengajuan'));
    }

    public function laporanPinjaman()
    {
        $laporan = [
            ['id' => 1, 'nama' => 'Andi Wijaya', 'nip' => '199001012020', 'jumlah' => 20000000, 'tanggal_verifikasi' => '2024-09-16 10:30:00', 'verifikator' => 'Ahmad Rizki', 'gaji_pokok' => 8000000, 'sisa_gaji' => 5500000],
            ['id' => 2, 'nama' => 'Budi Santoso', 'nip' => '199002022021', 'jumlah' => 15000000, 'tanggal_verifikasi' => '2024-08-20 14:15:00', 'verifikator' => 'Ahmad Rizki', 'gaji_pokok' => 7500000, 'sisa_gaji' => 5000000],
            ['id' => 3, 'nama' => 'Citra Dewi', 'nip' => '199003032022', 'jumlah' => 25000000, 'tanggal_verifikasi' => '2024-09-21 09:00:00', 'verifikator' => 'Ahmad Rizki', 'gaji_pokok' => 9000000, 'sisa_gaji' => 6000000],
        ];

    return view('kepala_bps.laporan', compact('laporan'));
    }

    public function transparansi()
    {
        $pinjaman = [
            ['nama' => 'Andi Wijaya', 'nip' => '199001012020', 'jumlah' => 20000000, 'sisa' => 12000000, 'status' => 'Belum Lunas'],
            ['nama' => 'Budi Santoso', 'nip' => '199002022021', 'jumlah' => 15000000, 'sisa' => 0, 'status' => 'Lunas'],
            ['nama' => 'Citra Dewi', 'nip' => '199003032022', 'jumlah' => 25000000, 'sisa' => 18000000, 'status' => 'Belum Lunas'],
            ['nama' => 'Dedi Kurniawan', 'nip' => '199004042023', 'jumlah' => 18000000, 'sisa' => 5000000, 'status' => 'Belum Lunas'],
            ['nama' => 'Eka Putri', 'nip' => '199005052024', 'jumlah' => 12000000, 'sisa' => 0, 'status' => 'Lunas'],
        ];

    return view('kepala_bps.transparansi', compact('pinjaman'));
    }

    public function profile()
    {
        $user = [
            'nama' => 'Ahmad Rizki',
            'nip' => '198801012015',
            'jabatan' => 'Kepala BPS Kota Surabaya',
            'golongan' => 'III/C',
            'no_hp' => '081234567891',
            'email' => 'ahmad.rizki@example.com',
            'foto' => 'https://ui-avatars.com/api/?name=Ahmad+Rizki&size=200&background=28a745&color=fff'
        ];

    return view('kepala_bps.profile', compact('user'));
    }
}
