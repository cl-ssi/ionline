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

    public function getValuesAcum($factor)
    {
        return $this->values->where('factor', $factor)->sum('value');
    }

    public function getCompliance()
    {
        if(isset($this->numerator_acum_last_year)) // REM P
            return $this->getLastValueByFactor('denominador') != 0 ? $this->getLastValueByFactor('numerador') / $this->getLastValueByFactor('denominador') * 100 : 0;
        else
            return $this->getValuesAcum('denominador') != 0 ? $this->getValuesAcum('numerador') / $this->getValuesAcum('denominador') * 100 : 0;
    }

    public function getValueByFactorAndMonth($factor, $month)
    {
        $result = $this->values->where('factor', $factor)->where('month', $month)->first();
        return $result != null ? $result->value : null;
    }

    public function getLastValueByFactor($factor)
    {
        $result = $this->values->where('factor', $factor)->last();
        return $result != null ? $result->value : null;
    }

    public function getContribution()
    {
        return $this->getCompliance() * $this->weighting / preg_replace('/[^0-9.]/', '', $this->goal);
    }
}
