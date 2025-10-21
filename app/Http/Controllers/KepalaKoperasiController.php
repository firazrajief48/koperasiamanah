<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KepalaKoperasiController extends Controller
{
    public function dashboard()
    {
        $pengajuan = [
            ['id' => 1, 'nama' => 'Andi Wijaya', 'jumlah' => 20000000, 'tanggal' => '2024-09-15', 'status' => 'Menunggu Persetujuan'],
            ['id' => 2, 'nama' => 'Citra Dewi', 'jumlah' => 25000000, 'tanggal' => '2024-09-20', 'status' => 'Menunggu Persetujuan'],
            ['id' => 3, 'nama' => 'Eka Putri', 'jumlah' => 12000000, 'tanggal' => '2024-09-25', 'status' => 'Disetujui'],
        ];

    return view('ketua_koperasi.dashboard', compact('pengajuan'));
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
            'berapa_kali' => '2 kali',
            'metode_pembayaran' => 'Potong Gaji',
            'tanggal_pengajuan' => '2024-09-15',
            'gaji_pokok' => 8000000,
            'sisa_gaji' => 5500000,
            'tujuan' => 'Renovasi rumah dan kebutuhan mendesak lainnya',
            'angsuran_per_bulan' => 2000000,
            'status' => 'Menunggu Persetujuan'
        ];

    return view('ketua_koperasi.detail', compact('pengajuan'));
    }

    public function laporanPinjaman()
    {
        $laporan = [
            ['id' => 1, 'nama' => 'Andi Wijaya', 'nip' => '199001012020', 'jumlah' => 20000000, 'tanggal_verifikasi' => '2024-09-16 10:30:00', 'verifikator' => 'Ahmad Rizki', 'status' => 'Diverifikasi'],
            ['id' => 2, 'nama' => 'Budi Santoso', 'nip' => '199002022021', 'jumlah' => 15000000, 'tanggal_verifikasi' => '2024-08-20 14:15:00', 'verifikator' => 'Ahmad Rizki', 'status' => 'Diverifikasi'],
            ['id' => 3, 'nama' => 'Citra Dewi', 'nip' => '199003032022', 'jumlah' => 25000000, 'tanggal_verifikasi' => '2024-09-21 09:00:00', 'verifikator' => 'Ahmad Rizki', 'status' => 'Berjalan'],
            ['id' => 4, 'nama' => 'Dedi Kurniawan', 'nip' => '199004042023', 'jumlah' => 18000000, 'tanggal_verifikasi' => '2024-09-10 11:20:00', 'verifikator' => 'Ahmad Rizki', 'status' => 'Berjalan'],
        ];

    return view('ketua_koperasi.laporan', compact('laporan'));
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

    return view('ketua_koperasi.transparansi', compact('pinjaman'));
    }

    public function profile()
    {
        $user = [
            'nama' => 'Budi Santoso',
            'nip' => '198501012010',
            'jabatan' => 'Ketua Koperasi',
            'golongan' => 'IV/A',
            'no_hp' => '081234567893',
            'email' => 'budi.santoso@example.com',
            'foto' => 'https://ui-avatars.com/api/?name=Budi+Santoso&size=200&background=ffc107&color=000'
        ];

    return view('ketua_koperasi.profile', compact('user'));
    }
}
