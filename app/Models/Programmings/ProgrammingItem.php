<?php

namespace App\Models\Programmings;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ProgrammingItem extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    protected $table = 'pro_programming_items';

    //protected $fillable = ['_token'];
    protected $fillable = ['id','activity_type','cycle', 'action_type', 'ministerial_program','activity_id','activity_name', 'def_target_population', 'source_population',
                           'cant_target_population', 'prevalence_rate', 'source_prevalence','coverture', 'population_attend', 'concentration',
                           'activity_group','workshop_number', 'workshop_session_number', 'workshop_session_time',
                           'activity_total', 'professional', 'activity_performance','hours_required_year', 'hours_required_day', 'direct_work_year',
                           'direct_work_hour', 'information_source', 'prap_financed','observation','workshop','active', 'user_id', 'programming_id', 
                           'activity_subtype', 'activity_category', 'times_month', 'months_year', 'work_area', 'another_work_area', 'work_area_specs'];

    
    public function reviewItems()
    {
        return $this->hasMany('App\Models\Programmings\ReviewItem');
    }

    public function getCountReviewsBy($status)
    {
        return $this->reviewItems
            // ->where('rectified', $status == 'Not rectified' ? 'NO' : 'SI')
            ->when($this->programming->year <= 2023, function($q) use ($status){
                return $q->where('rectified', $status == 'Not rectified' ? 'NO' : 'SI');
            })
            ->where('answer', $status == 'Rectified' ? ($this->programming->year <= 2023 ? 'NO' : null) : ($status == 'Regularly rectified' ? 'REGULAR' : ($status == 'Accepted rectified' ? 'SI' : 'NO')))
            ->count();
    }

    public function activityItem(){
        return $this->belongsTo('App\Models\Programmings\ActivityItem', 'activity_id');
    }

    public function programming(){
        return $this->belongsTo('App\Models\Programmings\Programming');
    }

    public function user(){
        return $this->belongsTo('App\Models\User')->withTrashed();
    }

    public function professionalHour(){
        return $this->belongsTo('App\Models\Programmings\ProfessionalHour', 'professional');
    }

    public function professionalHours(){
        return $this->belongsToMany('App\Models\Programmings\ProfessionalHour', 'pro_programming_item_pro_hour')->withPivot('id', 'activity_performance', 'designated_hours_weeks', 'hours_required_year', 'hours_required_day', 'direct_work_year', 'direct_work_hour')->withTimestamps()->using(ProItemProHour::class);
    }

    public function rowspan(){
        return $this->professionalHours->count() > 0 ? $this->professionalHours->count() : 1;
    }
}
