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
        Schema::create('iurans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('jumlah', 15, 2)->default(0);
            $table->string('bulan', 20)->nullable(); // Format: YYYY-MM (e.g., "2025-10")
            $table->date('tanggal_bayar')->nullable();
            $table->enum('status', ['lunas', 'belum'])->default('belum');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('bulan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iurans');
    }
};
