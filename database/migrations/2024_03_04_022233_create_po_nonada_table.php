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
        Schema::create('po_nonada', function (Blueprint $table) {
            $table->integer('idNonadaPO')->primary();
            $table->unsignedBigInteger('idNonadaPR')->nullable();
            $table->foreign('idNonadaPR')->references('idNonadaPR')->on('pr_nonada')->onDelete('set null');
            $table->string('judulPekerjaan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('po_nonada');
    }
};
