<?php

namespace App\Models\Trainings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Training extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'status', 
        'user_training_id', 
        'estament_id', 
        'degree', 
        'contractual_condition_id', 
        'organizationl_unit_id', 
        'establishment_id',
        'email', 
        'telephone', 
        'strategic_axes_id', 
        'objective',
        'activity_name',
        'activity_type',
        'other_activity_type',
        'mechanism',
        'schuduled',
        'activity_date_start_at',
        'activity_date_end_at',
        'total_hours',
        'permission_date_start_at',
        'permission_date_end_at',
        'place',
        'working_day',
        'technical_reasons',
        'feedback_type',
        'user_creator_id'
    ];

    protected $table = 'tng_trainings';
}
