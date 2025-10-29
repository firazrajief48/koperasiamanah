<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pinjaman;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
            'metode_pembayaran' => 'Potong Gaji Pokok',
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
                'metode_pembayaran' => 'Potong Gaji Pokok',
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
                'metode_pembayaran' => 'Potong Gaji Pokok',
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
                'metode_pembayaran' => 'Potong Gaji Pokok',
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
                'metode_pembayaran' => 'Potong Gaji Pokok',
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
                'metode_pembayaran' => 'Potong Gaji Pokok',
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
                'metode_pembayaran' => 'Potong Gaji Pokok',
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
                'metode_pembayaran' => 'Potong Gaji Pokok',
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
                'metode_pembayaran' => 'Potong Gaji Pokok',
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
        // Get all approved loans with user data
        $pinjamans = Pinjaman::with('user')
            ->whereIn('status', ['disetujui', 'lunas'])
            ->orderBy('created_at', 'desc')
            ->get();

        $pinjaman = [];
        foreach ($pinjamans as $p) {
            $statusLabel = $p->sisa_pinjaman > 0 ? 'Berjalan' : 'Lunas';

            $pinjaman[] = [
                'id' => $p->id,
                'nama' => $p->user->name,
                'nip' => $p->user->nip ?? 'N/A',
                'jumlah' => $p->jumlah_pinjaman,
                'total_bayar' => $p->jumlah_pinjaman - $p->sisa_pinjaman,
                'sisa' => $p->sisa_pinjaman,
                'status' => $statusLabel
            ];
        }

        return view('bendahara_koperasi.transparansi', compact('pinjaman'));
    }

    public function profile()
    {
        $user = auth()->user();
        return view('bendahara_koperasi.profile', compact('user'));
    }

    /**
     * Update Profile Bendahara Koperasi
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nip' => 'nullable|string|max:20',
            'golongan' => 'nullable|string|max:50',
            'jabatan' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:15',
            'password' => 'nullable|string|min:8|confirmed',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $updateData = $request->only(['name', 'email', 'nip', 'golongan', 'jabatan', 'phone']);

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo && file_exists(public_path('storage/' . $user->photo))) {
                unlink(public_path('storage/' . $user->photo));
            }

            $photo = $request->file('photo');
            $filename = time() . '_' . $user->id . '.' . $photo->getClientOriginalExtension();
            $path = $photo->storeAs('public/photos', $filename);
            $updateData['photo'] = 'photos/' . $filename;

            // Sync to public directory
            $this->syncStorageToPublic();
        }

        $user->update($updateData);

        return redirect()->route('bendahara_koperasi.profile')->with('success', 'Profile berhasil diupdate!');
    }

    private function syncStorageToPublic()
    {
        $source = storage_path('app/public');
        $destination = public_path('storage');

        if (is_dir($source)) {
            // Remove existing public/storage directory
            if (is_dir($destination)) {
                $files = new \RecursiveIteratorIterator(
                    new \RecursiveDirectoryIterator($destination, \RecursiveDirectoryIterator::SKIP_DOTS),
                    \RecursiveIteratorIterator::CHILD_FIRST
                );

                foreach ($files as $fileinfo) {
                    $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
                    $todo($fileinfo->getRealPath());
                }
                rmdir($destination);
            }

            // Copy files from storage to public
            shell_exec("xcopy /E /I /Y \"$source\" \"$destination\"");
        }
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
