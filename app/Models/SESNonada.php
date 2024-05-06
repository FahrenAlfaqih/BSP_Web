<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SESNonada extends Model
{
    use HasFactory;
    protected $table = 'ses_nonada';
    protected $primaryKey = 'idNonadaSES';

    protected $fillable = [
        'idNonadaSES', 'idNonadaPO','judulPekerjaan'
    ];

    // Relasi one-to-one dengan SES
    public function poNonAda()
    {
        return $this->hasOne(PONonada::class);
    }
}
