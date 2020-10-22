<?php

namespace App\Programmings;

use Illuminate\Database\Eloquent\Model;

class ProgrammingDay extends Model
{
    protected $table = 'pro_programming_days';

    protected $fillable = [
        'weekends', 'national_holidays', 'noon_estament', 'noon_parties', 'holidays', 'administrative_permits', 'associations_lunches'
        , 'others', 'days_year', 'days_programming', 'day_work_hours', 'programming_id'
    ];
}
