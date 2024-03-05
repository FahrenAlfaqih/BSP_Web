<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Magang extends Model
{
    use HasFactory;
    protected $table = 'magang';
    protected $fillable = [
        'nama', 'institusi', 'kategori', 'jurusan_fakultas', 'tanggalMulai', 'tanggalSelesai', 'kegiatan', 'dept', 'daring_luring',
         'lokasi', 'mentor','statusSurat', 'keterangan'
    ];

    public function scopeFilterByDate($query, $bulan, $tahun)
    {
        return $query->where(function ($q) use ($bulan, $tahun) {
            $q->whereMonth('tanggalMulai', $bulan)
                ->whereYear('tanggalMulai', $tahun);
        })->orWhere(function ($q) use ($bulan, $tahun) {
            $q->whereMonth('tanggalSelesai', $bulan)
                ->whereYear('tanggalSelesai', $tahun);
        });
    }
}
