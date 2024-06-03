<?php

namespace App\Imports;

use App\Models\Pegawai;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class PegawaiImport implements ToModel, WithStartRow
{
    /**
     * Menentukan model yang akan digunakan untuk setiap baris yang diimpor
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Pastikan array $row memiliki setidaknya 3 elemen
        if (count($row) < 3) {
            // Jika baris tidak memiliki cukup kolom, lewati
            return null;
        }

        // Cek apakah data duplikat berdasarkan nopek, namaPekerja, dan dept
        $existingPegawai = Pegawai::where('nopek', $row[0]) // Perbaikan indeks kolom ke-0
            ->where('namaPekerja', $row[1]) // Perbaikan indeks kolom ke-1
            ->where('dept', $row[2]) // Perbaikan indeks kolom ke-2
            ->exists();

        if (!$existingPegawai) {
            // Buat objek Pegawai baru jika tidak ada duplikasi
            return new Pegawai([
                'nopek' => $row[0], // Perbaikan indeks kolom ke-0
                'namaPekerja' => $row[1], // Perbaikan indeks kolom ke-1
                'dept' => $row[2], // Perbaikan indeks kolom ke-2
            ]);
        } else {
            // Simpan pesan peringatan jika ada duplikasi
            Session::flash('warning', 'Duplikasi data ditemukan untuk Nopek: ' . $row[0]);
            return null; // Return null jika ingin melewati data duplikat
        }
    }

    /**
     * Menentukan baris awal untuk mulai impor data
     *
     * @return int
     */
    public function startRow(): int
    {
        return 2; // Mulai impor dari baris kedua (baris yang berisi data, bukan judul kolom)
    }
}
