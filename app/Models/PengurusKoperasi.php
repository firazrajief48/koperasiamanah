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

    // Accessor untuk foto URL
    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->nama) . '&size=150&background=1e40af&color=ffffff';
    }

    // Accessor untuk status text
    public function getStatusTextAttribute()
    {
        return $this->aktif ? 'Aktif' : 'Tidak Aktif';
    }
}
