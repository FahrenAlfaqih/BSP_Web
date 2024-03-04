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
        Schema::create('magang', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('institusi');
            $table->string('kategori')->nullable();
            $table->string('jurusan_fakultas');
            $table->date('tanggalMulai');
            $table->date('tanggalSelesai');
            $table->string('kegiatan')->nullable();
            $table->string('dept')->nullable();
            $table->enum('daring_luring', ['OFFLINE', 'ONLINE', 'HYBRID'])->nullable();
            $table->string('lokasi')->nullable();
            $table->string('mentor')->nullable();
            $table->string('statusSurat')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('magang');
    }
};
