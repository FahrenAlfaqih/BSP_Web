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
            $table->id('idNonadaPO')->autoIncrement(false)->primary();
            $table->unsignedBigInteger('idNonadaPR');
            $table->string('judulPekerjaan');
            $table->timestamps();
            $table->foreign('idNonadaPR')->references('idNonadaPR')->on('pr_nonada')->onDelete('cascade');
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
