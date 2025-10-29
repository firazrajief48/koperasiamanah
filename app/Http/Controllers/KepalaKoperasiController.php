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
            'metode_pembayaran' => 'Potong Gaji Pokok',
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

        return view('ketua_koperasi.transparansi', compact('pinjaman'));
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
