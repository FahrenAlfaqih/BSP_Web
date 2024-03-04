<?php

namespace App\Imports;

use App\Models\Sertifikasi;
use Maatwebsite\Excel\Concerns\ToModel;

class SertifikasiImport implements ToModel
{
    public function model(array $row)
    {
        // Konversi tanggal
        $tanggalPelaksanaanMulai = date('Y-m-d', strtotime('1899-12-30 +' . $row[4] . ' days'));
        $tanggalPelaksanaanSelesai = date('Y-m-d', strtotime('1899-12-30 +' . $row[5] . ' days'));

        // Cari data yang mungkin duplikat
        $sertifikasi = Sertifikasi::where('noPek', $row[0])
            ->where('namaPekerja', $row[1])
            ->where('dept', $row[2])
            ->where('namaProgram', $row[3])
            ->where('tahunSertifikasi', $row[9])
            ->where('tanggalPelaksanaanMulai', $tanggalPelaksanaanMulai)
            ->where('tanggalPelaksanaanSelesai', $tanggalPelaksanaanSelesai)
            ->where('days', $row[6])
            ->where('tempat', $row[7])
            ->where('namaPenyelenggara', $row[8])
            ->first();

        // Jika data tidak ditemukan (tidak ada duplikasi)
        if (!$sertifikasi) {
            // Buat objek Sertifikasi baru
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
        } else {
            \Illuminate\Support\Facades\Session::flash('warning', 'Duplikasi data ditemukan untuk baris tertentu.');

            // Kembalikan nilai null agar baris ini diabaikan
            return null;
        }
    }
}
