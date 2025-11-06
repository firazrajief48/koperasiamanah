<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pinjaman;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class BendaharaKantorController extends Controller
{
    public function dashboard()
    {
        // Tampilkan hanya pengajuan yang sudah disetujui ketua koperasi dan menunggu persetujuan kepala BPS
        $pinjamans = Pinjaman::with('user')
            ->where('status_detail', 'menunggu_persetujuan_kepala')
            ->orderBy('created_at', 'desc')
            ->get();

        // Format data untuk view
        $pengajuan = [];
        foreach ($pinjamans as $p) {
            $pengajuan[] = [
                'id' => $p->id,
                'nama' => $p->user->name,
                'jumlah' => $p->jumlah_pinjaman,
                'tanggal' => $p->created_at->format('Y-m-d'),
                'status' => 'Menunggu'
            ];
        }

        return view('kepala_bps.dashboard', compact('pengajuan'));
    }

    public function detailPengajuan($id)
    {
        $pinjaman = Pinjaman::with('user')->findOrFail($id);

        // Pastikan pinjaman ini sudah disetujui ketua dan menunggu persetujuan kepala BPS
        if ($pinjaman->status_detail !== 'menunggu_persetujuan_kepala') {
            abort(403, 'Pengajuan ini tidak dalam status menunggu persetujuan kepala BPS');
        }

        $user = $pinjaman->user;

        // Format data sesuai dengan struktur yang diharapkan view
        $pengajuan = [
            'id' => $pinjaman->id,
            'nama' => $user->name,
            'nip' => $user->nip ?? 'N/A',
            'jabatan' => $user->jabatan ?? 'N/A',
            'golongan' => $user->golongan ?? 'N/A',
            'no_hp' => $user->phone ?? 'N/A',
            'email' => $user->email,
            'jumlah_pinjaman' => $pinjaman->jumlah_pinjaman,
            'metode_pembayaran' => $pinjaman->metode_pembayaran === 'potong_gaji' ? 'Potong Gaji Pokok' : 'Potong Tunjangan Kinerja',
            'tanggal_pengajuan' => $pinjaman->created_at->format('Y-m-d'),
            'tujuan' => $pinjaman->keterangan ?? 'Tidak ada keterangan',
            'status' => 'Menunggu Verifikasi Kepala BPS',
            'gaji_pokok' => $pinjaman->gaji_pokok,
            'sisa_gaji' => $pinjaman->sisa_gaji,
            'tenor_bulan' => $pinjaman->tenor_bulan,
            'cicilan_per_bulan' => $pinjaman->cicilan_per_bulan,
            'disetujui_oleh' => $pinjaman->disetujui_oleh,
            'tanggal_persetujuan' => $pinjaman->tanggal_persetujuan,
        ];

        return view('kepala_bps.detail', compact('pengajuan'));
    }

    public function laporanPinjaman()
    {
        // Ambil semua pinjaman yang sudah keluar dari antrian kepala BPS (sudah disetujui atau ditolak kepala)
        // atau yang sudah disetujui dan dalam proses pembayaran
        $pinjamans = Pinjaman::with('user')
            ->whereIn('status_detail', ['disetujui', 'lunas', 'ditolak'])
            ->orderBy('created_at', 'desc')
            ->get();

        $laporan = [];
        foreach ($pinjamans as $p) {
            // Mapping status untuk tampilan
            $statusLabel = '';
            switch ($p->status_detail) {
                case 'disetujui':
                    $statusLabel = 'Diverifikasi';
                    break;
                case 'lunas':
                    $statusLabel = 'Diverifikasi';
                    break;
                case 'ditolak':
                    $statusLabel = 'Ditolak';
                    break;
                default:
                    $statusLabel = ucfirst($p->status);
            }

            // Hitung angsuran untuk detail modal
            $angsuran = [];
            if ($p->tenor_bulan > 0 && $p->cicilan_per_bulan > 0) {
                $sisaPinjaman = $p->jumlah_pinjaman;
                for ($i = 1; $i <= $p->tenor_bulan; $i++) {
                    $sisaPinjaman -= $p->cicilan_per_bulan;
                    if ($sisaPinjaman < 0) $sisaPinjaman = 0;
                    $angsuran[] = [
                        'bulan' => $i,
                        'nominal' => round($p->cicilan_per_bulan),
                        'sisa' => round($sisaPinjaman)
                    ];
                }
            }

            // Tentukan role verifikator berdasarkan nama
            $verifikatorRole = 'N/A';
            if ($p->disetujui_oleh) {
                $verifikatorUser = \App\Models\User::where('name', $p->disetujui_oleh)->first();
                if ($verifikatorUser) {
                    switch ($verifikatorUser->role) {
                        case 'bendahara_koperasi':
                            $verifikatorRole = 'Bendahara Koperasi';
                            break;
                        case 'ketua_koperasi':
                            $verifikatorRole = 'Ketua Koperasi';
                            break;
                        case 'kepala_bps':
                            $verifikatorRole = 'Kepala BPS';
                            break;
                        default:
                            $verifikatorRole = 'N/A';
                    }
                }
            }

            $laporan[] = [
                'id' => $p->id,
                'nama' => $p->user->name,
                'nip' => $p->user->nip ?? 'N/A',
                'jumlah' => $p->jumlah_pinjaman,
                'tanggal_verifikasi' => $p->tanggal_persetujuan 
                    ? $p->tanggal_persetujuan->format('Y-m-d H:i:s') 
                    : null,
                'tanggal_pengajuan' => $p->created_at->format('Y-m-d'),
                'verifikator' => $p->disetujui_oleh ?? 'N/A',
                'verifikator_role' => $verifikatorRole,
                'gaji_pokok' => $p->gaji_pokok ?? null,
                'sisa_gaji' => $p->sisa_gaji ?? null,
                'status' => $statusLabel,
                'status_detail' => $p->status_detail,
                'metode_pembayaran' => $p->metode_pembayaran === 'potong_gaji' ? 'Potong Gaji Pokok' : 'Potong Tunjangan Kinerja',
                'tenor_bulan' => $p->tenor_bulan,
                'cicilan_per_bulan' => $p->cicilan_per_bulan,
                'keterangan' => $p->keterangan ?? 'Tidak ada keterangan',
                'alasan_penolakan' => $p->alasan_penolakan,
                'jabatan' => $p->user->jabatan ?? 'N/A',
                'golongan' => $p->user->golongan ?? 'N/A',
                'phone' => $p->user->phone ?? 'N/A',
                'email' => $p->user->email,
                'angsuran' => $angsuran,
            ];
        }

        return view('kepala_bps.laporan', compact('laporan'));
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
        if ($pinjaman->status_detail !== 'menunggu_persetujuan_kepala') {
            return response()->json([
                'success' => false,
                'message' => 'Pengajuan ini tidak dalam status menunggu persetujuan kepala BPS'
            ], 403);
        }

        if ($validated['aksi'] === 'setujui') {
            $pinjaman->status = 'disetujui';
            $pinjaman->status_detail = 'disetujui';
            $pinjaman->alasan_penolakan = null;
            // Simpan nama kepala BPS yang memverifikasi
            $pinjaman->disetujui_oleh = auth()->user()->name;
            $pinjaman->tanggal_persetujuan = now();
        } else {
            $request->validate(['catatan' => 'required|string|max:1000']);
            $pinjaman->status = 'ditolak';
            $pinjaman->status_detail = 'ditolak';
            $pinjaman->alasan_penolakan = $validated['catatan'];
            // Simpan nama kepala BPS yang menolak
            $pinjaman->disetujui_oleh = auth()->user()->name;
            $pinjaman->tanggal_persetujuan = now();
        }

        $pinjaman->save();

        return response()->json([
            'success' => true,
            'message' => $validated['aksi'] === 'setujui'
                ? 'Pengajuan berhasil disetujui.'
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

        return view('kepala_bps.transparansi', compact('pinjaman'));
    }

    public function profile()
    {
        $user = auth()->user();
        return view('kepala_bps.profile', compact('user'));
    }

    /**
     * Update Profile Kepala BPS
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

        return redirect()->route('kepala_bps.profile')->with('success', 'Profile berhasil diupdate!');
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
