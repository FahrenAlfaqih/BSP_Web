<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spd extends Model
{
    use HasFactory;
    protected $table = 'spds';
    protected $fillable = [
        'nomor_spd',
        'nama',
        'dept',
        'wbs',
        'pr',
        'po',
        'ses',
        'mir7',
        'dari',
        'tujuan',
        'tanggal_dinas',
        'keterangan_dinas',
        'biaya_dpd',
        'rkap',
        'accrual',
        'submit_tgl',
    ];
}
