<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('fund_changes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade'); // Tabel departemen yang menjadi referensi
            $table->decimal('old_fund', 20, 2);  // Nilai awal `initial_fund`
            $table->decimal('new_fund', 20, 2);  // Nilai baru `initial_fund`
            $table->timestamp('changed_at')->default(DB::raw('CURRENT_TIMESTAMP'));  // Waktu perubahan
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fund_changes');
    }
};
