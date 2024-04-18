<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dpd extends Model
{
    use HasFactory;
    protected $table = 'dpd';
    protected $fillable = [
        'nama',
        'nomorspd',
        'dept',
        'bsno',
        'pr',
        'po',
        'ses',
        'biayadpd',
        'submitfinec',
        'status',
        'paymentbyfinec',
        'keterangan'
    ];
}
