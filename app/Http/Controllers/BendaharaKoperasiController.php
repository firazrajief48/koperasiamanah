<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BendaharaKoperasiController extends Controller
{
    public function dashboard()
    {
        $pengajuan = [
            ['id' => 1, 'nama' => 'Andi Wijaya', 'jumlah' => 20000000, 'tanggal' => '2024-09-15', 'status' => 'Diverifikasi Kantor'],
            ['id' => 2, 'nama' => 'Citra Dewi', 'jumlah' => 25000000, 'tanggal' => '2024-09-20', 'status' => 'Menunggu'],
            ['id' => 3, 'nama' => 'Eka Putri', 'jumlah' => 12000000, 'tanggal' => '2024-09-25', 'status' => 'Selesai'],
        ];

        return view('bendahara_koperasi.dashboard', compact('pengajuan'));
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
            'gaji_pokok' => 8000000,
            'sisa_gaji' => 5500000,
            'tujuan' => 'Renovasi rumah dan kebutuhan mendesak',
            'angsuran_per_bulan' => 2000000,
            'status' => 'Diverifikasi Kantor'
        ];

        return view('bendahara_koperasi.detail', compact('pengajuan'));
    }

    public function laporanPinjaman()
    {
        $laporan = [
            ['nama' => 'Andi Wijaya', 'jumlah' => 20000000, 'status' => 'Sedang Diverifikasi', 'tanggal' => '2024-09-15', 'link_pdf' => route('download.pdf', 'laporan-pinjaman-andi-wijaya.pdf')],
            ['nama' => 'Budi Santoso', 'jumlah' => 15000000, 'status' => 'Diverifikasi', 'tanggal' => '2024-01-10', 'link_pdf' => route('download.pdf', 'laporan-pinjaman-budi-santoso.pdf')],
            ['nama' => 'Citra Dewi', 'jumlah' => 25000000, 'status' => 'Diverifikasi', 'tanggal' => '2024-09-20', 'link_pdf' => route('download.pdf', 'laporan-pinjaman-citra-dewi.pdf')],
            ['nama' => 'Dedi Kurniawan', 'jumlah' => 18000000, 'status' => 'Sedang Diverifikasi', 'tanggal' => '2024-03-15', 'link_pdf' => route('download.pdf', 'laporan-pinjaman-dedi-kurniawan.pdf')],
        ];

        return view('bendahara_koperasi.laporan', compact('laporan'));
    }

    public function transparansi()
    {
        $pinjaman = [
            ['id' => 1, 'nama' => 'Andi Wijaya', 'nip' => '199001012020', 'jumlah' => 20000000, 'total_bayar' => 5000000, 'jumlah_bayar' => 3000000, 'sisa' => 12000000, 'status' => 'Belum Lunas'],
            ['id' => 2, 'nama' => 'Budi Santoso', 'nip' => '199002022021', 'jumlah' => 15000000, 'total_bayar' => 10000000, 'jumlah_bayar' => 5000000, 'sisa' => 0, 'status' => 'Lunas'],
            ['id' => 3, 'nama' => 'Citra Dewi', 'nip' => '199003032022', 'jumlah' => 25000000, 'total_bayar' => 4000000, 'jumlah_bayar' => 3000000, 'sisa' => 18000000, 'status' => 'Belum Lunas'],
            ['id' => 4, 'nama' => 'Dedi Kurniawan', 'nip' => '199004042023', 'jumlah' => 18000000, 'total_bayar' => 8000000, 'jumlah_bayar' => 5000000, 'sisa' => 5000000, 'status' => 'Belum Lunas'],
            ['id' => 5, 'nama' => 'Eka Putri', 'nip' => '199005052024', 'jumlah' => 12000000, 'total_bayar' => 7000000, 'jumlah_bayar' => 5000000, 'sisa' => 0, 'status' => 'Lunas'],
        ];

        return view('bendahara_koperasi.transparansi', compact('pinjaman'));
    }

    public function profile()
    {
        $user = [
            'nama' => 'Siti Nurhaliza',
            'nip' => '198701012012',
            'jabatan' => 'Bendahara Koperasi',
            'golongan' => 'III/D',
            'no_hp' => '081234567892',
            'email' => 'siti.nurhaliza@example.com',
            'foto' => 'https://ui-avatars.com/api/?name=Siti+Nurhaliza&size=200&background=dc3545&color=fff'
        ];

        return view('bendahara_koperasi.profile', compact('user'));
    }
}
