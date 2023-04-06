<?php

namespace App\Models\Programmings;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ProgrammingDay extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'pro_programming_days';

    protected $fillable = [
        'weekends', 'national_holidays', 'noon_estament', 'noon_parties', 'holidays', 'administrative_permits', 'associations_lunches'
        , 'others', 'days_year', 'days_programming', 'day_work_hours', 'programming_id', 'training'
    ];
}
