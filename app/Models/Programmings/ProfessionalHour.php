<?php

namespace App\Models\Programmings;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ProfessionalHour extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'pro_professional_hours';

    protected $fillable = [
        'professional_id', 'programming_id', 'value'
    ];

    public function professional(){
        return $this->belongsTo('App\Models\Programmings\Professional');
    }

    public function programming(){
        return $this->belongsTo('App\Models\Programmings\Programming');
    }

    public function programmingItems(){
        return $this->belongsToMany('App\Models\Programmings\ProgrammingItem', 'pro_programming_item_pro_hour')->withPivot('id', 'activity_performance', 'designated_hours_weeks', 'hours_required_year', 'hours_required_day', 'direct_work_year', 'direct_work_hour')->withTimestamps()->using(ProItemProHour::class);
    }
}
