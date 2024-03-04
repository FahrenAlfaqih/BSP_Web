<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PRReimburst extends Model
{
    use HasFactory;
    protected $table = 'pr_reimburst';
    protected $fillable = [
        'idReimburstPR', 'judulPekerjaan'
    ];
}
