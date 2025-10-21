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
     * Check if user is peminjam
     */
    public function isPeminjam(): bool
    {
        return $this->hasRole('peminjam');
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
}
