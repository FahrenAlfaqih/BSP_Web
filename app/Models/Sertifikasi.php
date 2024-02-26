<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sertifikasi extends Model
{
    use HasFactory;
    protected $table = 'sertifikasi';
    protected $fillable = [
        'noPek', 'namaPekerja', 'dept', 'namaProgram', 'tahunSertifikasi', 'tanggalPelaksanaanMulai', 'tanggalPelaksanaanSelesai', 'days', 'tempat', 'namaPenyelenggara'
    ];

<<<<<<< HEAD
    public function scopeFilterByMonth($query, $bulan)
    {
        return $query->whereMonth('tanggalPelaksanaanMulai', $bulan);
=======
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
>>>>>>> 3852d5ec34040067431f7a6836a1b9f12fae9f39
    }
}
