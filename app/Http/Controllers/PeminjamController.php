<?php

namespace App\Http\Controllers;

use App\Models\Pinjaman;
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
            ->orderBy('created_at', 'desc')
            ->first();

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

        return view('peminjam.dashboard', compact('data'));
    }

    public function ajukanPinjaman()
    {
        $user = auth()->user();

        $peminjam = [
            'nama' => $user->name,
            'nip' => $user->nip ?? '-',
            'jabatan' => $user->jabatan ?? '-',
            'golongan' => $user->golongan ?? '-',
            'no_hp' => $user->phone ?? '-',
            'email' => $user->email
        ];

        return view('peminjam.ajukan', compact('peminjam'));
    }

    public function riwayatPinjaman()
    {
        $user = auth()->user();

        // Get all loans for the current user
        $pinjamans = Pinjaman::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $riwayat = [];
        foreach ($pinjamans as $p) {
            $riwayat[] = [
                'id' => $p->id,
                'tanggal' => $p->created_at->format('Y-m-d'),
                'jumlah' => $p->jumlah_pinjaman,
                'tenor' => $p->tenor_bulan . ' Bulan',
                'status' => ucfirst($p->status),
                'sisa' => $p->sisa_pinjaman
            ];
        }

        return view('peminjam.riwayat', compact('riwayat'));
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
                'nama' => $p->user->name,
                'nip' => $p->user->nip ?? '-',
                'jumlah' => $p->jumlah_pinjaman,
                'sisa' => $p->sisa_pinjaman,
                'status' => $statusLabel
            ];
        }

        return view('peminjam.transparansi', compact('pinjaman'));
    }

    public function profile()
    {
        $user = auth()->user();
        return view('peminjam.profile', compact('user'));
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

        return redirect()->route('peminjam.profile')->with('success', 'Profile berhasil diupdate!');
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
