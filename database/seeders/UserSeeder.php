<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin users (only 1 each for admin roles)
        $adminUsers = [
            [
                'name' => 'Kepala BPS',
                'email' => 'arriefchandra@gmail.com',
                'password' => Hash::make('kepala3578'),
                'role' => 'kepala_bps',
            ],
            [
                'name' => 'Bendahara Koperasi',
                'email' => 'retnolarasati@gmail.com',
                'password' => Hash::make('bendahara3578'),
                'role' => 'bendahara_koperasi',
            ],
            [
                'name' => 'Ketua Koperasi',
                'email' => 'nurcholis@gmail.com',
                'password' => Hash::make('ketua3578'),
                'role' => 'ketua_koperasi',
            ],
            [
                'name' => 'Administrator',
                'email' => 'bilalali@gmail.com',
                'password' => Hash::make('administrator3578'),
                'role' => 'administrator',
            ],
        ];

        foreach ($adminUsers as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        // Peminjam users will be created through registration only
    }
}
