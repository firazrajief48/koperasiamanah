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
        Schema::table('pinjamans', function (Blueprint $table) {
            $table->enum('metode_pembayaran', ['potong_gaji', 'potong_tukin'])
                ->nullable()
                ->after('gaji_pokok');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pinjamans', function (Blueprint $table) {
            $table->dropColumn('metode_pembayaran');
        });
    }
};
