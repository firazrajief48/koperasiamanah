<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayarans';

    protected $fillable = [
        'pinjaman_id',
        'bulan_ke',
        'nominal_pembayaran',
        'tanggal_jatuh_tempo',
        'tanggal_pembayaran',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'nominal_pembayaran' => 'decimal:2',
        'tanggal_jatuh_tempo' => 'date',
        'tanggal_pembayaran' => 'date',
    ];

    public function pinjaman()
    {
        return $this->belongsTo(Pinjaman::class);
    }
}
