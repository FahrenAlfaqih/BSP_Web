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
        Schema::create('ses_reimburst', function (Blueprint $table) {
            $table->id('idSReimburstSES')->autoIncrement(false)->primary();
            $table->unsignedBigInteger('idReimburstPO');
            $table->string('judulPekerjaan');
            $table->foreign('idReimburstPO')->references('idReimburstPO')->on('po_reimburst')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ses_reimburst');
    }
};
