<?php

namespace App\Models\Programmings;

use Illuminate\Database\Eloquent\Relations\Pivot;

use OwenIt\Auditing\Contracts\Auditable;

class ProItemProHour extends Pivot implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'pro_programming_item_pro_hour';

    public $incrementing = true;

    protected $fillable = [
        'id', 'programming_item_id', 'professional_hour_id', 'activity_performance', 'designated_hours_weeks', 
        'hours_required_year', 'hours_required_day', 'direct_work_year', 'direct_work_hour'
    ];
}
