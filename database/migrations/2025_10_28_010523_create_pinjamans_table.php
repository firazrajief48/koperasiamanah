<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pinjamans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('jumlah_pinjaman', 15, 2)->default(0);
            $table->integer('tenor_bulan')->default(0);
            $table->decimal('cicilan_per_bulan', 15, 2)->default(0);
            $table->integer('bulan_terbayar')->default(0);
            $table->decimal('sisa_pinjaman', 15, 2)->default(0);
            $table->decimal('gaji_pokok', 15, 2)->nullable();
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak', 'lunas'])->default('menunggu');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pinjamans');
    }
};
