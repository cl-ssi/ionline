<?php

namespace App\Models\IdentifyNeeds;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Parameters\Estament;
use App\Models\Trainings\StrategicAxis;


class IdentifyNeed extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'user_id',
        'organizational_unit_id',
        'estament_id',

        /*
        'subject', 
        'reason', 'behaviors', 'performance_evaluation', 'observation_of_performance', 'report_from_other_users',
        'organizational_unit_indicators', 'other',
        'goal', 'expected_results','longterm_impact','immediate_results','performance_goals',
        'current_training_level','need_training_level','expertise_required',
        'justification','can_solve_the_need', 'organizational_unit_id', 
        */
    ];

    /**
     * Get the user that owns the identify need.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_creator_id')->withTrashed();
    }

    /**
     * Get the organizational unit that created the identify need.
     *
     * @return BelongsTo
     */
    public function organizationalUnit(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class, 'ou_creator_id')->withTrashed();
    }

    /**
     * Get the estament that owns the identify need.
     *
     * @return BelongsTo
     */
    public function estament(): BelongsTo
    {
        return $this->belongsTo(Estament::class);
    }

    /**
     * Get the estament that owns the identify need.
     *
     * @return BelongsTo
     */
    public function strategicAxis(): BelongsTo 
    {
        return $this->belongsTo(StrategicAxis::class);
    }

    /*
    public function learningGoals() {
        return $this->hasMany('App\Models\IdentifyNeeds\LearningGoal');
    }
    */

    protected $casts = [
        'created_at' => 'datetime'
    ];

    protected $table = 'dnc_identify_needs';
}
