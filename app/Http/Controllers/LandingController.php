<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

        $staf = [
            [
                'nama' => 'Budi Santoso',
                'jabatan' => 'Ketua Koperasi',
                'foto' => 'https://ui-avatars.com/api/?name=Budi+Santoso&size=150'
            ],
            [
                'nama' => 'Siti Nurhaliza',
                'jabatan' => 'Bendahara Koperasi',
                'foto' => 'https://ui-avatars.com/api/?name=Siti+Nurhaliza&size=150'
            ],
            [
                'nama' => 'Ahmad Rizki',
                'jabatan' => 'Kepala BPS',
                'foto' => 'https://ui-avatars.com/api/?name=Ahmad+Rizki&size=150'
            ]
        ];

        return view('landing', compact('profil', 'staf'));
    }
}
