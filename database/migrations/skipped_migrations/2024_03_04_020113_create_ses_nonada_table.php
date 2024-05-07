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
        Schema::create('ses_nonada', function (Blueprint $table) {
            $table->id('idNonadaSES')->autoIncrement(false)->primary();
            $table->unsignedBigInteger('idNonadaPO');
            $table->string('judulPekerjaan');
            $table->foreign('idNonadaPO')->references('idNonadaPO')->on('po_nonada')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ses_nonada');
    }
};
