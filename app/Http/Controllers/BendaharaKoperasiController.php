<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BendaharaKoperasiController extends Controller
{
    public function dashboard()
    {
        $pengajuan = [
            ['id' => 1, 'nama' => 'Andi Wijaya', 'jumlah' => 10000000, 'tanggal' => '2024-09-15', 'status' => 'Diverifikasi Kantor'],
            ['id' => 2, 'nama' => 'Citra Dewi', 'jumlah' => 15000000, 'tanggal' => '2024-09-20', 'status' => 'Menunggu'],
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
            'jumlah_pinjaman' => 10000000,
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
            [
                'nama' => 'Andi Wijaya', 
                'jumlah' => 10000000, 
                'status' => 'Sedang Diverifikasi Ketua Koperasi', 
                'tanggal' => '2024-09-15', 
                'link_pdf' => route('download.pdf', 'laporan-pinjaman-andi-wijaya.pdf'),
                'nip' => '199001012020',
                'jabatan' => 'Staff IT',
                'golongan' => 'III/A',
                'no_hp' => '081234567890',
                'email' => 'andi.wijaya@example.com',
                'tenor' => 24,
                'metode_pembayaran' => 'Potong Gaji',
                'tujuan' => 'Renovasi rumah dan kebutuhan mendesak',
                'angsuran' => $this->generateAngsuran(10000000, 24),
                'riwayat' => []
            ],
            [
                'nama' => 'Budi Santoso', 
                'jumlah' => 15000000, 
                'status' => 'Diverifikasi', 
                'tanggal' => '2024-01-10', 
                'link_pdf' => route('download.pdf', 'laporan-pinjaman-budi-santoso.pdf'),
                'nip' => '199002022021',
                'jabatan' => 'Kepala Bagian Keuangan',
                'golongan' => 'III/C',
                'no_hp' => '081234567891',
                'email' => 'budi.santoso@example.com',
                'tenor' => 36,
                'metode_pembayaran' => 'Transfer Bank',
                'tujuan' => 'Pendidikan anak',
                'angsuran' => $this->generateAngsuran(15000000, 36),
                'riwayat' => [
                    [
                        'verifier' => 'Siti Nurhaliza',
                        'jabatan' => 'Bendahara Koperasi',
                        'tanggal' => '12/01/2024 14:30',
                        'status' => 'Diverifikasi',
                        'catatan' => 'Dokumen lengkap dan memenuhi syarat'
                    ]
                ]
            ],
            [
                'nama' => 'Citra Dewi', 
                'jumlah' => 15000000, 
                'status' => 'Diverifikasi', 
                'tanggal' => '2024-09-20', 
                'link_pdf' => route('download.pdf', 'laporan-pinjaman-citra-dewi.pdf'),
                'nip' => '199003032022',
                'jabatan' => 'Staff Administrasi',
                'golongan' => 'III/B',
                'no_hp' => '081234567892',
                'email' => 'citra.dewi@example.com',
                'tenor' => 18,
                'metode_pembayaran' => 'Potong Gaji',
                'tujuan' => 'Biaya pengobatan',
                'angsuran' => $this->generateAngsuran(15000000, 18),
                'riwayat' => [
                    [
                        'verifier' => 'Siti Nurhaliza',
                        'jabatan' => 'Bendahara Koperasi',
                        'tanggal' => '22/09/2024 10:15',
                        'status' => 'Diverifikasi',
                        'catatan' => 'Pengajuan untuk keperluan medis, disetujui dengan tenor 18 bulan'
                    ]
                ]
            ],
            [
                'nama' => 'Dedi Kurniawan', 
                'jumlah' => 18000000, 
                'status' => 'Sedang Diverifikasi Kepala BPS Kota Surabaya', 
                'tanggal' => '2024-03-15', 
                'link_pdf' => route('download.pdf', 'laporan-pinjaman-dedi-kurniawan.pdf'),
                'nip' => '199004042023',
                'jabatan' => 'Supervisor Operasional',
                'golongan' => 'IV/A',
                'no_hp' => '081234567893',
                'email' => 'dedi.kurniawan@example.com',
                'tenor' => 30,
                'metode_pembayaran' => 'Transfer Bank',
                'tujuan' => 'Investasi usaha',
                'angsuran' => $this->generateAngsuran(18000000, 30),
                'riwayat' => []
            ],
            [
                'nama' => 'Eka Putri', 
                'jumlah' => 12000000, 
                'status' => 'Ditolak', 
                'tanggal' => '2024-05-20', 
                'link_pdf' => route('download.pdf', 'laporan-pinjaman-eka-putri.pdf'),
                'nip' => '199005052024',
                'jabatan' => 'Staff IT',
                'golongan' => 'III/A',
                'no_hp' => '081234567894',
                'email' => 'eka.putri@example.com',
                'tenor' => 12,
                'metode_pembayaran' => 'Potong Gaji',
                'tujuan' => 'Keperluan pribadi',
                'angsuran' => $this->generateAngsuran(12000000, 12),
                'riwayat' => [
                    [
                        'verifier' => 'Siti Nurhaliza',
                        'jabatan' => 'Bendahara Koperasi',
                        'tanggal' => '23/05/2024 09:45',
                        'status' => 'Ditolak',
                        'catatan' => 'Sisa gaji tidak mencukupi untuk angsuran yang diajukan'
                    ]
                ]
            ],
            [
                'nama' => 'Fajar Ramadhan', 
                'jumlah' => 20000000, 
                'status' => 'Sedang Diverifikasi Ketua Koperasi', 
                'tanggal' => '2024-08-10', 
                'link_pdf' => route('download.pdf', 'laporan-pinjaman-fajar-ramadhan.pdf'),
                'nip' => '199006062025',
                'jabatan' => 'Kepala Bagian IT',
                'golongan' => 'IV/B',
                'no_hp' => '081234567895',
                'email' => 'fajar.ramadhan@example.com',
                'tenor' => 36,
                'metode_pembayaran' => 'Potong Gaji',
                'tujuan' => 'Pembelian kendaraan',
                'angsuran' => $this->generateAngsuran(20000000, 36),
                'riwayat' => []
            ]
        ];

        return view('bendahara_koperasi.laporan', compact('laporan'));
    }

    private function generateAngsuran($jumlah, $tenor)
    {
        $angsuranPerBulan = round($jumlah / $tenor);
        $angsuran = [];

        for ($i = 1; $i <= $tenor; $i++) {
            $angsuran[] = [
                'bulan' => $i,
                'nominal' => $angsuranPerBulan,
                'sisa' => max(0, $jumlah - ($angsuranPerBulan * $i))
            ];
        }

        return $angsuran;
    }

    public function getDetailLaporan($id)
    {
        $laporan = [
            [
                'id' => 1,
                'nama' => 'Andi Wijaya',
                'nip' => '199001012020',
                'jabatan' => 'Staff IT',
                'golongan' => 'III/A',
                'no_hp' => '081234567890',
                'email' => 'andi.wijaya@example.com',
                'jumlah_pinjaman' => 10000000,
                'tenor' => '24 Bulan',
                'metode_pembayaran' => 'Potong Gaji',
                'tanggal_pengajuan' => '2024-09-15',
                'tujuan' => 'Renovasi rumah dan kebutuhan mendesak',
                'status' => 'Sedang Diverifikasi Ketua Koperasi',
                'angsuran' => $this->generateAngsuran(10000000, 24),
                'riwayat' => []
            ],
            [
                'id' => 2,
                'nama' => 'Budi Santoso',
                'nip' => '199002022021',
                'jabatan' => 'Kepala Bagian Keuangan',
                'golongan' => 'III/C',
                'no_hp' => '081234567891',
                'email' => 'budi.santoso@example.com',
                'jumlah_pinjaman' => 15000000,
                'tenor' => '36 Bulan',
                'metode_pembayaran' => 'Transfer Bank',
                'tanggal_pengajuan' => '2024-01-10',
                'tujuan' => 'Pendidikan anak',
                'status' => 'Diverifikasi',
                'angsuran' => $this->generateAngsuran(15000000, 36),
                'riwayat' => [
                    [
                        'verifier' => 'Siti Nurhaliza',
                        'jabatan' => 'Bendahara Koperasi',
                        'tanggal' => '12/01/2024 14:30',
                        'status' => 'Diverifikasi',
                        'catatan' => 'Dokumen lengkap dan memenuhi syarat'
                    ]
                ]
            ],
            [
                'id' => 3,
                'nama' => 'Citra Dewi',
                'nip' => '199003032022',
                'jabatan' => 'Staff Administrasi',
                'golongan' => 'III/B',
                'no_hp' => '081234567892',
                'email' => 'citra.dewi@example.com',
                'jumlah_pinjaman' => 15000000,
                'tenor' => '18 Bulan',
                'metode_pembayaran' => 'Potong Gaji',
                'tanggal_pengajuan' => '2024-09-20',
                'tujuan' => 'Biaya pengobatan',
                'status' => 'Diverifikasi',
                'angsuran' => $this->generateAngsuran(15000000, 18),
                'riwayat' => [
                    [
                        'verifier' => 'Siti Nurhaliza',
                        'jabatan' => 'Bendahara Koperasi',
                        'tanggal' => '22/09/2024 10:15',
                        'status' => 'Diverifikasi',
                        'catatan' => 'Pengajuan untuk keperluan medis, disetujui dengan tenor 18 bulan'
                    ]
                ]
            ],
            [
                'id' => 4,
                'nama' => 'Dedi Kurniawan',
                'nip' => '199004042023',
                'jabatan' => 'Supervisor Operasional',
                'golongan' => 'IV/A',
                'no_hp' => '081234567893',
                'email' => 'dedi.kurniawan@example.com',
                'jumlah_pinjaman' => 18000000,
                'tenor' => '30 Bulan',
                'metode_pembayaran' => 'Transfer Bank',
                'tanggal_pengajuan' => '2024-03-15',
                'tujuan' => 'Investasi usaha',
                'status' => 'Sedang Diverifikasi Kepala BPS Kota Surabaya',
                'angsuran' => $this->generateAngsuran(18000000, 30),
                'riwayat' => []
            ],
            [
                'id' => 5,
                'nama' => 'Eka Putri',
                'nip' => '199005052024',
                'jabatan' => 'Staff IT',
                'golongan' => 'III/A',
                'no_hp' => '081234567894',
                'email' => 'eka.putri@example.com',
                'jumlah_pinjaman' => 12000000,
                'tenor' => '12 Bulan',
                'metode_pembayaran' => 'Potong Gaji',
                'tanggal_pengajuan' => '2024-05-20',
                'tujuan' => 'Keperluan pribadi',
                'status' => 'Ditolak',
                'angsuran' => $this->generateAngsuran(12000000, 12),
                'riwayat' => [
                    [
                        'verifier' => 'Siti Nurhaliza',
                        'jabatan' => 'Bendahara Koperasi',
                        'tanggal' => '23/05/2024 09:45',
                        'status' => 'Ditolak',
                        'catatan' => 'Sisa gaji tidak mencukupi untuk angsuran yang diajukan'
                    ]
                ]
            ],
            [
                'id' => 6,
                'nama' => 'Fajar Ramadhan',
                'nip' => '199006062025',
                'jabatan' => 'Kepala Bagian IT',
                'golongan' => 'IV/B',
                'no_hp' => '081234567895',
                'email' => 'fajar.ramadhan@example.com',
                'jumlah_pinjaman' => 20000000,
                'tenor' => '36 Bulan',
                'metode_pembayaran' => 'Potong Gaji',
                'tanggal_pengajuan' => '2024-08-10',
                'tujuan' => 'Pembelian kendaraan',
                'status' => 'Sedang Diverifikasi Ketua Koperasi',
                'angsuran' => $this->generateAngsuran(20000000, 36),
                'riwayat' => []
            ]
        ];

        if ($id > 0 && $id <= count($laporan)) {
            return response()->json($laporan[$id - 1]);
        }

        return response()->json(['error' => 'Data tidak ditemukan'], 404);
    }

    public function submitVerifikasi(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer',
            'gaji_pokok' => 'required|numeric|min:0',
            'sisa_gaji' => 'required|numeric|min:0',
            'catatan' => 'nullable|string|max:500',
            'status' => 'required|in:Diverifikasi,Ditolak'
        ]);

        $verifier = [
            'nama' => 'Siti Nurhaliza',
            'jabatan' => 'Bendahara Koperasi'
        ];

        $response = [
            'success' => true,
            'message' => $validated['status'] === 'Diverifikasi' 
                ? 'Pinjaman berhasil disetujui!' 
                : 'Pinjaman berhasil ditolak!',
            'data' => [
                'status' => $validated['status'],
                'verifier' => $verifier['nama'],
                'jabatan' => $verifier['jabatan'],
                'tanggal' => now()->format('d/m/Y H:i'),
                'gaji_pokok' => $validated['gaji_pokok'],
                'sisa_gaji' => $validated['sisa_gaji'],
                'catatan' => $validated['catatan'] ?: ($validated['status'] === 'Diverifikasi' 
                    ? 'Dokumen lengkap dan memenuhi syarat' 
                    : 'Tidak memenuhi syarat')
            ]
        ];

        return response()->json($response);
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

    public function kelolaIuran()
    {
        $iuran = [
            ['id' => 1, 'nama' => 'Andi Wijaya', 'total_iuran' => 50000, 'terbayar' => 20000, 'sisa' => 30000],
            ['id' => 2, 'nama' => 'Citra Dewi', 'total_iuran' => 75000, 'terbayar' => 75000, 'sisa' => 0],
        ];

        return view('bendahara_koperasi.iuran_pegawai', compact('iuran'));
    }

    public function downloadPDF($filename)
    {
        $filepath = storage_path('app/public/laporan/' . $filename);
        return redirect()->back()->with('info', 'Fitur download PDF akan tersedia setelah integrasi dengan generator PDF');
    }
}