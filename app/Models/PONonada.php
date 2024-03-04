<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PONonada extends Model
{
    use HasFactory;
    protected $table = 'po_nonada';
    protected $fillable = [
        'idNonadaPO', 'idNonadaPR','judulPekerjaan'
    ];
    public function prNonada()
    {
        return $this->belongsTo(PRNonada::class);
    }

    // Relasi one-to-one dengan SES
    public function sesNonada()
    {
        return $this->hasOne(SESNonada::class);
    }
}
