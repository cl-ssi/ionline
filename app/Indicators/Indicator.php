<?php

namespace App\Indicators;

use Illuminate\Database\Eloquent\Model;

class Indicator extends Model
{
    protected $fillable = ['number', 'name', 'weighting_by_section', 'numerator',  
                           'numerator_source','denominator', 'denominator_source'];

    public function comges()
    {
        return $this->belongsTo('App\Indicators\Comges');
    }

    public function sections()
    {
        return $this->hasMany('App\Indicators\Section')->orderBy('number');
    }

    public function actions()
    {
        return $this->hasManyThrough('App\Indicators\Action', 'App\Indicators\Section');
    }
}
