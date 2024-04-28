<?php

namespace App\Imports;

use App\Models\Spd;
use Maatwebsite\Excel\Concerns\ToModel;

class SpdImport implements ToModel
{
    public function model(array $row)
    {
        // Mengonversi format tanggal "01-Mar-24" ke "YYYY-MM-DD"
        $tanggalMulai = date('Y-m-d', strtotime('1899-12-30 +' . $row[9] . ' days'));
        $tanggalSelesai = date('Y-m-d', strtotime('1899-12-30 +' . $row[10] . ' days'));
        $submitTanggal = date('Y-m-d', strtotime('1899-12-30 +' . $row[15] . ' days'));

        // Validasi dan konversi nilai biaya_dpd dan rkap
        $biaya_dpd = is_numeric($row[12]) ? $row[12] : 0; // Mengonversi ke angka atau 0 jika bukan angka
        $rkap = is_numeric($row[13]) ? $row[13] : 0; // Mengonversi ke angka atau 0 jika bukan angka

        $spd = Spd::where('nomor_spd', $row[0])
            ->where('nama', $row[1])
            ->where('dept', $row[2])
            ->where('wbs', $row[3])
            ->where('pr', $row[4])
            ->where('po', $row[5])
            ->where('ses', $row[6])
            ->where('dari', $row[7])
            ->where('tujuan', $row[8])
            ->where('tanggal_mulai', $tanggalMulai)
            ->where('tanggal_selesai', $tanggalSelesai)
            ->where('keterangan_dinas', $row[11])
            ->where('biaya_dpd', $biaya_dpd)
            ->where('rkap', $rkap)
            ->where('accrual', $row[14])
            ->where('submit_tgl', $submitTanggal)
            ->first();

        // Jika data tidak ditemukan (tidak ada duplikasi)
        if (!$spd) {
            // Buat objek Spd baru
            return new Spd([
                'nomor_spd' => $row[0],
                'nama' => $row[1],
                'dept' => $row[2],
                'wbs' => $row[3],
                'pr' => $row[4],
                'po' => $row[5],
                'ses' => $row[6],
                'dari' => $row[7],
                'tujuan' => $row[8],
                'tanggal_mulai' => $tanggalMulai,
                'tanggal_selesai' => $tanggalSelesai,
                'keterangan_dinas' => $row[11],
                'biaya_dpd' => $biaya_dpd,
                'rkap' => $rkap,
                'accrual' => $row[14],
                'submit_tgl' => $submitTanggal
            ]);
        } else {
            \Illuminate\Support\Facades\Session::flash('warning', 'Duplikasi data ditemukan untuk baris tertentu.');
            return null;
        }
    }
}
