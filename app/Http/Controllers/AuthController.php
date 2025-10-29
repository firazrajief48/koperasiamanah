<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show login form - redirect to landing page
     */
    public function showLogin()
    {
        return redirect('/');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirect based on user role
            return $this->redirectToRole($user);
        }

        // Return with error but don't redirect - stay on same page
        return back()->withErrors([
            'email' => 'Email atau Password yang Anda masukkan salah.',
        ])->withInput($request->only('email'))->with('showModal', true);
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Show registration form - redirect to landing page
     */
    public function showRegister()
    {
        return redirect('/');
    }

    /**
     * Handle registration request - only for peminjam (anggota)
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nip' => 'required|string|max:20',
            'golongan' => 'required|string|max:50',
            'jabatan' => 'required|string|max:100',
            'phone' => 'required|string|max:15',
            'role' => 'required|in:anggota', // Only allow anggota registration
        ]);

        // Check if role is anggota (only allowed role for registration)
        if ($request->role !== 'anggota') {
            return back()->withErrors([
                'role' => 'Hanya anggota yang dapat mendaftar melalui form ini.',
            ])->withInput()->with('showModal', true);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'anggota', // Force role to anggota
            'nip' => $request->nip,
            'golongan' => $request->golongan,
            'jabatan' => $request->jabatan,
            'phone' => $request->phone,
        ]);

        Auth::login($user);

        return $this->redirectToRole($user);
    }

    /**
     * Clear modal session flag
     */
    public function clearModalSession(Request $request)
    {
        $request->session()->forget('showModal');
        return response()->json(['success' => true]);
    }

    /**
     * Redirect user based on their role
     */
    private function redirectToRole(User $user)
    {
        switch ($user->role) {
            case 'anggota':
                return redirect()->route('anggota.dashboard');
            case 'kepala_bps':
                return redirect()->route('kepala_bps.dashboard');
            case 'bendahara_koperasi':
                return redirect()->route('bendahara_koperasi.dashboard');
            case 'ketua_koperasi':
                return redirect()->route('ketua_koperasi.dashboard');
            case 'administrator':
                return redirect()->route('administrator.dashboard');
            default:
                return redirect('/');
        }
    }
}
