<?php

namespace App\Imports;

use App\Models\PRReimburst;
use App\Models\PRService;
use Maatwebsite\Excel\Concerns\ToModel;

class PrServiceImport implements ToModel
{
    public function model(array $row)
    {

        // Cari data yang mungkin duplikat
        $prservice = PRService::where('idServicePR', $row[0])
            ->where('judulPekerjaan', $row[1])
            ->first();

        // Jika data tidak ditemukan (tidak ada duplikasi)
        if (!$prservice) {
            return new PRService([
                'idServicePR' => $row[0],
                'judulPekerjaan' => $row[1]
                // Sesuaikan dengan kolom-kolom lainnya
            ]);
        } else {
            \Illuminate\Support\Facades\Session::flash('warning', 'Duplikasi data ditemukan untuk baris tertentu.');
            return null;
        }
    }
}
