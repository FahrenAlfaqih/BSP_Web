<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Department extends Model
{
    use HasFactory;

    protected $table = 'departments'; // Nama tabel dalam basis data
    protected $fillable = ['name', 'initial_fund', 'remaining_funds']; // Kolom-kolom yang dapat diisi

    public static function updateRemainingFunds()
    {
        $dpdSummary = Dpd::select('dept', DB::raw('SUM(biayadpd) AS total_pengeluaran'))
            ->groupBy('dept')
            ->get();

        foreach ($dpdSummary as $summary) {
            $department = self::where('name', $summary->dept)->first();
            if ($department) {
                $department->remaining_funds = $department->initial_fund - $summary->total_pengeluaran;
                $department->save();
            }
        }
    }

    // Function untuk memastikan remaining_funds diisi dengan initial_funds jika masih 0
    public function ensureRemainingFunds()
    {
        if ($this->remaining_funds == 0.00) {
            $this->remaining_funds = $this->initial_fund;
            $this->save();
        }
    }   
}
