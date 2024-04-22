<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PRService extends Model
{
    use HasFactory;
    protected $table = 'pr_service';
    protected $primaryKey = 'idServicePR';
    protected $fillable = [
        'idServicePR', 'judulPekerjaan'
    ];
}
