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

}
