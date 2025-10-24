<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class BendaharaKantorController extends Controller
{
    public function dashboard()
    {
        $pengajuan = [
            ['id' => 1, 'nama' => 'Andi Wijaya', 'jumlah' => 20000000, 'tanggal' => '2024-09-15', 'status' => 'Menunggu'],
            ['id' => 2, 'nama' => 'Citra Dewi', 'jumlah' => 25000000, 'tanggal' => '2024-09-20', 'status' => 'Menunggu'],
            ['id' => 3, 'nama' => 'Eka Putri', 'jumlah' => 12000000, 'tanggal' => '2024-09-25', 'status' => 'Diverifikasi'],
        ];

    return view('kepala_bps.dashboard', compact('pengajuan'));
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
            'tujuan' => 'Renovasi rumah dan kebutuhan mendesak',
            'status' => 'Menunggu Verifikasi'
        ];

    return view('kepala_bps.detail', compact('pengajuan'));
    }

    public function laporanPinjaman()
    {
        $laporan = [
            ['id' => 1, 'nama' => 'Andi Wijaya', 'nip' => '199001012020', 'jumlah' => 20000000, 'tanggal_verifikasi' => '2024-09-16 10:30:00', 'verifikator' => 'Ahmad Rizki', 'gaji_pokok' => 8000000, 'sisa_gaji' => 5500000],
            ['id' => 2, 'nama' => 'Budi Santoso', 'nip' => '199002022021', 'jumlah' => 15000000, 'tanggal_verifikasi' => '2024-08-20 14:15:00', 'verifikator' => 'Ahmad Rizki', 'gaji_pokok' => 7500000, 'sisa_gaji' => 5000000],
            ['id' => 3, 'nama' => 'Citra Dewi', 'nip' => '199003032022', 'jumlah' => 25000000, 'tanggal_verifikasi' => '2024-09-21 09:00:00', 'verifikator' => 'Ahmad Rizki', 'gaji_pokok' => 9000000, 'sisa_gaji' => 6000000],
        ];

    return view('kepala_bps.laporan', compact('laporan'));
    }

    public function transparansi()
    {
        $pinjaman = [
            ['nama' => 'Andi Wijaya', 'nip' => '199001012020', 'jumlah' => 20000000, 'sisa' => 12000000, 'status' => 'Belum Lunas'],
            ['nama' => 'Budi Santoso', 'nip' => '199002022021', 'jumlah' => 15000000, 'sisa' => 0, 'status' => 'Lunas'],
            ['nama' => 'Citra Dewi', 'nip' => '199003032022', 'jumlah' => 25000000, 'sisa' => 18000000, 'status' => 'Belum Lunas'],
            ['nama' => 'Dedi Kurniawan', 'nip' => '199004042023', 'jumlah' => 18000000, 'sisa' => 5000000, 'status' => 'Belum Lunas'],
            ['nama' => 'Eka Putri', 'nip' => '199005052024', 'jumlah' => 12000000, 'sisa' => 0, 'status' => 'Lunas'],
        ];

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
