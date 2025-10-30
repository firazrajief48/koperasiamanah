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
        // Tampilkan hanya pengajuan yang masih menunggu verifikasi bendahara
        $pinjamans = Pinjaman::with('user')
            ->where('status_detail', 'menunggu_persetujuan_bendahara')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('bendahara_koperasi.dashboard', compact('pinjamans'));
    }

    public function detailPengajuan($id)
    {
        $pinjaman = Pinjaman::with('user')->findOrFail($id);
        return view('bendahara_koperasi.detail', compact('pinjaman'));
    }

    public function laporanPinjaman()
    {
        // Ambil semua pinjaman yang sudah keluar dari antrian bendahara
        $pinjamans = Pinjaman::with('user')
            ->where('status_detail', '!=', 'menunggu_persetujuan_bendahara')
            ->orderBy('created_at', 'desc')
            ->get();

        $laporan = [];
        foreach ($pinjamans as $p) {
            // Mapping status untuk tampilan
            $statusLabel = '';
            switch ($p->status_detail) {
                case 'menunggu_persetujuan_ketua':
                    $statusLabel = 'Sedang Diverifikasi Ketua Koperasi';
                    break;
                case 'menunggu_persetujuan_kepala':
                    $statusLabel = 'Sedang Diverifikasi Kepala BPS Kota Surabaya';
                    break;
                case 'ditolak':
                    $statusLabel = 'Ditolak';
                    break;
                default:
                    $statusLabel = ucfirst($p->status);
            }

            $laporan[] = [
                'nama' => $p->user->name,
                'jumlah' => (float) $p->jumlah_pinjaman,
                'status' => $statusLabel,
                'tanggal' => $p->created_at->toDateString(),
                // Detail untuk modal (opsional)
                'nip' => $p->user->nip ?? '-',
                'jabatan' => $p->user->jabatan ?? '-',
                'golongan' => $p->user->golongan ?? '-',
                'no_hp' => $p->user->phone ?? '-',
                'email' => $p->user->email,
                'tenor' => $p->tenor_bulan,
                'metode_pembayaran' => $p->metode_pembayaran === 'potong_gaji' ? 'Potong Gaji Pokok' : 'Potong Tunjangan Kinerja',
                'tujuan' => $p->keterangan ?? '-',
                'angsuran' => $this->generateAngsuran((float) $p->jumlah_pinjaman, (int) $p->tenor_bulan),
                // Verifikasi detail
                'verifier_name' => $p->disetujui_oleh,
                'tanggal_verifikasi' => optional($p->tanggal_persetujuan)->format('d/m/Y H:i'),
                'gaji_pokok' => $p->gaji_pokok,
                'sisa_gaji' => null,
                'catatan_verifikasi' => $p->alasan_penolakan,
            ];
        }

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
            'id' => 'required|integer|exists:pinjamans,id',
            'gaji_pokok' => 'required|numeric|min:0',
            'sisa_gaji' => 'required|numeric|min:0',
            'catatan' => 'nullable|string|max:1000',
            'aksi' => 'required|in:setujui,tolak',
        ]);

        $pinjaman = Pinjaman::findOrFail($validated['id']);

        $pinjaman->gaji_pokok = $validated['gaji_pokok'];
        // sisa_gaji tidak disimpan sebagai kolom; gunakan pada validasi logika jika diperlukan

        if ($validated['aksi'] === 'setujui') {
            $pinjaman->status = 'menunggu';
            $pinjaman->status_detail = 'menunggu_persetujuan_ketua';
            $pinjaman->alasan_penolakan = null;
            // Simpan nama bendahara yang memverifikasi
            $pinjaman->disetujui_oleh = auth()->user()->name;
            $pinjaman->tanggal_persetujuan = now();
        } else {
            $request->validate(['catatan' => 'required|string|max:1000']);
            $pinjaman->status = 'menunggu';
            $pinjaman->status_detail = 'ditolak';
            $pinjaman->alasan_penolakan = $validated['catatan'];
            // Simpan nama bendahara yang menolak
            $pinjaman->disetujui_oleh = auth()->user()->name;
            $pinjaman->tanggal_persetujuan = now();
        }

        $pinjaman->save();

        return response()->json([
            'success' => true,
            'message' => $validated['aksi'] === 'setujui'
                ? 'Pengajuan diteruskan ke Ketua Koperasi.'
                : 'Pengajuan ditolak dengan alasan tersimpan.',
        ]);
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
