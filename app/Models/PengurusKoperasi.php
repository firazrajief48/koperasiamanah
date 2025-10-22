<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengurusKoperasi extends Model
{
    protected $fillable = [
        'nama',
        'jabatan',
        'deskripsi',
        'foto',
        'email',
        'telepon',
        'urutan',
        'aktif'
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'urutan' => 'integer'
    ];

    // Scope untuk pengurus aktif
    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    // Scope untuk mengurutkan berdasarkan urutan
    public function scopeUrut($query)
    {
        return $query->orderBy('urutan', 'asc');
    }
}
