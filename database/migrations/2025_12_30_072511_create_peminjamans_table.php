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
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('kendaraan_id')->nullable()->constrained('kendaraans')->onDelete('set null');
            $table->foreignId('supir_id')->nullable()->constrained('supirs')->onDelete('set null');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('tujuan');
            $table->text('kebutuhan');
            $table->string('nomor_hp_pic');
            $table->enum('status', ['Proses', 'Diverifikasi', 'Disetujui', 'Ditolak', 'Selesai', 'Dibatalkan'])->default('Proses');
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->text('catatan_verifikator')->nullable();
            $table->text('catatan_pengurus_barang')->nullable();
            $table->text('alasan_penolakan')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};
