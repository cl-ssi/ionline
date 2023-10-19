<?php

namespace App\Models\Rrhh;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Rrhh\AbsenteeismDiscountCondition;

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

    // public function type(): BelongsTo
    // {
    //     return $this->belongsTo(AbsenteeismDiscountCondition::class, 'absenteeism_type_id');
    // }

    public function discountCondition(): HasOne
    {
        return $this->hasOne(AbsenteeismDiscountCondition::class)->latestOfMany();
    }

}
