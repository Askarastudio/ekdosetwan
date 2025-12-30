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
        Schema::create('supirs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('foto_profil')->nullable();
            $table->string('nomor_hp');
            $table->enum('status_ketersediaan', ['Standby', 'On Duty'])->default('Standby');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supirs');
    }
};
