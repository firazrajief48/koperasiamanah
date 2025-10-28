<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iuran extends Model
{
    use HasFactory;

    protected $table = 'iurans';

    protected $fillable = [
        'user_id',
        'jumlah',
        'bulan',
        'tanggal_bayar',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_bayar' => 'date',
    ];

    /**
     * Get the user that owns the iuran
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
