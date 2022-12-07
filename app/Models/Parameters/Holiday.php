<?php

namespace App\Models\Parameters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\ClRegion;

class Holiday extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'name',
        'region_id'
    ];

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = [
        'date',
    ];

    protected $casts = [
        'date' => 'date:Y-m-d'
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

    public function Region()
    {
        return $this->belongsTo(ClRegion::class,'region_id');
    }

    /** Retorna si es feriado o domingo */
    public static function checkDate($date)
    {
        return (date('N', strtotime($date)) > 6) OR
            Holiday::whereDate('date',$date)->get()->isNotEmpty();
    }

    /* FIXME: ver si se utiliza y porqué, basta que esté en la variable $dates */
    public function getFormattedDateAttribute()
    {
        return Carbon::parse($this->date);
    }
}