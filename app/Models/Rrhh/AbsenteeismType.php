<?php

namespace App\Models\Rrhh;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsenteeismType extends Model
{
    use HasFactory;

    protected $table = 'rrhh_absenteeism_types';

    protected $fillable = [
        'name',
        'discount',
        'half_day',
        'count_business_days',
    ];


}
