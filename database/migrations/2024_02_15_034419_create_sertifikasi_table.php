<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSertifikasiTable extends Migration
{
    public function up()
    {
        Schema::create('sertifikasi', function (Blueprint $table) {
            $table->id();
            $table->integer('noPek');
            $table->string('namaPekerja');
            $table->string('dept')->nullable();
            $table->string('namaProgram');
            $table->integer('tahunSertifikasi');
            $table->date('tanggalPelaksanaanMulai');
            $table->date('tanggalPelaksanaanSelesai');
            $table->integer('days');
            $table->string('man_hours')->nullable();
            $table->string('total_man_hours')->nullable();
            $table->string('tempat');
            $table->string('namaPenyelenggara');
            $table->timestamps();
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('sertifikasi');
    }
}
