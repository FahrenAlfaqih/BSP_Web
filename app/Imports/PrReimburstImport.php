<?php

namespace App\Imports;

use App\Models\PRReimburst;
use Maatwebsite\Excel\Concerns\ToModel;

class PrReimburstImport implements ToModel
{
    public function model(array $row)
    {

        // Cari data yang mungkin duplikat
        $prreimburst = PRReimburst::where('idReimburstPR', $row[0])
            ->where('judulPekerjaan', $row[1])
            ->first();

        // Jika data tidak ditemukan (tidak ada duplikasi)  
        if (!$prreimburst) {
            // Buat objek Magang baru
            return new PRReimburst([
                'idReimburstPR' => $row[0],
                'judulPekerjaan' => $row[1]
                // Sesuaikan dengan kolom-kolom lainnya
            ]);
        } else {
            \Illuminate\Support\Facades\Session::flash('warning', 'Duplikasi data ditemukan untuk baris tertentu.');
            return null;
        }
    }
}
