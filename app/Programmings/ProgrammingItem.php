<?php

namespace App\Programmings;

use Illuminate\Database\Eloquent\Model;

class ProgrammingItem extends Model
{
    protected $table = 'pro_programming_items';

    //protected $fillable = ['_token'];
    protected $fillable = ['id','activity_type','cycle', 'action_type', 'ministerial_program','activity_id','activity_name', 'def_target_population', 'source_population',
                           'cant_target_population', 'prevalence_rate', 'source_prevalence','coverture', 'population_attend', 'concentration',
                           'activity_group','workshop_number', 'workshop_session_number', 'workshop_session_time',
                           'activity_total', 'professional', 'activity_performance','hours_required_year', 'hours_required_day', 'direct_work_year',
                           'direct_work_hour', 'information_source', 'prap_financed','observation','workshop','active'];
}
