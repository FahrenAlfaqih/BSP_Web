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
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->string('judulPelatihan');
            $table->date('tglMulai');
            $table->date('tglSelesai');
            $table->integer('man');
            $table->integer('days');
            $table->integer('hours');
            $table->integer('total_man_hours');
            $table->integer('hse')->nullable();
            $table->integer('nonhse')->nullable();
            $table->integer('inhouse')->nullable();
            $table->integer('sertifikasi')->nullable();
            $table->integer('teknikal')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainings');
    }
};
