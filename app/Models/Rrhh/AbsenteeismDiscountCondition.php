<?php

namespace App\Models\Rrhh;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsenteeismDiscountCondition extends Model
{
    use HasFactory;

    protected $table = 'well_ami_discount_conditions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'absenteeism_type_id', 'from'
    ];
}
