<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nip',
        'golongan',
        'jabatan',
        'phone',
        'photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user has specific role
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Check if user is anggota
     */
    public function isAnggota(): bool
    {
        return $this->hasRole('anggota');
    }

    /**
     * Check if user is kepala bps
     */
    public function isKepalaBps(): bool
    {
        return $this->hasRole('kepala_bps');
    }

    /**
     * Check if user is bendahara koperasi
     */
    public function isBendaharaKoperasi(): bool
    {
        return $this->hasRole('bendahara_koperasi');
    }

    /**
     * Check if user is ketua koperasi
     */
    public function isKetuaKoperasi(): bool
    {
        return $this->hasRole('ketua_koperasi');
    }

    /**
     * Check if user is administrator
     */
    public function isAdministrator(): bool
    {
        return $this->hasRole('administrator');
    }

    /**
     * Get the iurans for the user
     */
    public function iurans()
    {
        return $this->hasMany(Iuran::class, 'user_id', 'id');
    }

    /**
     * Get the pinjamans for the user
     */
    public function pinjamans()
    {
        return $this->hasMany(Pinjaman::class, 'user_id', 'id');
    }

    /**
     * Get total iuran (contributions) for the user
     */
    public function getTotalIuranAttribute()
    {
        $total = $this->iurans()->where('status', 'lunas')->sum('jumlah');
        return $total ?? 0;
    }

    /**
     * Get total approved loans for the user
     */
    public function getTotalPinjamanAttribute()
    {
        $total = $this->pinjamans()->where('status', 'disetujui')->sum('jumlah_pinjaman');
        return $total ?? 0;
    }

    /**
     * Get remaining loan amount for the user
     */
    public function getSisaPinjamanAttribute()
    {
        $pinjamanAktif = $this->pinjamans()
            ->where('status', 'disetujui')
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$pinjamanAktif) {
            return 0;
        }

        return $pinjamanAktif->sisa_pinjaman ?? 0;
    }
}
