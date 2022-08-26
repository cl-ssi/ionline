<?php

namespace App\Models\Parameters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CutOffDate extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'cfg_cut_off_dates';

    protected $fillable = [
        'id', 'year', 'number', 'date'
    ];

    protected $dates = [
        'date'
    ];
}
