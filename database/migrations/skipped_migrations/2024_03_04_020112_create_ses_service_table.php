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
        Schema::create('ses_service', function (Blueprint $table) {
            $table->id('idServiceSES')->autoIncrement(false)->primary();
            $table->unsignedBigInteger('idServicePO');
            $table->string('judulPekerjaan');
            $table->foreign('idServicePO')->references('idServicePO')->on('po_service')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ses_service');
    }
};
