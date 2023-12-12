<?php

namespace App\Models\IdentifyNeeds;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;


class IdentifyNeed extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'subject', 'reason', 'behaviors', 'performance_evaluation', 'observation_of_performance', 'report_from_other_users',
        'organizational_unit_indicators', 'other',
        'goal', 'expected_results','longterm_impact','immediate_results','performance_goals',
        'current_training_level','need_training_level','expertise_required',
        'justification','can_solve_the_need', 'organizational_unit_id', 'user_id'
    ];

    public function organizationalUnit() {
        return $this->belongsTo('App\Rrhh\OrganizationalUnit', 'organizational_unit_id')->withTrashed();
    }

    public function user() {
        return $this->belongsTo('App\User', 'user_id')->withTrashed();
    }

    protected $casts = [
        'created_at' => 'datetime'
    ];

    protected $table = 'dnc_identify_needs';
}
