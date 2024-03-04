<?php

namespace App\Imports;

use App\Models\Magang;
use Maatwebsite\Excel\Concerns\ToModel;

class MagangImport implements ToModel
{
    public function model(array $row)
    {
        // Konversi tanggal
        $tanggalMulai = date('Y-m-d', strtotime('1899-12-30 +' . $row[4] . ' days'));
        $tanggalSelesai = date('Y-m-d', strtotime('1899-12-30 +' . $row[5] . ' days'));

        // Cari data yang mungkin duplikat
        $magang = Magang::where('nama', $row[0])
            ->where('institusi', $row[1])
            ->where('kategori', $row[2])
            ->where('jurusan_fakultas', $row[3])
            ->where('tanggalMulai', $tanggalMulai)
            ->where('tanggalSelesai', $tanggalSelesai)
            ->where('kegiatan', $row[6])
            ->where('dept', $row[7])
            ->where('daring_luring', $row[8])
            ->where('lokasi', $row[9])
            ->where('mentor', $row[10])
            ->where('statusSurat', $row[11])
            ->where('keterangan', $row[12])
            ->first();

        // Jika data tidak ditemukan (tidak ada duplikasi)
        if (!$magang) {
            // Buat objek Magang baru
            return new Magang([
                'nama' => $row[0],
                'institusi' => $row[1],
                'kategori' => $row[2],
                'jurusan_fakultas' => $row[3],
                'tanggalMulai' => $tanggalMulai,
                'tanggalSelesai' => $tanggalSelesai,
                'kegiatan' => $row[6],
                'dept' => $row[7],
                'daring_luring' => $row[8],
                'lokasi' => $row[9],
                'mentor' => $row[10],
                'statusSurat' => $row[11],
                'keterangan' => $row[12]
                // Sesuaikan dengan kolom-kolom lainnya
            ]);
        } else {
            \Illuminate\Support\Facades\Session::flash('warning', 'Duplikasi data ditemukan untuk baris tertentu.');
            return null;
        }
    }
}
