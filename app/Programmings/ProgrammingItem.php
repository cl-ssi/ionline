<?php

namespace App\Programmings;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgrammingItem extends Model
{
    use SoftDeletes;
    protected $table = 'pro_programming_items';

    //protected $fillable = ['_token'];
    protected $fillable = ['id','activity_type','cycle', 'action_type', 'ministerial_program','activity_id','activity_name', 'def_target_population', 'source_population',
                           'cant_target_population', 'prevalence_rate', 'source_prevalence','coverture', 'population_attend', 'concentration',
                           'activity_group','workshop_number', 'workshop_session_number', 'workshop_session_time',
                           'activity_total', 'professional', 'activity_performance','hours_required_year', 'hours_required_day', 'direct_work_year',
                           'direct_work_hour', 'information_source', 'prap_financed','observation','workshop','active', 'user_id', 'programming_id'];

    
    public function reviewItems()
    {
        return $this->hasMany('App\Models\Programmings\ReviewItem');
    }

    public function getCountReviewsBy($status)
    {
        return $this->reviewItems
            ->where('rectified', $status == 'Not rectified' ? 'NO' : 'SI')
            ->where('answer', $status == 'Rectified' ? 'NO' : ($status == 'Regularly rectified' ? 'REGULAR' : ($status == 'Accepted rectified' ? 'SI' : 'NO')))
            ->count();
    }

    public function activityItem(){
        return $this->belongsTo('App\Programmings\ActivityItem', 'activity_id');
    }

    public function programming(){
        return $this->belongsTo('App\Programmings\Programming');
    }

    public function user(){
        return $this->belongsTo('App\User')->withTrashed();
    }

    public function professionalHour(){
        return $this->belongsTo('App\Programmings\ProfessionalHour', 'professional');
    }
}
