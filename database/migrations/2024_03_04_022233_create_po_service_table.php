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
        Schema::create('po_service', function (Blueprint $table) {
            $table->integer('idServicePO')->primary();
            $table->unsignedBigInteger('idServicePR')->nullable();
            $table->foreign('idServicePR')->references('idServicePR')->on('pr_service')->onDelete('set null');
            $table->string('judulPekerjaan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('po_service');
    }
};
