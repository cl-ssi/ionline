<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/** TODO #106 mover a directorio models */
class Holiday extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date', 'name', 'region'
    ];
    
    /** Retorna si es feriado o domingo */
    public static function checkDate($date)
    {
        return (date('N', strtotime($date)) > 6) OR 
            Holiday::whereDate('date',$date)->get()->isNotEmpty();
    }



    public function getFormattedDateAttribute()
    {
        return Carbon::parse($this->date);
    }

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = [
        'date',
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $table = 'cfg_holidays';
}