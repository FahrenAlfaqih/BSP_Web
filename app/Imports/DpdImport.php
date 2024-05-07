<?php

namespace App\Imports;

use App\Models\Dpd;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class DpdImport implements ToModel, WithStartRow
{
    public function model(array $row)
    {
        // Lakukan validasi atau manipulasi data di sini

        // Periksa apakah baris adalah "Total Biaya DPD"
        if (isset($row[1]) && strtolower(trim($row[1])) === 'total biaya dpd') {
            return null; // Abaikan baris "Total Biaya DPD"
        }

        $submitFinec = date('Y-m-d', strtotime('1899-12-30 +' . $row[9] . ' days'));

        // Bersihkan nilai biayadpd dari format mata uang dan koma
        $biayaDpdCleaned = str_replace(['Rp ', ',', '.'], '', $row[8]);

        // Konversi nilai biayadpd ke tipe data desimal
        $biayadpdDecimal = (float) $biayaDpdCleaned;

        // Cek apakah data duplikat
        $existingDpd = Dpd::where('nama', $row[1])
            ->where('nomorspd', $row[2])
            ->where('dept', $row[3])
            ->where('bsno', $row[4])
            ->where('pr', $row[5])
            ->where('po', $row[6])
            ->where('ses', $row[7])
            ->where('biayadpd', $biayadpdDecimal) // Gunakan nilai biayadpd yang sudah dibersihkan dan dikonversi
            ->where('submitfinec', $submitFinec)
            ->where('status', $row[10])
            ->where('paymentbyfinec', $row[11])
            ->where('keterangan', $row[12])
            ->exists();

        if (!$existingDpd) {
            // Buat objek Dpd baru
            return new Dpd([
                'nama' => $row[1],
                'nomorspd' => $row[2],
                'dept' => $row[3],
                'bsno' => $row[4],
                'pr' => $row[5],
                'po' => $row[6],
                'ses' => $row[7],
                'biayadpd' => $biayadpdDecimal, // Gunakan nilai biayadpd yang sudah dibersihkan dan dikonversi
                'submitfinec' => $submitFinec,
                'status' => $row[10],
                'paymentbyfinec' => $row[11],
                'keterangan' => $row[12],
                // Sesuaikan dengan kolom-kolom lainnya
            ]);
        } else {
            Session::flash('warning', 'Duplikasi data ditemukan.');
            return null; // Return null jika ingin melewati data duplikat
        }
    }


    public function startRow(): int
    {
        return 2; // Mulai impor dari baris kedua (baris yang berisi data, bukan judul kolom)
    }
}
