<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Step 1: Add 'anggota' to existing enum (keeping 'peminjam' temporarily)
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('peminjam', 'anggota', 'kepala_bps', 'bendahara_koperasi', 'ketua_koperasi', 'administrator') NOT NULL DEFAULT 'peminjam'");

        // Step 2: Update all existing 'peminjam' records to 'anggota'
        DB::statement("UPDATE users SET role = 'anggota' WHERE role = 'peminjam'");

        // Step 3: Remove 'peminjam' from enum and set default to 'anggota'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('anggota', 'kepala_bps', 'bendahara_koperasi', 'ketua_koperasi', 'administrator') NOT NULL DEFAULT 'anggota'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse: update 'anggota' back to 'peminjam'
        DB::statement("UPDATE users SET role = 'peminjam' WHERE role = 'anggota'");

        // Restore original enum with 'peminjam'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('peminjam', 'kepala_bps', 'bendahara_koperasi', 'ketua_koperasi', 'administrator') NOT NULL DEFAULT 'peminjam'");
    }
};
