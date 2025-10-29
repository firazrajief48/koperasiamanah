<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    use HasFactory;

    protected $table = 'pinjamans';

    protected $fillable = [
        'user_id',
        'jumlah_pinjaman',
        'tenor_bulan',
        'cicilan_per_bulan',
        'bulan_terbayar',
        'sisa_pinjaman',
        'gaji_pokok',
        'status',
        'status_detail',
        'alasan_penolakan',
        'disetujui_oleh',
        'tanggal_persetujuan',
        'keterangan',
    ];

    protected $casts = [
        'jumlah_pinjaman' => 'decimal:2',
        'cicilan_per_bulan' => 'decimal:2',
        'sisa_pinjaman' => 'decimal:2',
        'gaji_pokok' => 'decimal:2',
    ];

    /**
     * Get the user that owns the pinjaman
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class);
    }
}
