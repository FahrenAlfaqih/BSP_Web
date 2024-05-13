<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sertifikasi extends Model
{
    use HasFactory;
    protected $table = 'sertifikasi';
    protected $primaryKey = 'id';
    protected $fillable = [
        'noPek', 'namaPekerja', 'dept', 'namaProgram', 'tahunSertifikasi', 'tanggalPelaksanaanMulai', 'tanggalPelaksanaanSelesai', 'days', 'man_hours','total_man_hours','tempat', 'namaPenyelenggara'
    ];

    // Di model Anda (Sertifikasi)
    public function scopeFilterByDate($query, $bulan, $tahun)
    {
        return $query->where(function ($q) use ($bulan, $tahun) {
            $q->whereMonth('tanggalPelaksanaanMulai', $bulan)
                ->whereYear('tanggalPelaksanaanMulai', $tahun);
        })->orWhere(function ($q) use ($bulan, $tahun) {
            $q->whereMonth('tanggalPelaksanaanSelesai', $bulan)
                ->whereYear('tanggalPelaksanaanSelesai', $tahun);
        });
    }
}
