<?php

namespace App\Imports;

use App\Models\PRNonada;
use Maatwebsite\Excel\Concerns\ToModel;

class PrNonadaImport implements ToModel
{
    public function model(array $row)
    {

        // Cari data yang mungkin duplikat
        $prnonada = PRNonada::where('idNonadaPR', $row[0])
            ->where('judulPekerjaan', $row[1])
            ->first();

        // Jika data tidak ditemukan (tidak ada duplikasi)
        if (!$prnonada) {
            return new PRNonada([
                'idNonadaPR' => $row[0],
                'judulPekerjaan' => $row[1]
                // Sesuaikan dengan kolom-kolom lainnya
            ]);
        } else {
            \Illuminate\Support\Facades\Session::flash('warning', 'Duplikasi data ditemukan untuk baris tertentu.');
            return null;
        }
    }
}
