<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundChange extends Model
{
    use HasFactory;
    protected $fillable = ['department_id', 'old_fund', 'new_fund', 'changed_at'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
