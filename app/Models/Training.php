<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;
    protected $fillable = [
        'judulPelatihan',
        'tglMulai',
        'tglSelesai',
        'man',
        'days',
        'hours',
        'total_man_hours',
        'hse',
        'nonhse',
        'inhouse',
        'sertifikasi',
        'teknikal',
    ];
}
