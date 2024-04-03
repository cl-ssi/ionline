<?php

namespace App\Models\Rrhh;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class PerformanceReportPeriod extends Model
{
    use HasFactory;
    use SoftDeletes;


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rrhh_performance_report_periods';



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number',
        'name',
        'start_at',
        'end_at',
        'year',
    ];

    protected $casts = [
        'start_at'          => 'date:Y-m-d',
        'end_at'      => 'date:Y-m-d',
    ];






}
