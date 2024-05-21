<?php

namespace App\Imports;

use App\Models\Training;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;


class TrainingImport implements ToModel,WithStartRow
{
    /**
     * @param Collection $collection
     */
    public function model(array $row)
    {
        $tanggalMulai = date('Y-m-d', strtotime('1899-12-30 +' . $row[1] . ' days'));
        $tanggalSelesai = date('Y-m-d', strtotime('1899-12-30 +' . $row[2] . ' days'));

        // Cari data yang mungkin duplikat
        $training = Training::where('judulPelatihan', $row[0])
            ->where('tglMulai', $tanggalMulai)
            ->where('tglSelesai', $tanggalSelesai)
            ->where('man', $row[3])
            ->where('days', $row[4])
            ->where('hours', $row[5])
            ->where('total_man_hours', $row[6])
            ->where('hse', $row[7])
            ->where('nonhse', $row[8])
            ->where('inhouse', $row[9])
            ->where('sertifikasi', $row[10])
            ->where('teknikal', $row[11])
            ->first();

        // Jika data tidak ditemukan (tidak ada duplikasi)
        if (!$training) {
            return new Training([
                'judulPelatihan' => $row[0],
                'tglMulai' => $tanggalMulai,
                'tglSelesai' => $tanggalSelesai,
                'man' => $row[3],
                'days' => $row[4],
                'hours  ' => $row[5],
                'total_man_hours' => $row[6],
                'hse' => $row[7],
                'nonhse' => $row[8],
                'inhouse' => $row[9],
                'sertifikasi' => $row[10],
                'teknikal' => $row[11]
                // Sesuaikan dengan kolom-kolom lainnya
            ]);
        } else {
            \Illuminate\Support\Facades\Session::flash('warning', 'Duplikasi data ditemukan untuk baris tertentu.');

            // Kembalikan nilai null agar baris ini diabaikan
            return null;
        }
    }

    public function startRow(): int
    {
        return 5; // Mulai impor dari baris kedua (baris yang berisi data, bukan judul kolom)
    }
}
