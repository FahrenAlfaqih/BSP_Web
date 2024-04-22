<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'departments'; // Nama tabel dalam basis data

    protected $fillable = ['name', 'initial_fund']; // Kolom-kolom yang dapat diisi
}
