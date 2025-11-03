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
        try {
            // Validasi dengan pesan error yang lebih jelas
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'nip' => 'required|string|max:20',
                'golongan' => 'required|string|max:50',
                'jabatan' => 'required|string|max:100',
                'phone' => 'required|string|max:15|regex:/^[0-9]+$/',
                'role' => 'required|in:anggota', // Only allow anggota registration
            ], [
                'name.required' => 'Nama lengkap wajib diisi.',
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email sudah terdaftar. Silakan gunakan email lain.',
                'password.required' => 'Password wajib diisi.',
                'password.min' => 'Password minimal 8 karakter.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
                'nip.required' => 'NIP wajib diisi.',
                'nip.max' => 'NIP maksimal 20 karakter.',
                'golongan.required' => 'Golongan wajib diisi.',
                'jabatan.required' => 'Jabatan wajib diisi.',
                'phone.required' => 'Nomor HP wajib diisi.',
                'phone.regex' => 'Nomor HP hanya boleh berisi angka.',
                'phone.max' => 'Nomor HP maksimal 15 karakter.',
                'role.required' => 'Role wajib diisi.',
                'role.in' => 'Hanya anggota yang dapat mendaftar.',
            ]);

            // Check if role is anggota (only allowed role for registration)
            if ($request->role !== 'anggota') {
                return back()->withErrors([
                    'role' => 'Hanya anggota yang dapat mendaftar melalui form ini.',
                ])->withInput()->with('showModal', true)->with('showRegisterTab', true);
            }

            // Create user
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'anggota', // Force role to anggota
                'nip' => $validated['nip'],
                'golongan' => $validated['golongan'],
                'jabatan' => $validated['jabatan'],
                'phone' => $validated['phone'],
            ]);

            // Login user automatically
            Auth::login($user);

            // Redirect to dashboard
            return $this->redirectToRole($user);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation errors - redirect back with errors and show register tab
            return back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('showModal', true)
                ->with('showRegisterTab', true);
        } catch (\Exception $e) {
            // Other errors
            return back()->withErrors([
                'general' => 'Terjadi kesalahan saat mendaftar: ' . $e->getMessage(),
            ])->withInput()->with('showModal', true)->with('showRegisterTab', true);
        }
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
