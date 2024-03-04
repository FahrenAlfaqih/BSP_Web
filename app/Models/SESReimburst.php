<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SESReimburst extends Model
{
    use HasFactory;
    protected $table = 'ses_reimburst';
    protected $fillable = [
        'idSReimburstSES', 'idReimburstPO', 'judulPekerjaan'
    ];

   // public function poReimburst()
    //{
       // return $this->hasOne(POReimburst::class, 'foreign_key', 'local_key');
    //}
}
