<?php

namespace App\Imports;

use App\Models\Spd;
use Maatwebsite\Excel\Concerns\ToModel;

class SpdImport implements ToModel
{
    public function model(array $row)
    {
        
        $spd = Spd::where('nomor_spd', $row[0])
            ->where('nama', $row[1])
            ->where('dept', $row[2])
            ->where('wbs', $row[3])
            ->where('pr', $row[4])
            ->where('po', $row[5])
            ->where('ses', $row[6])
            ->where('mir7', $row[7])
            ->where('dari', $row[8])
            ->where('tujuan', $row[9])
            ->where('tanggal_dinas', $row[10])
            ->where('keterangan_dinas', $row[11])
            ->where('biaya_dpd', $row[12])
            ->where('rkap', $row[13])
            ->where('accrual', $row[14])
            ->where('submit_tgl', $row[15])
            ->first();

        // Jika data tidak ditemukan (tidak ada duplikasi)
        if (!$spd) {
            // Buat objek Magang baru
            return new Spd([
                'nomor_spd' => $row[0],
                'nama' => $row[1],
                'dept' => $row[2],
                'wbs' => $row[3],
                'pr' => $row[4],
                'po' => $row[5],
                'ses' => $row[6],
                'mir7' => $row[7],
                'dari' => $row[8],
                'tujuan' => $row[9],
                'tanggal_dinas' => $row[10],
                'keterangan_dinas' => $row[11],
                'biaya_dpd' => $row[12],
                'rkap' => $row[13],
                'accrual' => $row[14],
                'submit_tgl' => $row[15]
                // Sesuaikan dengan kolom-kolom lainnya
            ]);
        } else {
            \Illuminate\Support\Facades\Session::flash('warning', 'Duplikasi data ditemukan untuk baris tertentu.');
            return null;
        }
    }
}
