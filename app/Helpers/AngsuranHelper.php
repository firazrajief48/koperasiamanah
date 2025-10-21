<?php

namespace App\Helpers;

class AngsuranHelper
{
    // Data tabel pinjaman dan angsuran
    private static $tabelAngsuran = [
        3000000 => [
            2 => 1500000,
            3 => 1000000,
            4 => 750000,
            5 => 600000,
            6 => 583333,
            7 => 500000,
            8 => 500000,
            9 => 500000,
            10 => 500000,
            11 => 500000,
            12 => 500000,
            15 => 466667,
            16 => 500000,
            17 => 529412,
            18 => 500000,
            19 => 526316,
            20 => 500000
        ],
        3500000 => [
            2 => 1750000,
            3 => 1166667,
            4 => 875000,
            5 => 700000,
            6 => 666667,
            7 => 571429,
            8 => 500000,
            9 => 500000,
            10 => 500000,
            11 => 500000,
            12 => 500000,
            15 => 466667,
            16 => 500000,
            17 => 529412,
            18 => 500000
        ],
        4000000 => [
            2 => 2000000,
            3 => 1333333,
            4 => 1000000,
            5 => 800000,
            6 => 750000,
            7 => 642857,
            8 => 562500,
            9 => 555556,
            10 => 550000,
            11 => 545455,
            12 => 583333,
            15 => 533333,
            16 => 500000,
            17 => 529412,
            18 => 500000
        ],
        4500000 => [
            2 => 2250000,
            3 => 1500000,
            4 => 1125000,
            5 => 900000,
            6 => 833333,
            7 => 714286,
            8 => 625000,
            9 => 611111,
            10 => 600000,
            11 => 636364,
            12 => 583333,
            15 => 533333,
            16 => 562500,
            17 => 588235
        ],
        5000000 => [
            2 => 2500000,
            3 => 1666667,
            4 => 1250000,
            5 => 1000000,
            6 => 916667,
            7 => 785714,
            8 => 687500,
            9 => 666667,
            10 => 600000,
            11 => 636364,
            12 => 666667,
            15 => 600000,
            16 => 625000
        ],
        5500000 => [
            2 => 2750000,
            3 => 1833333,
            4 => 1375000,
            5 => 1100000,
            6 => 1000000,
            7 => 857143,
            8 => 750000,
            9 => 777778,
            10 => 700000,
            11 => 727273,
            12 => 750000,
            15 => 666667
        ],
        6000000 => [
            2 => 3000000,
            3 => 2000000,
            4 => 1500000,
            5 => 1200000,
            6 => 1166667,
            7 => 1000000,
            8 => 875000,
            9 => 888889,
            10 => 800000,
            11 => 818182,
            12 => 833333
        ],
        7000000 => [
            2 => 3500000,
            3 => 2333333,
            4 => 1750000,
            5 => 1400000,
            6 => 1333333,
            7 => 1142857,
            8 => 1000000,
            9 => 1000000,
            10 => 900000,
            11 => 909091
        ],
        8000000 => [
            2 => 4000000,
            3 => 2666667,
            4 => 2000000,
            5 => 1600000,
            6 => 1500000,
            7 => 1285714,
            8 => 1125000,
            9 => 1111111,
            10 => 1000000
        ],
        9000000 => [
            2 => 4500000,
            3 => 3000000,
            4 => 2250000,
            5 => 1800000,
            6 => 1666667,
            7 => 1428571,
            8 => 1250000,
            9 => 1000000,
            10 => 900000
        ],
        10000000 => [
            2 => 5000000,
            3 => 3333333,
            4 => 2500000,
            5 => 2000000,
            6 => 1666667,
            7 => 1428571,
            8 => 1250000,
            9 => 1111111,
            10 => 1000000
        ]
    ];

    /**
     * Hitung administrasi 5%
     */
    public static function hitungAdministrasi($pinjaman)
    {
        return $pinjaman * 0.05;
    }

    /**
     * Hitung jumlah yang diterima (pinjaman - administrasi)
     */
    public static function hitungTerima($pinjaman)
    {
        return $pinjaman - self::hitungAdministrasi($pinjaman);
    }

    /**
     * Ambil angsuran per bulan berdasarkan pinjaman dan tenor
     */
    public static function getAngsuran($pinjaman, $tenor)
    {
        // Jika pinjaman ada di tabel
        if (isset(self::$tabelAngsuran[$pinjaman][$tenor])) {
            return self::$tabelAngsuran[$pinjaman][$tenor];
        }

        // Jika tidak ada, hitung manual (pinjaman / tenor)
        return ceil($pinjaman / $tenor);
    }

    /**
     * Cek apakah kombinasi pinjaman dan tenor valid
     */
    public static function isValidKombinasi($pinjaman, $tenor)
    {
        return isset(self::$tabelAngsuran[$pinjaman][$tenor]);
    }

    /**
     * Ambil daftar tenor yang tersedia untuk pinjaman tertentu
     */
    public static function getTenorTersedia($pinjaman)
    {
        if (isset(self::$tabelAngsuran[$pinjaman])) {
            return array_keys(self::$tabelAngsuran[$pinjaman]);
        }
        return [6, 12]; // Default
    }

    /**
     * Ambil semua pilihan pinjaman yang tersedia
     */
    public static function getPilihanPinjaman()
    {
        return array_keys(self::$tabelAngsuran);
    }

    /**
     * Generate simulasi angsuran lengkap
     */
    public static function generateSimulasi($pinjaman, $tenor)
    {
        $angsuran = self::getAngsuran($pinjaman, $tenor);
        $sisa = $pinjaman;
        $simulasi = [];

        for ($bulan = 1; $bulan <= $tenor; $bulan++) {
            $bayar = min($angsuran, $sisa);
            $sisa -= $bayar;

            $simulasi[] = [
                'bulan' => $bulan,
                'angsuran' => $bayar,
                'sisa' => max(0, $sisa)
            ];
        }

        return $simulasi;
    }

    /**
     * Hitung sisa gaji setelah dipotong angsuran
     */
    public static function hitungSisaGaji($gajiPokok, $angsuran)
    {
        return $gajiPokok - $angsuran;
    }

    /**
     * Cek apakah peminjam mampu bayar (angsuran max 40% dari gaji)
     */
    public static function cekKemampuanBayar($gajiPokok, $angsuran)
    {
        $maxAngsuran = $gajiPokok * 0.4; // 40% dari gaji
        return $angsuran <= $maxAngsuran;
    }
}
