<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * Dashboard Administrator
     */
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_anggota' => User::where('role', 'peminjam')->count(),
            'total_admin' => User::whereIn('role', ['kepala_bps', 'bendahara_koperasi', 'ketua_koperasi'])->count(),
            'new_users_this_month' => User::whereMonth('created_at', now()->month)->count(),
        ];

        $recent_users = User::latest()->take(5)->get(['id', 'name', 'email', 'role', 'created_at']);
        $routePrefix = 'administrator';

        return view('administrator.dashboard', compact('stats', 'recent_users', 'routePrefix'));
    }

    /**
     * Profile Administrator
     */
    public function profile()
    {
        $routePrefix = 'administrator';
        return view('administrator.profile', compact('routePrefix'));
    }

    /**
     * Kelola User
     */
    public function kelolaUser()
    {
        $users = User::latest()->paginate(10);
        $routePrefix = 'administrator';
        return view('administrator.kelola-user', compact('users', 'routePrefix'));
    }

    /**
     * Detail User
     */
    public function detailUser($id)
    {
        $user = User::findOrFail($id);
        $routePrefix = 'administrator';
        return view('administrator.detail-user', compact('user', 'routePrefix'));
    }

    /**
     * Edit User
     */
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $routePrefix = 'administrator';
        return view('administrator.edit-user', compact('user', 'routePrefix'));
    }

    /**
     * Update User
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:peminjam,kepala_bps,bendahara_koperasi,ketua_koperasi,administrator',
            'nip' => 'nullable|string|max:20',
            'golongan' => 'nullable|string|max:50',
            'jabatan' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:15',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user->update($request->only(['name', 'email', 'role', 'nip', 'golongan', 'jabatan', 'phone']));

        return redirect()->route('administrator.kelola-user')->with('success', 'User berhasil diupdate!');
    }

    /**
     * Delete User
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        // Jangan hapus administrator sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri!');
        }

        $user->delete();
        return redirect()->route('administrator.kelola-user')->with('success', 'User berhasil dihapus!');
    }

    /**
     * Tambah User Baru
     */
    public function tambahUser()
    {
        $routePrefix = 'administrator';
        return view('administrator.tambah-user', compact('routePrefix'));
    }

    /**
     * Store User Baru
     */
    public function storeUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:peminjam,kepala_bps,bendahara_koperasi,ketua_koperasi,administrator',
            'nip' => 'nullable|string|max:20',
            'golongan' => 'nullable|string|max:50',
            'jabatan' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:15',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'nip' => $request->nip,
            'golongan' => $request->golongan,
            'jabatan' => $request->jabatan,
            'phone' => $request->phone,
        ]);

        return redirect()->route('administrator.kelola-user')->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Laporan User
     */
    public function laporanUser()
    {
        $users_by_role = User::selectRaw('role, count(*) as total')
            ->groupBy('role')
            ->get();

        $users_by_month = User::selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, count(*) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('month', 'year')
            ->orderBy('month')
            ->get();

        $routePrefix = 'administrator';
        return view('administrator.laporan-user', compact('users_by_role', 'users_by_month', 'routePrefix'));
    }

    /**
     * Transparansi Keuangan
     */
    public function transparansi()
    {
        $routePrefix = 'administrator';
        return view('administrator.transparansi', compact('routePrefix'));
    }
}
