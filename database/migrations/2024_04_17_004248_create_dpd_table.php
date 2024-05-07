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
        Schema::create('dpd', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nomorspd');
            $table->string('dept');
            $table->string('bsno')->nullable();
            $table->string('pr')->nullable();
            $table->string('po')->nullable();
            $table->string('ses')->nullable();
            $table->decimal('biayadpd', 10, 2)->nullable();
            $table->date('submitfinec')->nullable();
            $table->string('status')->nullable();
            $table->string('paymentbyfinec')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dpd');
    }
};
