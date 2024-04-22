<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POReimburst extends Model
{
    use HasFactory;
    protected $table = 'po_reimburst';
    protected $primaryKey = 'idReimburstPO';
    protected $fillable = [
        'idReimburstPO', 'idReimburstPR','judulPekerjaan'
    ];
    public function prReimburst()
    {
        return $this->belongsTo(PRReimburst::class);
    }

    // Relasi one-to-one dengan SES
    public function sesReimburst()
    {
        return $this->hasOne(SESReimburst::class);
    }
}
