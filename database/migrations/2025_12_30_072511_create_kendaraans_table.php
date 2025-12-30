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
        Schema::create('kendaraans', function (Blueprint $table) {
            $table->id();
            $table->string('merk');
            $table->string('tipe');
            $table->string('nomor_polisi')->unique();
            $table->text('galeri_foto')->nullable(); // JSON array of photo paths
            $table->enum('status_kondisi', ['Sangat Baik', 'Perbaikan', 'Rusak'])->default('Sangat Baik');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kendaraans');
    }
};
