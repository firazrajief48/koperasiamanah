<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pinjaman;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class KepalaKoperasiController extends Controller
{
    public function dashboard()
    {
        // Tampilkan hanya pengajuan yang sudah disetujui bendahara dan menunggu persetujuan ketua
        $pinjamans = Pinjaman::with('user')
            ->where('status_detail', 'menunggu_persetujuan_ketua')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('ketua_koperasi.dashboard', compact('pinjamans'));
    }

    public function detailPengajuan($id)
    {
        $pinjaman = Pinjaman::with('user')->findOrFail($id);

        // Pastikan pinjaman ini sudah disetujui bendahara dan menunggu persetujuan ketua
        if ($pinjaman->status_detail !== 'menunggu_persetujuan_ketua') {
            abort(403, 'Pengajuan ini tidak dalam status menunggu persetujuan ketua koperasi');
        }

        $user = $pinjaman->user;

        // Format data sesuai dengan struktur yang diharapkan view
        $pengajuan = [
            'id' => $pinjaman->id,
            'nama' => $user->name,
            'nip' => $user->nip ?? '-',
            'jabatan' => $user->jabatan ?? '-',
            'golongan' => $user->golongan ?? '-',
            'no_hp' => $user->phone ?? '-',
            'email' => $user->email,
            'jumlah_pinjaman' => (float) $pinjaman->jumlah_pinjaman,
            'tenor_bulan' => (int) $pinjaman->tenor_bulan,
            'berapa_kali' => (int) $pinjaman->tenor_bulan . ' kali',
            'metode_pembayaran' => $pinjaman->metode_pembayaran ?? 'Potong Gaji Pokok',
            'tanggal_pengajuan' => $pinjaman->created_at->format('Y-m-d'),
            'gaji_pokok' => (float) $pinjaman->gaji_pokok,
            'sisa_gaji' => (float) $pinjaman->sisa_gaji,
            'tujuan' => $pinjaman->keterangan ?? '-',
            'angsuran_per_bulan' => (float) $pinjaman->cicilan_per_bulan,
            'status' => 'Menunggu Persetujuan',
            'status_detail' => $pinjaman->status_detail,
        ];

        return view('ketua_koperasi.detail', compact('pengajuan'));
    }

    public function laporanPinjaman()
    {
        // Ambil semua pinjaman yang sudah keluar dari antrian ketua (sudah disetujui atau ditolak ketua)
        // atau yang masih menunggu verifikasi kepala
        $pinjamans = Pinjaman::with('user')
            ->whereIn('status_detail', ['menunggu_persetujuan_kepala', 'ditolak', 'disetujui', 'lunas'])
            ->orderBy('created_at', 'desc')
            ->get();

        $laporan = [];
        foreach ($pinjamans as $p) {
            // Mapping status untuk tampilan
            $statusLabel = '';
            switch ($p->status_detail) {
                case 'menunggu_persetujuan_kepala':
                    $statusLabel = 'Sedang Diverifikasi Kepala BPS Kota Surabaya';
                    break;
                case 'ditolak':
                    $statusLabel = 'Ditolak';
                    break;
                case 'disetujui':
                    $statusLabel = 'Diverifikasi';
                    break;
                case 'lunas':
                    $statusLabel = 'Diverifikasi';
                    break;
                default:
                    $statusLabel = ucfirst($p->status);
            }

            $laporan[] = [
                'id' => $p->id,
                'nama' => $p->user->name,
                'jumlah' => (float) $p->jumlah_pinjaman,
                'status' => $statusLabel,
                'tanggal' => $p->created_at->toDateString(),
                // Detail untuk modal
                'nip' => $p->user->nip ?? '-',
                'jabatan' => $p->user->jabatan ?? '-',
                'golongan' => $p->user->golongan ?? '-',
                'no_hp' => $p->user->phone ?? '-',
                'email' => $p->user->email,
                'tenor' => $p->tenor_bulan,
                'metode_pembayaran' => $p->metode_pembayaran === 'potong_gaji' ? 'Potong Gaji Pokok' : ($p->metode_pembayaran === 'potong_tunjangan' ? 'Potong Tunjangan Kinerja' : 'Potong Gaji Pokok'),
                'tujuan' => $p->keterangan ?? '-',
                'angsuran' => $this->generateAngsuran((float) $p->jumlah_pinjaman, (int) $p->tenor_bulan),
                // Verifikasi detail
                'verifier_name' => $p->disetujui_oleh,
                'tanggal_verifikasi' => optional($p->tanggal_persetujuan)->format('d/m/Y H:i'),
                'gaji_pokok' => $p->gaji_pokok,
                'sisa_gaji' => $p->sisa_gaji,
                'catatan_verifikasi' => $p->alasan_penolakan,
                'status_detail' => $p->status_detail,
            ];
        }

        return view('ketua_koperasi.laporan', compact('laporan'));
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

        return view('ketua_koperasi.transparansi', compact('pinjaman'));
    }

    public function submitVerifikasi(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer|exists:pinjamans,id',
            'catatan' => 'nullable|string|max:1000',
            'aksi' => 'required|in:setujui,tolak',
        ]);

        $pinjaman = Pinjaman::findOrFail($validated['id']);

        // Pastikan pinjaman ini dalam status yang benar
        if ($pinjaman->status_detail !== 'menunggu_persetujuan_ketua') {
            return response()->json([
                'success' => false,
                'message' => 'Pengajuan ini tidak dalam status menunggu persetujuan ketua koperasi'
            ], 403);
        }

        if ($validated['aksi'] === 'setujui') {
            $pinjaman->status = 'menunggu';
            $pinjaman->status_detail = 'menunggu_persetujuan_kepala';
            $pinjaman->alasan_penolakan = null;
            // Simpan nama ketua yang memverifikasi
            $pinjaman->disetujui_oleh = auth()->user()->name;
            $pinjaman->tanggal_persetujuan = now();
        } else {
            $request->validate(['catatan' => 'required|string|max:1000']);
            $pinjaman->status = 'menunggu';
            $pinjaman->status_detail = 'ditolak';
            $pinjaman->alasan_penolakan = $validated['catatan'];
            // Simpan nama ketua yang menolak
            $pinjaman->disetujui_oleh = auth()->user()->name;
            $pinjaman->tanggal_persetujuan = now();
        }

        $pinjaman->save();

        return response()->json([
            'success' => true,
            'message' => $validated['aksi'] === 'setujui'
                ? 'Pengajuan diteruskan ke Kepala BPS.'
                : 'Pengajuan ditolak dengan alasan tersimpan.',
        ]);
    }

    public function profile()
    {
        $user = auth()->user();
        return view('ketua_koperasi.profile', compact('user'));
    }

    /**
     * Update Profile Ketua Koperasi
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

        return redirect()->route('ketua_koperasi.profile')->with('success', 'Profile berhasil diupdate!');
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
}
