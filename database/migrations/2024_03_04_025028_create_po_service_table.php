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
            $table->id('idServicePO')->autoIncrement(false)->primary();
            $table->unsignedBigInteger('idServicePR');
            $table->string('judulPekerjaan');
            $table->timestamps();
            $table->foreign('idServicePR')->references('idServicePR')->on('pr_service')->onDelete('cascade');
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
