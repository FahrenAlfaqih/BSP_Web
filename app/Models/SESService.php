<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SESService extends Model
{
    use HasFactory;
    protected $table = 'ses_service';
    protected $primaryKey = 'idServiceSES';
    protected $fillable = [
        'idServiceSES', 'idServicePO','judulPekerjaan'
    ];

    // Relasi one-to-one dengan SES
    public function poService()
    {
        return $this->hasOne(POService::class);
    }
}
