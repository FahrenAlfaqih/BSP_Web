<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POService extends Model
{
    use HasFactory;
    protected $table = 'po_service';
    protected $primaryKey = 'idServicePO';
    protected $fillable = [
        'idServicePO', 'idServicePR','judulPekerjaan'
    ];
    
    public function prService()
    {
        return $this->belongsTo(PRService::class);
    }

    // Relasi one-to-one dengan SES
    public function sesService()
    {
        return $this->hasOne(SESService::class);
    }
}
