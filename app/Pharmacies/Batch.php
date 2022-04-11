<?php

namespace App\Pharmacies;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    //
    protected $fillable = [
        'due_date','batch','count'
    ];

    protected $table = 'frm_batchs';
}
