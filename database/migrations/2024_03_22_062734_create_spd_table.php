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
        Schema::create('spds', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_spd');
            $table->string('nama');
            $table->string('dept');
            $table->string('wbs')->nullable();
            $table->string('pr')->nullable();
            $table->string('po')->nullable();
            $table->string('ses')->nullable();
            $table->string('mir7')->nullable();
            $table->string('dari');
            $table->string('tujuan');
            $table->date('tanggal_dinas');
            $table->text('keterangan_dinas')->nullable();
            $table->decimal('biaya_dpd', 10, 2)->nullable();
            $table->decimal('rkap', 10, 2)->nullable();
            $table->decimal('accrual', 10, 2)->nullable();
            $table->date('submit_tgl')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spd');
    }
};
