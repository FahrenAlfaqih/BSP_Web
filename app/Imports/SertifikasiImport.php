<?php

namespace App\Imports;

use App\Models\Sertifikasi;
use Maatwebsite\Excel\Concerns\ToModel;

class SertifikasiImport implements ToModel
{
    public function model(array $row)
    {
        $tanggalPelaksanaanMulai = date('Y-m-d', strtotime('1899-12-30 +' . $row[4] . ' days'));
        $tanggalPelaksanaanSelesai = date('Y-m-d', strtotime('1899-12-30 +' . $row[5] . ' days'));

        return new Sertifikasi([
            'noPek' => $row[0],
            'namaPekerja' => $row[1],
            'dept' => $row[2],
            'namaProgram' => $row[3],
            'tahunSertifikasi' => $row[9],
            'tanggalPelaksanaanMulai' => $tanggalPelaksanaanMulai,
            'tanggalPelaksanaanSelesai' => $tanggalPelaksanaanSelesai,
            'days' => $row[6],
            'tempat' => $row[7],
            'namaPenyelenggara' => $row[8]
            // Sesuaikan dengan kolom-kolom lainnya
        ]);
    }
}
