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
        Schema::create('po_reimburst', function (Blueprint $table) {
            $table->integer('idReimburstPO')->primary();
            $table->unsignedBigInteger('idReimburstPR')->nullable();
            $table->foreign('idReimburstPR')->references('idReimburstPR')->on('pr_reimburst')->onDelete('set null');
            $table->string('judulPekerjaan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('po_reimburst');
    }
};
