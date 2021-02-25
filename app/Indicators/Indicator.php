<?php

namespace App\Indicators;

use Illuminate\Database\Eloquent\Model;

class Indicator extends Model
{
    protected $fillable = ['number', 'name', 'weighting_by_section', 'numerator',  
                           'numerator_source','denominator', 'denominator_source',
                           'numerator_cods','numerator_cols','denominator_cods',
                           'denominator_cols','goal','weighting'];

    public function indicatorable()
    {
        return $this->morphTo();
    }

    public function sections()
    {
        return $this->hasMany('App\Indicators\Section')->orderBy('number');
    }

    public function actions()
    {
        return $this->hasManyThrough('App\Indicators\Action', 'App\Indicators\Section');
    }

    public function values()
    {
        return $this->morphMany('App\Indicators\Value', 'valueable')->orderBy('month');
    }
}
