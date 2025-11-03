<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pinjaman;
use App\Models\Iuran;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

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
                'sisa_gaji' => $p->sisa_gaji,
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
        $pinjaman->sisa_gaji = $validated['sisa_gaji'];

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
        // Ambil pinjaman yang sudah aktif (disetujui semua: bendahara, ketua, kepala) atau sudah lunas
        // Status 'disetujui' berarti sudah melewati semua persetujuan (bendahara -> ketua -> kepala)
        // Status 'lunas' berarti sudah selesai dibayar
        $pinjamans = Pinjaman::with(['user', 'pembayarans'])
            ->whereIn('status', ['disetujui', 'lunas'])
            ->whereNotIn('status_detail', ['menunggu_persetujuan_bendahara', 'menunggu_persetujuan_ketua', 'menunggu_persetujuan_kepala', 'ditolak'])
            ->orderBy('created_at', 'desc')
            ->get();

        $pinjaman = [];
        foreach ($pinjamans as $p) {
            // Hitung total pembayaran dari pembayaran yang sudah dilakukan (realtime dari database)
            $totalPembayaran = $p->pembayarans()
                ->where('status', 'lunas')
                ->sum('nominal_pembayaran');

            // Jika belum ada pembayaran di tabel pembayarans, gunakan perhitungan default
            if ($totalPembayaran == 0) {
                $totalPembayaran = $p->jumlah_pinjaman - $p->sisa_pinjaman;
            }

            // Tentukan status berdasarkan sisa pinjaman
            $statusLabel = $p->sisa_pinjaman > 0 ? 'Berjalan' : 'Lunas';

            $pinjaman[] = [
                'id' => $p->id,
                'nama' => $p->user->name,
                'nip' => $p->user->nip ?? '-',
                'jumlah' => (float) $p->jumlah_pinjaman,
                'total_bayar' => (float) $totalPembayaran,
                'sisa' => (float) $p->sisa_pinjaman,
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
        // Tahun sekarang (selalu dinamis, akan otomatis update setiap tahun)
        $currentYear = (int)date('Y');

        // Ambil semua tahun dari data iuran yang ada
        // Format bulan adalah YYYY-MM, extract tahunnya
        $yearsFromData = Iuran::whereNotNull('bulan')
            ->pluck('bulan')
            ->map(function($bulan) {
                // Extract tahun dari format YYYY-MM
                $parts = explode('-', $bulan);
                return isset($parts[0]) ? (int)$parts[0] : null;
            })
            ->filter()
            ->unique()
            ->sort()
            ->values();

        // Jika ada data, gunakan tahun minimum dari data
        // Jika tidak ada data, gunakan tahun sekarang - 10 sebagai minimum
        $minYearFromData = $yearsFromData->isNotEmpty() ? $yearsFromData->first() : null;
        $minYear = $minYearFromData ? min($minYearFromData, $currentYear - 10) : max(2020, $currentYear - 10);

        // Pastikan minimum tidak kurang dari 2020
        $minYear = max(2020, $minYear);

        // Tahun maksimum: SELALU tahun sekarang + 5 tahun ke depan
        // Ini akan otomatis update setiap tahun, jadi tidak akan pernah habis
        // Contoh: jika sekarang 2025, max = 2030
        //         jika nanti 2031, max = 2036 (otomatis!)
        $maxYear = $currentYear + 5;

        return view('bendahara_koperasi.iuran_pegawai', [
            'minYear' => $minYear,
            'maxYear' => $maxYear,
            'currentYear' => $currentYear
        ]);
    }

    public function getDataIuran(Request $request)
    {
        $bulan = $request->input('bulan', date('n'));
        $tahun = $request->input('tahun', date('Y'));
        $statusFilter = $request->input('status', 'semua');

        // Format bulan untuk query (YYYY-MM)
        $bulanFormat = sprintf('%04d-%02d', $tahun, $bulan);

        // Ambil semua iuran untuk bulan yang dipilih (bukan hanya satu per user)
        $iurans = Iuran::with('user')
            ->where('bulan', $bulanFormat)
            ->whereHas('user', function($query) {
                $query->where('role', 'anggota');
            })
            ->orderBy('tanggal_bayar', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();



        $data = [];

        foreach ($iurans as $iuran) {
            $user = $iuran->user;

            $sudahBayar = $iuran->status !== 'belum';
            $nominal = (float) $iuran->jumlah;

            // Filter berdasarkan status
            if ($statusFilter === 'lunas' && !$sudahBayar) {
                continue;
            }
            if ($statusFilter === 'belum' && $sudahBayar) {
                continue;
            }

            // Format tanggal_bayar dengan timezone Asia/Jakarta
            $tanggalBayarFormatted = null;
            if ($iuran->tanggal_bayar) {
                $tanggalBayar = \Carbon\Carbon::parse($iuran->tanggal_bayar);
                // Set timezone ke Asia/Jakarta
                $tanggalBayar->setTimezone('Asia/Jakarta');
                $tanggalBayarFormatted = $tanggalBayar->format('Y-m-d H:i:s');
            }

            $data[] = [
                'id' => $user->id,
                'iuran_id' => $iuran->id,
                'nama' => $user->name,
                'nip' => $user->nip ?? '-',
                'jabatan' => $user->jabatan ?? '-',
                'nominal' => $nominal,
                'sudah_bayar' => $sudahBayar ? 1 : 0,
                'tanggal_bayar' => $tanggalBayarFormatted,
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function bayarIuran(Request $request)
    {
        $validated = $request->validate([
            'pegawai_id' => 'required|exists:users,id',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020',
            'nominal' => 'required|numeric|min:0',
        ]);

        $bulanFormat = sprintf('%04d-%02d', $validated['tahun'], $validated['bulan']);

        // Cek apakah sudah ada iuran untuk bulan ini
        $iuran = Iuran::where('user_id', $validated['pegawai_id'])
            ->where('bulan', $bulanFormat)
            ->first();

        if ($iuran && $iuran->status === 'lunas') {
            return response()->json([
                'success' => false,
                'message' => 'Iuran untuk bulan ini sudah dibayar'
            ], 400);
        }

        // Update atau create iuran
        if ($iuran) {
            $iuran->update([
                'jumlah' => $validated['nominal'],
                'tanggal_bayar' => now(),
                'status' => 'lunas',
            ]);
        } else {
            Iuran::create([
                'user_id' => $validated['pegawai_id'],
                'jumlah' => $validated['nominal'],
                'bulan' => $bulanFormat,
                'tanggal_bayar' => now(),
                'status' => 'lunas',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil dicatat'
        ]);
    }

    public function bayarSemuaPegawai(Request $request)
    {
        $validated = $request->validate([
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020',
            'nominal' => 'required|numeric|min:0',
        ]);

        // Format bulan untuk query (YYYY-MM), contoh: "2025-10"
        $bulanFormat = sprintf('%04d-%02d', $validated['tahun'], $validated['bulan']);
        $nominal = $validated['nominal'];

        // Ambil semua anggota (hanya untuk bulan yang dipilih)
        $users = User::where('role', 'anggota')->get();

        $count = 0;
        $total = 0;

        DB::beginTransaction();
        try {
            foreach ($users as $user) {
                // Cek apakah sudah ada iuran untuk BULAN YANG DIPILIH SAJA
                // Hanya menandai iuran untuk bulan yang dipilih (currentMonth, currentYear)
                $iuran = Iuran::where('user_id', $user->id)
                    ->where('bulan', $bulanFormat) // Hanya bulan tertentu, bukan semua bulan
                    ->first();

                // Skip jika sudah lunas
                if ($iuran && $iuran->status === 'lunas') {
                    continue;
                }

                // Update atau create iuran HANYA UNTUK BULAN YANG DIPILIH
                // Bulan yang dipilih disimpan dalam format YYYY-MM (contoh: "2025-10")
                // Setiap bulan memiliki record iuran terpisah di database
                if ($iuran) {
                    $iuran->update([
                        'jumlah' => $nominal,
                        'tanggal_bayar' => now(),
                        'status' => 'lunas',
                    ]);
                } else {
                    Iuran::create([
                        'user_id' => $user->id,
                        'jumlah' => $nominal,
                        'bulan' => $bulanFormat, // Hanya bulan yang dipilih (format: YYYY-MM)
                        'tanggal_bayar' => now(),
                        'status' => 'lunas',
                    ]);
                }

                $count++;
                $total += $nominal;
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Berhasil mencatat pembayaran untuk {$count} pegawai",
                'count' => $count,
                'total' => $total
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAllPegawai()
    {
        // Ambil semua anggota untuk dropdown (tidak peduli sudah ada iuran atau belum)
        $users = User::where('role', 'anggota')
            ->orderBy('name', 'asc')
            ->get(['id', 'name', 'nip']);

        $data = [];
        foreach ($users as $user) {
            $data[] = [
                'id' => $user->id,
                'nama' => $user->name,
                'nip' => $user->nip ?? '-',
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function tambahIuranManual(Request $request)
    {
        $validated = $request->validate([
            'pegawai_id' => 'required|exists:users,id',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020',
            'nominal' => 'required|numeric|min:0',
            'tanggal_bayar' => 'nullable|date',
        ]);

        $bulanFormat = sprintf('%04d-%02d', $validated['tahun'], $validated['bulan']);

        $nominalBaru = $validated['nominal'];
        // Jika ada tanggal_bayar yang diinput, gunakan itu dengan waktu sekarang
        // Jika tidak ada, gunakan waktu real-time sekarang
        if (isset($validated['tanggal_bayar']) && $validated['tanggal_bayar']) {
            // Jika hanya tanggal, tambahkan waktu sekarang
            $tanggalBayarInput = \Carbon\Carbon::parse($validated['tanggal_bayar']);
            if (!$tanggalBayarInput->format('H:i:s') || $tanggalBayarInput->format('H:i:s') === '00:00:00') {
                // Jika tidak ada waktu atau waktu 00:00:00, gunakan waktu sekarang
                $tanggalBayar = now();
            } else {
                $tanggalBayar = $tanggalBayarInput;
            }
        } else {
            // Gunakan waktu real-time sekarang
            $tanggalBayar = now();
        }

        // Selalu buat record baru untuk iuran manual, tidak peduli sudah ada atau belum
        Iuran::create([
            'user_id' => $validated['pegawai_id'],
            'jumlah' => $nominalBaru,
            'bulan' => $bulanFormat,
            'tanggal_bayar' => $tanggalBayar,
            'status' => 'lunas',
            'keterangan' => 'Tambahan manual',
        ]);

        $message = 'Iuran manual berhasil ditambahkan';

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    public function hapusIuran(Request $request)
    {
        $validated = $request->validate([
            'iuran_id' => 'nullable|exists:iurans,id',
            'pegawai_id' => 'required_without:iuran_id|exists:users,id',
            'bulan' => 'required_without:iuran_id|integer|min:1|max:12',
            'tahun' => 'required_without:iuran_id|integer|min:2020',
        ]);

        // Jika ada iuran_id, gunakan itu (untuk menghapus spesifik)
        if (isset($validated['iuran_id'])) {
            $iuran = Iuran::find($validated['iuran_id']);
        } else {
            // Fallback ke cara lama (untuk backward compatibility)
            $bulanFormat = sprintf('%04d-%02d', $validated['tahun'], $validated['bulan']);
            $iuran = Iuran::where('user_id', $validated['pegawai_id'])
                ->where('bulan', $bulanFormat)
                ->orderBy('tanggal_bayar', 'desc')
                ->orderBy('created_at', 'desc')
                ->first();
        }

        if (!$iuran) {
            return response()->json([
                'success' => false,
                'message' => 'Iuran tidak ditemukan'
            ], 404);
        }

        if ($iuran->status !== 'lunas') {
            return response()->json([
                'success' => false,
                'message' => 'Iuran belum dibayar, tidak bisa dihapus'
            ], 400);
        }

        // Hapus record iuran secara permanen (hard delete) karena ini adalah record spesifik
        // Jika ingin soft delete, bisa diubah ke update status
        $iuran->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran iuran berhasil dihapus'
        ]);
    }

    public function getRiwayatIuran($id, Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));

        // Kolom 'bulan' disimpan sebagai string format YYYY-MM, bukan tipe date.
        // Gunakan pencarian prefix tahun agar kompatibel di semua driver DB.
        $riwayat = Iuran::where('user_id', $id)
            ->where('bulan', 'like', $tahun . '-%')
            ->orderBy('bulan', 'asc')
            ->get()
            ->map(function ($iuran) {
                // Parse bulan format YYYY-MM menjadi integer bulan (1-12)
                $bulanParts = explode('-', $iuran->bulan);
                $bulan = (int) $bulanParts[1];

                return [
                    'bulan' => $bulan,
                    'nominal' => $iuran->jumlah,
                    'tanggal_bayar' => $iuran->tanggal_bayar ? $iuran->tanggal_bayar->format('Y-m-d') : null,
                    'status' => $iuran->status,
                ];
            })
            ->toArray();

        return response()->json([
            'success' => true,
            'riwayat' => $riwayat
        ]);
    }

    public function exportIuran(Request $request)
    {
        $bulan = $request->input('bulan', date('n'));
        $tahun = $request->input('tahun', date('Y'));

        // Format bulan untuk query (YYYY-MM)
        $bulanFormat = sprintf('%04d-%02d', $tahun, $bulan);

        // Ambil semua iuran untuk bulan yang dipilih
        $iurans = Iuran::with('user')
            ->where('bulan', $bulanFormat)
            ->whereHas('user', function($query) {
                $query->where('role', 'anggota');
            })
            ->orderBy('tanggal_bayar', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        // Nama file dengan tanggal
        $bulanNama = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                     'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $namaBulan = $bulanNama[$bulan - 1];
        $filename = 'Iuran_Pegawai_' . $namaBulan . '_' . $tahun . '_' . date('YmdHis') . '.csv';

        // Headers untuk download (CSV yang bisa dibuka langsung di Excel)
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
            'Pragma' => 'public',
        ];

        // Callback untuk stream output CSV yang bisa dibuka di Excel
        $callback = function() use ($iurans, $tahun, $namaBulan) {
            $file = fopen('php://output', 'w');

            // BOM UTF-8 untuk Excel agar karakter Indonesia terbaca dengan benar
            fprintf($file, "\xEF\xBB\xBF");

            // Header
            fputcsv($file, ['Laporan Iuran Pegawai - ' . $namaBulan . ' ' . $tahun]);
            fputcsv($file, []); // Baris kosong
            fputcsv($file, ['No', 'Nama Pegawai', 'NIP', 'Jabatan', 'Total Iuran (Rp)', 'Status Pembayaran', 'Tanggal Waktu Pembayaran']);

            $no = 1;
            foreach ($iurans as $iuran) {
                $user = $iuran->user;
                $status = $iuran->status === 'lunas' ? 'Lunas' : 'Belum Lunas';

                // Format tanggal pembayaran
                $tanggalBayar = '-';
                if ($iuran->tanggal_bayar) {
                    $tanggalBayar = $iuran->tanggal_bayar->setTimezone('Asia/Jakarta')->format('d/m/Y H:i');
                }

                // Format nominal dengan titik sebagai pemisah ribuan
                // Menggunakan formula Excel =TEXT() untuk memaksa Excel menampilkan sebagai teks
                // Formula ini akan membuat Excel menampilkan "50.000" tanpa tanda petik
                $nominal = number_format($iuran->jumlah, 0, ',', '.');
                $nominalFormatted = '="' . $nominal . '"';

                fputcsv($file, [
                    $no++,
                    $user->name,
                    $user->nip ?? '-',
                    $user->jabatan ?? '-',
                    $nominalFormatted,
                    $status,
                    $tanggalBayar
                ]);
            }

            // Baris kosong
            fputcsv($file, []);

            // Total
            $totalLunas = $iurans->where('status', 'lunas')->sum('jumlah');
            $jumlahLunas = $iurans->where('status', 'lunas')->count();
            $totalFormatted = number_format($totalLunas, 0, ',', '.');
            fputcsv($file, ['Total Pemasukan (Lunas):', '="Rp ' . $totalFormatted . '"']);
            fputcsv($file, ['Jumlah Pegawai (Lunas):', $jumlahLunas . ' pegawai']);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function downloadPDF($filename)
    {
        $filepath = storage_path('app/public/laporan/' . $filename);
        return redirect()->back()->with('info', 'Fitur download PDF akan tersedia setelah integrasi dengan generator PDF');
    }

    public function laporanKeuangan()
    {
        return view('bendahara_koperasi.laporan_keuangan');
    }
}
