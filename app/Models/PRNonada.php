<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PRNonada extends Model
{
    use HasFactory;
    protected $table = 'pr_nonada';
    protected $primaryKey = 'idNonadaPR';
    protected $fillable = [
        'idNonadaPR', 'judulPekerjaan'
    ];
}
