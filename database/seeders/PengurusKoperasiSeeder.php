<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PengurusKoperasi;

class PengurusKoperasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pengurus = [
            [
                'nama' => 'Dr. Ahmad Rizki, S.Si., M.Si.',
                'jabatan' => 'Kepala BPS',
                'deskripsi' => 'Memimpin dengan visi yang jelas dan dedikasi tinggi untuk kemajuan koperasi',
                'email' => 'ahmad.rizki@bps.go.id',
                'telepon' => '081234567890',
                'urutan' => 1,
                'aktif' => true
            ],
            [
                'nama' => 'Budi Santoso, S.E.',
                'jabatan' => 'Ketua Koperasi',
                'deskripsi' => 'Memimpin koperasi dengan integritas dan komitmen untuk kesejahteraan anggota',
                'email' => 'budi.santoso@koperasi.com',
                'telepon' => '081234567891',
                'urutan' => 2,
                'aktif' => true
            ],
            [
                'nama' => 'Siti Nurhaliza, S.E., M.M.',
                'jabatan' => 'Wakil Ketua Koperasi',
                'deskripsi' => 'Mendukung kepemimpinan dengan pengalaman dan dedikasi yang tinggi',
                'email' => 'siti.nurhaliza@koperasi.com',
                'telepon' => '081234567892',
                'urutan' => 3,
                'aktif' => true
            ],
            [
                'nama' => 'Rina Pratiwi, S.H.',
                'jabatan' => 'Sekretaris Koperasi',
                'deskripsi' => 'Mengorganisir administrasi dengan profesional dan teliti',
                'email' => 'rina.pratiwi@koperasi.com',
                'telepon' => '081234567893',
                'urutan' => 4,
                'aktif' => true
            ],
            [
                'nama' => 'Dedi Kurniawan, S.E.',
                'jabatan' => 'Bendahara Koperasi 1',
                'deskripsi' => 'Mengelola keuangan dengan transparansi dan akuntabilitas tinggi',
                'email' => 'dedi.kurniawan@koperasi.com',
                'telepon' => '081234567894',
                'urutan' => 5,
                'aktif' => true
            ],
            [
                'nama' => 'Citra Dewi, S.Ak.',
                'jabatan' => 'Bendahara Koperasi 2',
                'deskripsi' => 'Mendukung pengelolaan keuangan dengan keahlian akuntansi yang mumpuni',
                'email' => 'citra.dewi@koperasi.com',
                'telepon' => '081234567895',
                'urutan' => 6,
                'aktif' => true
            ],
            [
                'nama' => 'Andi Wijaya, S.T., M.M.',
                'jabatan' => 'Bidang Usaha Koperasi',
                'deskripsi' => 'Mengembangkan usaha koperasi dengan inovasi dan strategi bisnis yang tepat',
                'email' => 'andi.wijaya@koperasi.com',
                'telepon' => '081234567896',
                'urutan' => 7,
                'aktif' => true
            ],
            [
                'nama' => 'Eko Prasetyo, S.Kom.',
                'jabatan' => 'Administrator Koperasi',
                'deskripsi' => 'Mengelola sistem informasi dan teknologi untuk mendukung operasional koperasi',
                'email' => 'eko.prasetyo@koperasi.com',
                'telepon' => '081234567897',
                'urutan' => 8,
                'aktif' => true
            ]
        ];

        foreach ($pengurus as $data) {
            PengurusKoperasi::create($data);
        }
    }
}
