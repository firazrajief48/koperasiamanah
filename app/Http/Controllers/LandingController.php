<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengurusKoperasi;

class LandingController extends Controller
{
    public function index()
    {
        $profil = [
            'nama' => 'Koperasi Amanah',
            'deskripsi' => 'Koperasi yang bergerak dalam bidang simpan pinjam untuk kesejahteraan anggota',
            'visi' => 'Menjadi koperasi terpercaya dan terdepan dalam pelayanan simpan pinjam',
            'misi' => [
                'Memberikan layanan simpan pinjam yang mudah dan terpercaya',
                'Meningkatkan kesejahteraan anggota koperasi',
                'Mengelola keuangan secara profesional dan transparan'
            ]
        ];

        // Ambil data pengurus dari database
        $staf = PengurusKoperasi::aktif()->urut()->get()->map(function($pengurus) {
            $fotoUrl = null;

            // Cek apakah foto ada dan file benar-benar ada
            if ($pengurus->foto && file_exists(public_path('storage/' . $pengurus->foto))) {
                $fotoUrl = asset('storage/' . $pengurus->foto) . '?v=' . time();
            }

            return [
                'nama' => $pengurus->nama,
                'jabatan' => $pengurus->jabatan,
                'deskripsi' => $pengurus->deskripsi,
                'foto' => $fotoUrl ?: 'https://ui-avatars.com/api/?name=' . urlencode($pengurus->nama) . '&size=150&background=1e40af&color=ffffff'
            ];
        })->toArray();

        return view('landing', compact('profil', 'staf'));
    }
}
