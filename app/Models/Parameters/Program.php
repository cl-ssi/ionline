<?php

namespace App\Models\Parameters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cfg_programs';

    protected $fillable = [
        'name',
        'alias',
        'description',
        'start_date',
        'end_date',
    ];

    protected $dates = [
        'start_date',
        'end_date'
    ];

    public function getStartDateFormatAttribute()
    {
        $date = '-';
        if($this->start_date)
            $date = $this->start_date->format('Y-m-d');
        return $date;
    }

    public function getEndDateFormatAttribute()
    {
        $date = '-';
        if($this->end_date != null)
            $date = $this->end_date->format('Y-m-d');
        return $date;
    }
}
