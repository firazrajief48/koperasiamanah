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
            $table->string('status_detail')->default('menunggu_persetujuan_bendahara')->after('status');
            $table->text('alasan_penolakan')->nullable()->after('status_detail');
            $table->string('disetujui_oleh')->nullable()->after('alasan_penolakan');
            $table->timestamp('tanggal_persetujuan')->nullable()->after('disetujui_oleh');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pinjamans', function (Blueprint $table) {
            $table->dropColumn(['status_detail', 'alasan_penolakan', 'disetujui_oleh', 'tanggal_persetujuan']);
        });
    }
};
