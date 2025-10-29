<?php

namespace App\Http\Controllers;

use App\Models\Pinjaman;
use App\Models\Pembayaran;
use App\Models\User;
use App\Helpers\AngsuranHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PeminjamController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();

        // Get active loan data if exists
        $activeLoan = $user->pinjamans()
            ->where('status', 'disetujui')
            ->with('pembayarans')
            ->orderBy('created_at', 'desc')
            ->first();

        // Get upcoming payments
        $pembayaranMendatang = collect();
        if ($activeLoan) {
            $pembayaranMendatang = $activeLoan->pembayarans()
                ->where('status', 'belum_bayar')
                ->where('tanggal_jatuh_tempo', '<=', now()->addDays(7))
                ->get();
        }

        // Calculate data from user relationships
        $data = [
            'nama' => $user->name,
            'nip' => $user->nip ?? '-',
            'kas_pribadi' => $user->total_iuran,
            'jumlah_pinjaman' => $user->total_pinjaman,
            'sisa_pinjaman' => $user->sisa_pinjaman,
            'simulasi' => [],
        ];

        // If there's an active loan, show simulation
        if ($activeLoan) {
            $simulasi = [];
            for ($i = 1; $i <= $activeLoan->tenor_bulan; $i++) {
                $totalPaid = ($i - 1) * $activeLoan->cicilan_per_bulan;
                $sisa = $activeLoan->jumlah_pinjaman - $totalPaid;

                $simulasi[] = [
                    'bulan' => $i,
                    'angsuran' => $activeLoan->cicilan_per_bulan,
                    'sisa' => max(0, $sisa),
                ];
            }
            $data['simulasi'] = $simulasi;
        }

        return view('anggota.dashboard', compact('data', 'activeLoan', 'pembayaranMendatang'));
    }

    public function ajukanPinjaman()
    {
        $user = auth()->user();

        $anggota = [
            'nama' => $user->name,
            'nip' => $user->nip ?? '-',
            'jabatan' => $user->jabatan ?? '-',
            'golongan' => $user->golongan ?? '-',
            'no_hp' => $user->phone ?? '-',
            'email' => $user->email
        ];

        return view('anggota.ajukan', compact('anggota'));
    }

    public function storePinjaman(Request $request)
    {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'jumlah_pinjaman' => 'required|numeric|min:3000000|max:10000000',
            'tenor_cicilan' => 'required|integer|min:2|max:20',
            'metode_pembayaran' => 'required|in:potong_gaji,potong_tukin',
            'keperluan' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Hitung cicilan per bulan menggunakan AngsuranHelper
        $jumlahPinjaman = $request->jumlah_pinjaman;
        $tenorBulan = $request->tenor_cicilan;


        // Validasi kombinasi pinjaman dan tenor
        if (!AngsuranHelper::isValidKombinasi($jumlahPinjaman, $tenorBulan)) {
            return back()->withErrors(['tenor_cicilan' => 'Kombinasi jumlah pinjaman dan tenor tidak valid'])->withInput();
        }

        $cicilanPerBulan = AngsuranHelper::getAngsuran($jumlahPinjaman, $tenorBulan);

        // Hitung biaya admin (5%)
        $biayaAdmin = AngsuranHelper::hitungAdministrasi($jumlahPinjaman);
        $jumlahDiterima = AngsuranHelper::hitungTerima($jumlahPinjaman);

        // Simpan data pinjaman
        $pinjaman = Pinjaman::create([
            'user_id' => $user->id,
            'jumlah_pinjaman' => $jumlahPinjaman,
            'tenor_bulan' => $tenorBulan,
            'cicilan_per_bulan' => $cicilanPerBulan,
            'bulan_terbayar' => 0,
            'sisa_pinjaman' => $jumlahPinjaman,
            'gaji_pokok' => 0, // Bisa diisi nanti jika diperlukan
            'metode_pembayaran' => $request->metode_pembayaran,
            'status' => 'menunggu',
            'status_detail' => 'menunggu_persetujuan_bendahara',
            'keterangan' => $request->keperluan,
        ]);

        // Generate jadwal pembayaran bulanan berdasarkan tenor
        try {
            $this->generatePembayaranBulanan($pinjaman->id);
        } catch (\Throwable $e) {
            // Abaikan jika tabel pembayaran belum ada; proses pengajuan tetap lanjut
        }

        return redirect()->route('anggota.riwayat')->with('success', 'Pengajuan pinjaman berhasil disimpan! Pinjaman Anda akan segera diproses oleh tim koperasi.');
    }

    /**
     * Generate pembayaran bulanan untuk pinjaman
     */
    public function generatePembayaranBulanan($pinjamanId)
    {
        $pinjaman = Pinjaman::findOrFail($pinjamanId);

        // Hapus pembayaran lama jika ada
        Pembayaran::where('pinjaman_id', $pinjamanId)->delete();

        // Generate pembayaran untuk setiap bulan
        for ($bulan = 1; $bulan <= $pinjaman->tenor_bulan; $bulan++) {
            $tanggalJatuhTempo = $pinjaman->created_at->addMonths($bulan);

            Pembayaran::create([
                'pinjaman_id' => $pinjamanId,
                'bulan_ke' => $bulan,
                'nominal_pembayaran' => $pinjaman->cicilan_per_bulan,
                'tanggal_jatuh_tempo' => $tanggalJatuhTempo,
                'status' => 'belum_bayar',
            ]);
        }
    }

    public function riwayatPinjaman()
    {
        $user = auth()->user();

        // Get all loans for the current user
        $pinjamans = Pinjaman::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('anggota.riwayat', compact('pinjamans'));
    }

    public function transparansi()
    {
        // Get cumulative financial data for peminjam (anggota)
        $totalPinjamanDisalurkan = Pinjaman::whereIn('status', ['disetujui', 'lunas'])->sum('jumlah_pinjaman');
        $totalPinjamanDilunasi = Pinjaman::where('status', 'lunas')->sum('jumlah_pinjaman');
        $saldoPinjamanBerjalan = Pinjaman::where('status', 'disetujui')->sum('sisa_pinjaman');

        $dataKumulatif = [
            'total_pinjaman_disalurkan' => $totalPinjamanDisalurkan,
            'total_pinjaman_dilunasi' => $totalPinjamanDilunasi,
            'saldo_pinjaman_berjalan' => $saldoPinjamanBerjalan,
            'total_anggota' => User::where('role', 'anggota')->count(),
            'pinjaman_aktif' => Pinjaman::where('status', 'disetujui')->count(),
            'pinjaman_lunas' => Pinjaman::where('status', 'lunas')->count()
        ];

        return view('anggota.transparansi', compact('dataKumulatif'));
    }

    public function profile()
    {
        $user = auth()->user();
        return view('anggota.profile', compact('user'));
    }

    /**
     * Update Profile Peminjam
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

        return redirect()->route('anggota.profile')->with('success', 'Profile berhasil diupdate!');
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
